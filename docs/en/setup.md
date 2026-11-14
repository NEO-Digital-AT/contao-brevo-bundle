---
title: Setup
summary: What Contao Brevo Newsletter needs in the Brevo account, where the API key is entered, how lists and templates reach the back end, and the environment variable as fallback.
audience: operations
language: en
updated: 2026-11-12
---

# Setup

## 1. In Brevo

| What | Where in Brevo | Why |
| --- | --- | --- |
| An API key | **SMTP & API** › **API keys** | The extension reads lists and templates and sends the sign-ups with it. |
| At least one contact list | **Contacts** › **Lists** | Confirmed contacts are added to it. |
| A double opt-in template | **Templates**: a template with the confirmation link of the double opt-in | Brevo sends the confirmation e-mail with it. |
| A verified sender | **Senders, domains and dedicated IPs** | Brevo sends the confirmation e-mail only from a verified sender. |

Write the template in the language of the website. For a website in several
languages, create one template per language.

## 2. API key in Contao

1. Open **NEO Digital › Access keys and licences**.
2. In the section **Brevo**, enter the key in **Brevo API key** and save.

One key serves all sign-up modules and form fields of the installation. The
key is stored encrypted and never shown again; the field then shows eight dots.
Leaving the field empty on a later save keeps the stored key.

Until a key is stored, every Brevo module and form field shows at the top:
"No Brevo API key stored yet. Until then no lists or templates can be chosen,
and the sign-up on the website does not work."

**Environment variable as fallback.** When no key is stored on the page, the
extension reads `BREVO_API_KEY` from the environment (e.g. `.env.local`). A
key on the page always wins.

## 3. Check the connection

The page *Access keys and licences* has no connection test for Brevo. The
form of a sign-up module shows whether the key works:

- **Contact list(s)** shows the lists of the account: the key works.
- The fields **Contact list(s)** and **DOI template** are greyed out with
  "Brevo gives no lists for the stored key (key wrong or Brevo not
  reachable): there is nothing to choose.": check the key and the outgoing
  connection to `api.brevo.com`.

## Lists and templates in the back end

The back end fetches lists and templates live from the Brevo account and keeps
them for one hour (one minute when Brevo gave none). A list or template created
in Brevo appears in the back end at the latest after this hour.

| Choice | What the back end offers |
| --- | --- |
| Lists | the 50 most recently created lists of the account, by name |
| Templates | the first 100 templates, as "Name (#ID)", inactive ones marked "– inactive" |

Without a key, or without an answer from Brevo, both fields are greyed out; a
choice stored earlier stays and is shown by its number (`#12`). A list that
Brevo no longer offers (deleted, or older than the 50 most recent lists) is
missing from the choice; saving the form then removes it from the module.

## Next steps

Create the sign-up module or the form field: [User manual](usage.md). The
licence box at the top of the module form has the credit for the legal notice
(see [User manual](usage.md#creating-the-sign-up-module)).
