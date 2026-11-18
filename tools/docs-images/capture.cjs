// Screenshots of the documentation (docs/<lang>/bilder/*.png) in a test installation, marked with the NEO
// annotation layer. See README.md in this folder.
//
//   node capture.cjs <en|de>
//
// Environment: NB_BASE (default http://127.0.0.1:8000), NB_ADMIN_USER / NB_ADMIN_PASSWORD, NB_MYSQL (default
// "mysql contao"), NB_PHP (command that runs PHP in the project, default "php"), NB_PROJECT (project directory,
// default "."), NB_ANNOTATE (path to annotate.js of the plugin neo-doku), NB_MODULE (id of the sign-up module,
// default 1).
const { chromium } = require('playwright');
const { execSync } = require('child_process');
const path = require('path');

const lang = process.argv[2] || 'en';
const env = (name, fallback) => process.env[name] || fallback;
const base = env('NB_BASE', 'http://127.0.0.1:8000');
const user = env('NB_ADMIN_USER', 'admin');
const password = env('NB_ADMIN_PASSWORD', '');
const mysql = env('NB_MYSQL', 'mysql contao');
const php = env('NB_PHP', 'php');
const project = env('NB_PROJECT', '.');
const moduleId = Number(env('NB_MODULE', '1'));
const out = path.resolve(__dirname, '../../docs', lang, 'bilder');
const annotate = env('NB_ANNOTATE', path.resolve(__dirname, '../../../NEO-Claude-Plugins/plugins/neo-doku/scripts/annotate.js'));
const sql = (query) => execSync(mysql + ' --default-character-set=utf8mb4 -N --raw -e "' + query.replace(/"/g, '\\"') + '"').toString().replace(/\r?\n$/, '');
const quote = (value) => "'" + String(value).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";

// Neutral texts of the sign-up module and of the website, per language.
const TEXT = {
  en: { headline: 'Newsletter', intro: 'News and tips once a month.', consent: 'Yes, send me the newsletter. I can unsubscribe at any time.', root: 'en' },
  de: { headline: 'Newsletter', intro: 'Neuigkeiten und Tipps einmal im Monat.', consent: 'Ja, senden Sie mir den Newsletter. Ich kann mich jederzeit abmelden.', root: 'de' },
}[lang];

// An empty box in document coordinates for neoAnnotate.frame().
const BOX = `window.docBox = function (left, top, right, bottom) {
  var el = document.createElement('div');
  el.style.cssText = 'position:absolute;pointer-events:none;left:' + (left + scrollX) + 'px;top:' + (top + scrollY) + 'px;width:' + (right - left) + 'px;height:' + (bottom - top) + 'px';
  document.body.appendChild(el);
  return el;
};`;

async function marked(page) {
  await page.addStyleTag({ content: '.sf-toolbar,.sf-minitoolbar{display:none!important}' });
  await page.evaluate(() => document.fonts.ready);
  await page.addScriptTag({ path: annotate });
  await page.addScriptTag({ content: BOX });
}

(async () => {
  if (!password || !TEXT) {
    console.error('Set NB_ADMIN_PASSWORD; language en or de.');
    process.exit(2);
  }
  const language = sql("SELECT language FROM tl_user WHERE username = '" + user + "'");
  const rootLanguage = sql("SELECT language FROM tl_page WHERE type = 'root' ORDER BY sorting LIMIT 1");
  const before = sql(`SELECT CONCAT_WS(CHAR(9), IFNULL(brevo_intro, ''), brevo_consent, brevo_button, brevo_mode) FROM tl_module WHERE id = ${moduleId}`);
  sql("UPDATE tl_user SET language = '" + lang + "' WHERE username = '" + user + "'");
  sql(`UPDATE tl_page SET language = '${TEXT.root}' WHERE type = 'root'`);
  sql(`UPDATE tl_module SET headline = ${quote(`a:2:{s:4:"unit";s:2:"h2";s:5:"value";s:${Buffer.byteLength(TEXT.headline)}:"${TEXT.headline}";}`)}, brevo_intro = ${quote(TEXT.intro)}, brevo_consent = ${quote(TEXT.consent)}, brevo_button = '', brevo_mode = 'fixed' WHERE id = ${moduleId}`);
  // Lists and template as a Brevo account would answer (demo-lists.php), so the back end shows a filled form.
  execSync(`${php} ${path.join(__dirname, 'demo-lists.php')} ${project} ${lang}`, { stdio: 'inherit' });

  const browser = await chromium.launch();
  const context = await browser.newContext({ viewport: { width: 1280, height: 800 }, deviceScaleFactor: 2, reducedMotion: 'reduce', colorScheme: 'light', locale: lang === 'de' ? 'de-AT' : 'en-GB', timezoneId: 'Europe/Vienna' });
  const page = await context.newPage();
  await page.goto(base + '/contao/login');
  await page.fill('input[name="username"]', user);
  await page.fill('input[name="password"]', password);
  await Promise.all([page.waitForNavigation(), page.click('button[type="submit"]')]);

  // 1. The sign-up module in the back end: licence box, lists, double opt-in, form texts.
  await page.goto(base + `/contao?do=themes&table=tl_module&act=edit&id=${moduleId}`, { waitUntil: 'networkidle' });
  await marked(page);
  const end = await page.evaluate(() => document.getElementById('pal_messages_legend').getBoundingClientRect().top + scrollY);
  const left = await page.evaluate(() => document.querySelector('#main').getBoundingClientRect().left);
  // Viewport as tall as the page, so the sticky save bar sits at the end of the form, outside the picture.
  await page.setViewportSize({ width: 1280, height: await page.evaluate(() => document.documentElement.scrollHeight) });
  await page.waitForTimeout(300);
  await page.evaluate(() => {
    const frame = (id, number) => {
      const r = document.getElementById(id).getBoundingClientRect();
      neoAnnotate.frame(docBox(r.left + 2, r.top - 2, r.right - 2, r.bottom - 2), { number, padding: 0 });
    };
    frame('pal_licence_legend', 1);
    frame('pal_lists_legend', 2);
    frame('pal_doi_legend', 3);
    frame('pal_form_legend', 4);
  });
  // The content area only (the menu on the left is Contao's own).
  await page.screenshot({ path: path.join(out, 'module-form.png'), clip: { x: Math.max(0, left - 12), y: 60, width: 1280 - Math.max(0, left - 12), height: Math.ceil(end) - 60 } });

  // 2. The form on the page, as a visitor sees it.
  const visitor = await (await browser.newContext({ viewport: { width: 1280, height: 900 }, deviceScaleFactor: 2, reducedMotion: 'reduce', locale: lang === 'de' ? 'de-AT' : 'en-GB' })).newPage();
  await visitor.goto(base + '/', { waitUntil: 'networkidle' });
  // The test website has no layout of its own: a font and a margin, as any website gives the form.
  await visitor.addStyleTag({ content: 'body{margin:0;padding:24px 48px;font-family:Arial,Helvetica,sans-serif}' });
  await visitor.evaluate(() => document.fonts.ready);
  await visitor.addScriptTag({ path: annotate });
  await visitor.addScriptTag({ content: BOX });
  const form = visitor.locator('.brevo-nl').first();
  await form.scrollIntoViewIfNeeded();
  await visitor.evaluate(() => {
    const at = (selector, number) => {
      const r = document.querySelector('.brevo-nl ' + selector).getBoundingClientRect();
      // Room on the left for the number, so it covers no text.
      neoAnnotate.frame(docBox(r.left - 22, r.top - 8, r.right + 6, r.bottom + 6), { number, padding: 0 });
    };
    at('.brevo-nl__row', 1);
    at('.brevo-nl__consent', 2);
    at('.brevo-nl__btn', 3);
  });
  // From the heading of the module to its button.
  const box = await form.boundingBox();
  const title = await visitor.locator('.brevo-nl .brevo-nl__title').first().boundingBox();
  const last = await visitor.locator('.brevo-nl .brevo-nl__btn').first().boundingBox();
  await visitor.screenshot({ path: path.join(out, 'signup-form.png'), clip: { x: Math.max(0, box.x - 40), y: title.y - 12, width: Math.min(620, box.width + 76), height: last.y + last.height - title.y + 32 } });

  await browser.close();
  const [intro, consent, button, mode] = before.split('\t');
  sql(`UPDATE tl_module SET brevo_intro = ${quote(intro)}, brevo_consent = ${quote(consent)}, brevo_button = ${quote(button)}, brevo_mode = ${quote(mode)} WHERE id = ${moduleId}`);
  sql(`UPDATE tl_page SET language = '${rootLanguage}' WHERE type = 'root'`);
  sql("UPDATE tl_user SET language = '" + language + "' WHERE username = '" + user + "'");
  console.log(path.join(out, 'module-form.png'), path.join(out, 'signup-form.png'));
})();
