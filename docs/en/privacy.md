---
title: Privacy
summary: What Contao Brevo Newsletter stores, which data goes to Brevo and when, what is logged, and what belongs in the privacy policy of the website.
audience: operations
language: en
updated: 2026-11-12
---

# Privacy

The form sends the sign-up to the website's own server, which passes it on to
Brevo. The browser of the visitor loads nothing from Brevo: no script, no
cookie, no font. The sign-up form therefore needs no entry in a cookie banner.

## What goes to Brevo

| When | What | Where to |
| --- | --- | --- |
| A visitor sends the sign-up module | e-mail address, the lists, the number of the double opt-in template, the address of the confirmation page | Brevo API (`api.brevo.com`) |
| A visitor sends a form with **Brevo sign-up** ticked | e-mail address, first and last name if mapped (attributes `VORNAME`, `NACHNAME`), the lists, template, confirmation page | Brevo API |
| An editor opens a module or form field in the back end | the API key, to read lists and templates | Brevo API |

Brevo (Sendinblue SAS, Paris) then sends the confirmation e-mail, keeps the
contact and adds it to the lists after the confirmation. What Brevo stores and
for how long is set in the Brevo account and its terms.

## What the website stores

| What | Where | How long |
| --- | --- | --- |
| The e-mail address of the sign-up | not stored and not logged by the extension | – |
| The IP address, for the limit of 8 attempts per minute | as a hash in the application cache | one minute |
| The Brevo API key | page *Access keys and licences*, encrypted with the app secret | until changed |
| Lists and templates of the account (names and numbers) | application cache | one hour |
| Errors at Brevo: status, message of Brevo, template number, list numbers, confirmation page; never the e-mail address | log file of the installation (`var/logs/`) | as the log rotation of the installation |
| Failed sign-ups: name and ID of the module or form field, the reason (missing setting, status and message of Brevo); never the e-mail address | **System › System log** (with the browser identification and the address of the request, as Contao records them for every entry) | as set under **System › Settings › Storage time for log entries** |

The form generator can store or send the other data of a form as configured
in Contao (**Store data**, **Send form data via e-mail**); that is not part of
this extension.

## Privacy policy

The privacy policy of the website should describe:

- the newsletter sign-up with double opt-in and the data sent to Brevo
  (table above), Brevo as processor and its seat in the EU;
- the purpose (sending the newsletter) and the consent as the basis;
- how subscribers unsubscribe (the unsubscribe link in the e-mails sent by
  Brevo) and withdraw their consent.

Link the privacy policy in the **Consent text** of the module, e.g. with
`{{link::privacy::Privacy policy}}`, and in the **Checkbox text** or the form
of a form field.
