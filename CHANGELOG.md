# Changelog

All notable changes to this extension are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versions follow
[Semantic Versioning](https://semver.org/).

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
