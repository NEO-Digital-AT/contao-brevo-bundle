---
title: Installation
summary: Requirements, installing Contao Brevo Newsletter with the Contao Manager or Composer, public files, back-end languages, updating from an earlier version and removing.
audience: operations
language: en
updated: 2026-11-12
---

# Installation

## Requirements

| What | Needed for |
| --- | --- |
| Contao 5.3 to 6.0 (`contao/core-bundle ^5.3 \|\| ^6.0`) | everything |
| PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs 8.3, Contao 6.0 needs 8.4) | everything |
| `neo-digital/contao-basic-bundle` | installed automatically; it provides the menu group and the page **Access keys and licences** that holds the Brevo API key. The extension needs no licence key. |
| A Brevo account with an API key, at least one contact list and a double opt-in template | every sign-up (see [Setup](setup.md)) |
| Outgoing HTTPS connections from the server to `api.brevo.com` | lists, templates and sign-ups |

## Installing with the Contao Manager

1. Open the Contao Manager.
2. Search for `neo-digital/contao-brevo-bundle`.
3. Click **Add** and then **Apply changes**.
4. When the Contao Manager asks, run the database update and apply all changes
   it proposes.

## Installing with Composer

```bash
composer require neo-digital/contao-brevo-bundle
php vendor/bin/contao-console contao:migrate
```

`contao:migrate` adds the fields of the module to `tl_module` and of the form
field to `tl_form_field`, and the field of the API key to the page *Access
keys and licences*. Composer copies script and stylesheet of the form to
`public/bundles/neobrevonewsletter/`; if that did not happen, run:

```bash
php vendor/bin/contao-console assets:install
```

### From a local folder

To install the package from a folder of the project, e.g. while adapting it,
use a path repository in `composer.json`:

```json
"repositories": [{ "type": "path", "url": "bundles/contao-brevo-bundle", "options": { "symlink": true } }],
"require": { "neo-digital/contao-brevo-bundle": "@dev" }
```

## After the installation

The extension adds the front-end module type **Brevo Newsletter** (group *NEO
Digital*), the form field type **Brevo sign-up** and the section **Brevo** on
**NEO Digital › Access keys and licences**. Continue with [Setup](setup.md).

## Back-end languages

The back end and the default texts of the form are available in English,
German, French, Dutch, Italian, Polish, Czech, Hungarian, Slovenian, Croatian
and Spanish. A file `translations/neo_brevo.<language>.yaml` in the project
overrides single default texts or adds a language. Contao offers Hungarian and
Croatian as back-end languages only once they are enabled in
`config/config.yaml`:

```yaml
contao:
    intl:
        enabled_locales: ['+hu', '+hr']
```

## Updating

1. Update the package with the Contao Manager or with
   `composer update neo-digital/contao-brevo-bundle`.
2. Run the database update (`contao:migrate`).
3. Read `CHANGELOG.md` of the new version. When a version needs new
   permissions or a step after the update, the changelog says so.

**From a version that kept the key in the system settings.** `contao:migrate`
takes the API key from *System › Settings* over to *Access keys and licences*
once. A key already stored there is kept. The old value stays in
`system/config/localconfig.php` and is no longer read; delete it there when
convenient.

## Removing

1. Delete the front-end modules **Brevo Newsletter** and the form fields
   **Brevo sign-up**, or replace them.
2. Remove the package with the Contao Manager or with
   `composer remove neo-digital/contao-brevo-bundle`.
3. Run the database update. Contao then offers to delete the fields of the
   extension in `tl_module`, `tl_form_field` and `tl_neo_access`.

The contacts stay in the Brevo account.
