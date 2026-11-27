---
title: Customising
summary: Adapting the sign-up form of Contao Brevo Newsletter to the design of the website – CSS variables, overriding the template and how script and stylesheet are loaded.
audience: operations
language: en
updated: 2026-11-27
---

# Customising

The form comes in a neutral design. It is adapted in the website, not in the
extension: with CSS variables, with an overridden template and with the texts
of the module ([User manual](usage.md#creating-the-sign-up-module)). The form
field **Brevo sign-up** is a checkbox of the form generator and takes the
design of the form.

## CSS variables

The variables sit on `.brevo-nl`. Set them in a stylesheet of the website,
e.g.:

```css
.brevo-nl {
    --bn-accent: #0b6e4f;
    --bn-accent-dark: #085a40;
    --bn-radius: 4px;
}
```

| Variable | Default | Use |
| --- | --- | --- |
| `--bn-accent` | `#1f2328` | button, focus ring, checkboxes |
| `--bn-accent-dark` | `#000000` | button on hover |
| `--bn-on-accent` | `#ffffff` | text of the button |
| `--bn-bg` | `#ffffff` | background of the fields |
| `--bn-border` | `#818b98` | border of the fields; keep at least 3:1 to the background |
| `--bn-text` | `#1f2328` | text |
| `--bn-muted` | `#59636e` | labels, intro, consent text; keep at least 4.5:1 |
| `--bn-link` | `#0969da` | link in the consent text |
| `--bn-ok`, `--bn-err` | `#1a7f37`, `#cf222e` | success and error messages |
| `--bn-radius` | `8px` | corners |
| `--bn-font` | `inherit` | font |

The additional fields stand in `.brevo-nl__fields`, each in a
`.brevo-nl__row--<field>` (`firstname`, `lastname`, `sms`, `landline`,
`job_title`); first and last name stand side by side from a width of 36 rem.
The note without JavaScript is `.brevo-nl__noscript`.

## Template

Copy `contao/templates/frontend_module/brevo_newsletter.html.twig` of the
extension to `templates/frontend_module/` of the website and change it there.
Under the same name it applies to every sign-up module. A variant for single
modules goes into a folder of that name, e.g.
`templates/frontend_module/brevo_newsletter/footer.html.twig`, and is chosen
in the module under **Module template**. Keep:

- the attributes `data-brevo-form` and `data-challenge="{{ challengeUrl }}"` on
  the form (the second one tells the script where to fetch the task of the spam
  protection; without it, every sign-up is refused);
- the field names `mod`, `email`, `website` (hidden field against spam bots),
  `consent` and `lists`;
- on each additional field the attribute `data-brevo-field="{{ f.key }}"` (the
  fields come as `fieldsBefore` and `fieldsAfter`: before and after the e-mail
  field, each with `key`, `label`, `type`, `autocomplete`, `required`,
  `maxlength`);
- the status element `.brevo-nl__msg` with its `data-*` attributes (it
  carries the messages of the module; since 1.1.0 also `data-fields`,
  `data-phone`, `data-repeat` and `data-verify`);
- the note `<noscript>{{ noscript }}</noscript>` for visitors without
  JavaScript.

The script finds the form and the fields by them. After an update of the
extension, compare the overridden template with the new version.

## How script and stylesheet are loaded

`brevo-newsletter.css` and `brevo-newsletter.js` are handed to Contao like the
files of the page layout, so **Combine scripts** in the layout includes them.
They are added only on pages where a sign-up module is placed with the content
element **Module** in an article of the page, or in a section of the page
layout. A module placed in another way (insert tag, included article) gets
neither script nor stylesheet: the form then sends without JavaScript and has
no styles.
