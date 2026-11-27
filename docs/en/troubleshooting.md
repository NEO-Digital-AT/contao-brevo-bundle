---
title: Troubleshooting
summary: Common problems with Contao Brevo Newsletter – no lists in the back end, sign-up fails, no confirmation e-mail, form without styles, missing permissions – with cause and solution.
audience: operations
language: en
updated: 2026-11-27
---

# Troubleshooting

Every sign-up that does not reach Brevo is an error in **System › System
log**, with the module or form field and the reason: "Brevo newsletter: a
sign-up in the module "…" (ID …) failed, the visitor was not subscribed: …"
(module) or "Brevo newsletter: the sign-up through the form field "…" (ID …,
form ID …) failed …" (form field). The reason is one of: the module or field
is not complete (with what is missing: API key, list, DOI template,
confirmation page), Brevo refused it (with Brevo's status and message), or
there was no answer from Brevo. The log file of the installation
(`var/logs/`) also has Brevo's full answer with template, lists and
confirmation page: "Brevo rejected the sign-up (HTTP …): …". The e-mail
address is never logged. Missing fields in the back end are nearly always
missing permissions; see [Permissions](permissions.md).

## Back end

| What you see | Why | What to do |
| --- | --- | --- |
| "No Brevo API key stored yet. …" at the top of the module or form field | No key on *Access keys and licences* and no `BREVO_API_KEY` | Enter the key ([Setup](setup.md#2-api-key-in-contao)). |
| **Contact list(s)** and **DOI template** greyed out: "Brevo gives no lists for the stored key …" | The key is wrong or revoked, the account has no list, or the server cannot reach `api.brevo.com` | Check the key in Brevo and the outgoing connection; create a list. The key starts with `xkeysib-`; an SMTP key (`xsmtpsib-`) does not work. Since 1.1.0 the "MCP server API key" (long text starting with `eyJ`) works too: the extension takes the key out of it. |
| A new list or template is missing in the choice | The back end keeps lists and templates for one hour | Wait up to an hour. |
| A list is missing although it exists | Only the 50 most recently created lists are offered | Delete unused lists in Brevo, or create the list again. |
| A template is marked "– inactive" | The template is not active in Brevo | Activate it in Brevo. |
| **Label of the list choice** is greyed out | Mode is *Fixed* | Intended; the field is used with *Choice* only. |
| **E-mail field** offers no field | The form has no text, text area or hidden field with a field name | Add the e-mail field to the form first and give it a field name. |
| Module type **Brevo Newsletter** or field type **Brevo sign-up** missing | The group lacks it under **Front end modules** or **Form fields** | Grant it ([Permissions](permissions.md)). |

## Front end

| What you see | Why | What to do |
| --- | --- | --- |
| "Something went wrong. …" on every sign-up | The module is not complete (key, list, template or confirmation page missing), or Brevo refused the request | Complete the module; **System › System log** names what is missing or Brevo's message. |
| System log: Brevo says the template is not a double opt-in template | The chosen template has no double opt-in confirmation link | Choose or create a double opt-in template in Brevo. |
| System log: Brevo refuses the sender | The sender of the template is not verified in Brevo | Verify the sender in Brevo. |
| System log: Brevo refuses the redirection URL | The confirmation page has no valid public address | Choose a published page; check the domain of the root page. |
| No confirmation e-mail, but the success message appeared | Brevo accepted the request; the e-mail is in spam, or the address is already a confirmed contact | Check spam; check the contact in Brevo. |
| "Too many attempts. …" | A limit of the spam protection: 5 attempts in 10 minutes, 2 sign-ups an hour or 3 a day from the same connection, or the module's **Sign-ups per hour** / **per day** for all visitors together | Wait. If real visitors are refused regularly, raise the module's limits ([Spam protection](usage.md#spam-protection)). |
| System log: "the limit of … sign-ups an hour (a day) is reached …" | More sign-ups than the module allows; typical of bots that enter other people's addresses | Nothing is urgent, the limit holds. Check the latest confirmation e-mails in Brevo (**Transactional › Logs**, tag `optin`). |
| "A confirmation e-mail has already been sent to this address. …" | The same address was signed up within the last 24 hours | Look for the first e-mail (also in spam); test with another address. |
| "The security check did not work. …" | The invisible task was not solved: the page was open for more than an hour, a script blocker stopped `/api/brevo/challenge`, the page does not run over HTTPS (browsers offer the needed functions only there), or a very old browser | Reload the page; use HTTPS; allow `/api/brevo/challenge` in a firewall or blocker. |
| "Please enable JavaScript to sign up." | JavaScript is off; the spam protection needs it | Intended. |
| "Please enter the phone number in international format …" | A mobile or landline number without `+` (or `00`) and country code | Enter it as e.g. `+` country code and number. |
| "Please fill in all required fields." | A required additional field is empty | Fill it in, or untick it under **Required fields**. |
| System log: "Brevo refused the attributes …; the visitor is signed up without them" | The account lacks the attribute, or the mobile number already belongs to another contact in Brevo | Create the attribute in Brevo or choose it under **Brevo attribute for the first name / last name**; a duplicate mobile number stays without number. |
| Additional fields are missing in Brevo although filled in | See the line above | – |
| "Please enter a valid e-mail address." although the address is right | The consent checkbox was not ticked | Tick it. |
| The form has no styles and reloads the page on sending | Script and stylesheet are missing: the module is placed by insert tag or in an included article | Place it with the content element **Module** or in the page layout ([Customising](customising.md#how-script-and-stylesheet-are-loaded)). |
| A list choice shows `#12` instead of a name | Brevo did not give the name of the list | Enter a display name under **Display names (optional)**. |
| The form field signs nobody up | The checkbox was not ticked; or the **E-mail field** maps a field without a valid address; or the form field is not complete | Check the field mapping; **System › System log** names a missing setting or Brevo's message. |
| First and last name are missing in Brevo | The account has no attributes `VORNAME` and `NACHNAME`; the extension then signs up without names | Create the attributes in Brevo. |
