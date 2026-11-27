# Changelog

All notable changes to this extension are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versions follow
[Semantic Versioning](https://semver.org/).

## [1.1.0] - 2026-11-27

Spam protection against "subscription bombing": bots entered the addresses of real people in sign-up forms, so that the victims drown in confirmation e-mails, each of which costs the website sending quota and sender reputation. Update recommended for every installation. After updating: update the database. No setting is needed; the protection is on.

### Added
- **Spam protection of the sign-up module, built in and always on:**
  - an invisible proof-of-work task in the format of ALTCHA: the browser fetches it from `GET /api/brevo/challenge` when the visitor starts filling in the form and solves it in the background; the server accepts a solution once, within one hour, and only two seconds after the task was handed out (signed with the app secret, no cookie, nothing from third parties);
  - refusal of sign-ups sent from another website (`Origin`, `Sec-Fetch-Site`) and of scripts and automated browsers (user agent);
  - one confirmation e-mail per address in 24 hours (the address only as a keyed hash in the cache);
  - at most 2 sign-ups an hour and 3 a day per visitor (connection);
  - new module fields **Sign-ups per hour** and **Sign-ups per day** for all visitors together (presets 5 and 20, `0` = no limit); when the limit is reached, an error in **System › System log**, once an hour.
- The form field **Brevo sign-up** of the form generator also sends one confirmation e-mail per address in 24 hours.
- **Additional fields** in the module: first name, last name, mobile number (`SMS`), landline (`LANDLINE_NUMBER`) and job title (`JOB_TITLE`), each switched on separately and optional or required; the name attributes automatic (default attribute of the account, e.g. `FIRSTNAME` or `VORNAME`) or chosen from the attributes of the account. Phone numbers are checked for the international format. If Brevo refuses the attributes, the visitor is signed up without them and the system log says so.
- New messages, each editable in the module: required field empty, phone number not international, address already signed up, security check failed; labels of the additional fields; note for visitors without JavaScript. Defaults in all eleven languages.
- The "MCP server API key" of Brevo (base64 text starting with `eyJ`) is accepted as API key; the extension takes the key out of it.

### Changed
- Limit of attempts per visitor: 5 in 10 minutes (before: 8 a minute). The client is kept only as a hash.
- The sign-up module needs JavaScript (the spam protection is solved by the browser). Without it, the form shows a note and the sign-up is refused.
- Templates overriding `frontend_module/brevo_newsletter` need `data-challenge="{{ challengeUrl }}"` on the form, otherwise every sign-up is refused as "security check failed"; additional fields need `data-brevo-field` ([Customising](docs/en/customising.md#template)).
- Default text "Too many attempts. Please try again later." (before: "… in a few minutes").

### Fixed
- The section heading "Text" of the module form was shown as `text_legend`.

## [1.0.0] - 2026-11-13

Initial release. Runs on Contao 5.3 to 6.0 with PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs PHP 8.3, Contao 6.0 PHP 8.4).

### Added
- Front-end module **Brevo Newsletter**: sign-up with Brevo double opt-in, with its own lists, double opt-in template, confirmation page and texts per module (e.g. one per language).
- Form field **Brevo sign-up**: a checkbox for any form of the form generator that signs the sender up with double opt-in while the rest of the form runs unchanged.
- One API key for the installation on **Access keys and licences**, stored encrypted.
- Lists and double opt-in templates chosen live from the Brevo account; display names per list; mode *Fixed* (all chosen lists) or *Choice* (visitors pick).
- Limit of 8 attempts per minute, hidden field against spam bots, required consent checkbox, status messages for screen readers.
- Every visible text editable per module, defaults in eleven languages; neutral design through CSS variables; back end in eleven languages; documentation in English and German; unit tests.

After installing: update the database, then enter the Brevo API key under **NEO Digital › Access keys and licences**.
