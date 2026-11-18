# Documentation images

The images in `docs/<lang>/bilder/` are screenshots of a test installation,
marked with the NEO annotation layer (frames and numbers): the sign-up module
in the back end (`module-form.png`) and its form on a page
(`signup-form.png`). `capture.cjs` takes them again, for example after a change
to the module or the template. This folder is not part of the Composer package
(`.gitattributes`: `export-ignore`).

## What the test installation needs

- Contao with this bundle, a sign-up module (its id in `NB_MODULE`) placed on
  the start page with the content element **Module**, and a key on *Access
  keys and licences* (any value: no request goes to Brevo).
- `demo-lists.php` puts example lists ("Newsletter", "Customers") and a double
  opt-in template into the cache under that key, where the back end looks for
  Brevo's answer, so the module form shows a filled choice. It runs with the
  PHP of the installation (`NB_PHP`) and needs the project directory
  (`NB_PROJECT`).
- An administrator (`NB_ADMIN_USER`).
- Node.js with Playwright and its Chromium, and the plugin `neo-doku` of
  `NEO-Claude-Plugins` (`annotate.js`) next to this repository, or its path in
  `NB_ANNOTATE`.

## Taking the images

```bash
NB_ADMIN_PASSWORD=… NB_MODULE=12 node tools/docs-images/capture.cjs en
NB_ADMIN_PASSWORD=… NB_MODULE=12 node tools/docs-images/capture.cjs de
```

The script sets the back-end language of the administrator and the language of
the website root to the language of the images, gives the module neutral texts
(heading, intro, consent text, mode *Fixed*) and restores all of it at the end.
Do not run two captures at the same time.

| Variable | Default | Meaning |
| --- | --- | --- |
| `NB_BASE` | `http://127.0.0.1:8000` | Address of the test installation |
| `NB_ADMIN_USER`, `NB_ADMIN_PASSWORD` | `admin`, – | Administrator |
| `NB_MYSQL` | `mysql contao` | Command for the database of the test installation |
| `NB_PHP` | `php` | Command that runs PHP for the installation (e.g. in its container) |
| `NB_PROJECT` | `.` | Project directory of the installation, as `NB_PHP` sees it |
| `NB_MODULE` | `1` | Id of the sign-up module |
| `NB_ANNOTATE` | `../NEO-Claude-Plugins/plugins/neo-doku/scripts/annotate.js` | Annotation layer |

Check every image after taking it: frames on the right sections, no real
names, addresses or keys.
