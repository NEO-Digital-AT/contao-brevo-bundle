---
title: User manual
summary: Creating and placing the sign-up module Brevo Newsletter, every field of its form, the additional fields (name, phone, job title), the built-in spam protection, the form field Brevo sign-up in a form of the form generator, websites in several languages and testing a sign-up.
audience: users
language: en
updated: 2026-11-27
---

# User manual

The extension offers two ways to sign visitors up:

| Way | Use |
| --- | --- |
| Front-end module **Brevo Newsletter** | A form of its own: e-mail address, optional additional fields (first and last name, mobile, landline, job title), optional list choice, consent checkbox, button; built-in spam protection |
| Form field **Brevo sign-up** | A checkbox in any form of the form generator, e.g. the contact form; ticked, it signs the sender up as well |

Both use double opt-in: Brevo sends a confirmation e-mail, and the contact is
added to the lists only after the visitor clicks its link. The link leads to
the confirmation page chosen in the back end.

Prerequisite: the Brevo API key is stored (see [Setup](setup.md)).

## Creating the sign-up module

1. Open **Layout › Themes**, the theme, then **Front end modules**, and click
   **New**.
2. **Module type**: **Brevo Newsletter** (group *NEO Digital*). The form
   reloads.
3. The box **Licence** at the top states the condition of the free licence:
   the legal notice of every website on which the extension runs publicly names
   it with a link. It has the credit as text with link ("Newsletter sign-up:
   Contao Brevo Newsletter by NEO Digital") and as HTML to copy.
4. Fill in the fields (table below) and save.

![The form of the sign-up module in the back end. Frame 1 marks the box
"Licence" with the credit to copy, frame 2 the section "Lists" with the
contact lists of the account and the mode, frame 3 the section "Double
opt-in" with the DOI template and the confirmation page, frame 4 the section
"Form" with the texts of the form.](bilder/module-form.png)

The numbers in the picture: 1 the box **Licence**, 2 the section *Lists*, 3 the
section *Double opt-in*, 4 the section *Form*.

| Section | Field | Required | Meaning |
| --- | --- | --- | --- |
| Title and type | **Headline** | no | Heading above the form, with its level (preset `h2`) |
| Text | **Intro** | no | Text above the form |
| Lists | **Contact list(s)** | yes | The Brevo lists of the account. With mode *Fixed*, the contact goes to all of them; with *Choice*, these are the lists visitors can choose from. |
| | **Mode** | – | **Fixed – always the selected lists** (preset) or **Choice – visitor picks in the front end** |
| | **Choice type** (only with *Choice*) | – | **Single choice (select box)** or **Multiple choice (checkboxes)** |
| | **Display names (optional)** (only with *Choice*) | no | Own label per list: key = Brevo list ID, value = display name. Empty: the name in Brevo. |
| Double opt-in | **DOI template** | yes | The double opt-in template of the account; Brevo sends the confirmation e-mail with it |
| | **Confirmation page** | yes | The page the link in the confirmation e-mail leads to, e.g. "Thank you for confirming" |
| Form | **E-mail field label** | no | Label of the e-mail field |
| | **Button text** | no | Text of the button |
| | **Consent text** | yes | Text next to the required consent checkbox. Insert tags are allowed, e.g. `{{link::privacy::Privacy policy}}`. |
| | **Success message** | no | Shown after a successful sign-up |
| Additional fields | **Additional fields** | no | Fields shown besides the e-mail address, stored with the contact in Brevo: **First name**, **Last name**, **Mobile number** (Brevo attribute `SMS`), **Landline** (`LANDLINE_NUMBER`), **Job title** (`JOB_TITLE`). None ticked: only the e-mail address (as before 1.1.0). See [Additional fields](#additional-fields). |
| | **Required fields** | no | Ticked fields must be filled in; the others are marked "(optional)" on the page. Only fields that are shown count. |
| | **Brevo attribute for the first name** / **… for the last name** | no | **Automatic** (preset): the default attribute of the account (`FIRSTNAME`, `VORNAME`, `PRENOM` …). Or an attribute of the account. Greyed out while the name field is not shown. |
| Spam protection | **Sign-ups per hour** | no | Confirmation e-mails an hour for all visitors together; preset 5, `0` = no limit. See [Spam protection](#spam-protection). |
| | **Sign-ups per day** | no | The same per calendar day; preset 20, `0` = no limit. |
| Field labels | **Label: first name** … **Label: job title** | no | Labels of the additional fields |
| Messages | **Label of the list choice** | no | Heading of the list choice; greyed out unless the mode is *Choice* |
| | **Message: invalid e-mail address** | no | |
| | **Message: required field empty** | no | |
| | **Message: phone number not international** | no | |
| | **Message: no list chosen** | no | |
| | **Message: address already signed up** | no | |
| | **Message: too many attempts** | no | |
| | **Message: security check failed** | no | |
| | **Message: other error** | no | |

Every empty text field shows its default in grey. On the page, the default
comes in the language of the page. The sections **Template settings**,
**Access protection** and **Expert settings** are Contao's own fields of every
module.

**Contact list(s)** and **DOI template** are greyed out when no key is stored
or Brevo gives no lists; the reason is at the field.

## Placing the module

Two ways:

- In an article: content element **Module**, then choose the sign-up module.
- In the page layout: add the module to a section of the layout.

Script and stylesheet of the form are added only on pages where the module is
placed in one of these two ways (see
[Customising](customising.md#how-script-and-stylesheet-are-loaded)).

## What visitors see

A heading and intro, the e-mail field, with mode *Choice* the list choice, the
consent checkbox and the button.

![The sign-up form on a page with the heading "Newsletter" and an intro.
Frame 1 marks the e-mail field with its label, frame 2 the consent checkbox
with its text, frame 3 the button "Subscribe".](bilder/signup-form.png)

The numbers in the picture: 1 the e-mail field, 2 the consent checkbox, 3 the
button. After **Subscribe** the message appears below
the form, e.g. "Almost done — please confirm your subscription via the e-mail
we just sent." Visitors then receive the confirmation e-mail; the click on its
link adds them to the lists and opens the confirmation page.

| Message (default) | When |
| --- | --- |
| "Please enter a valid e-mail address." | The address is not valid, or the consent checkbox is not ticked |
| "Please choose at least one list." | Mode *Choice* and no list chosen |
| "Please fill in all required fields." | A required additional field is empty |
| "Please enter the phone number in international format, starting with + and the country code." | A phone number without `+` (or `00`) and country code |
| "A confirmation e-mail has already been sent to this address. Please check your inbox and spam folder." | The same address was signed up in the last 24 hours |
| "Too many attempts. Please try again later." | One of the limits of the [spam protection](#spam-protection) is reached |
| "The security check did not work. Please reload the page and try again." | The invisible task of the spam protection was not solved (page open for more than an hour, JavaScript blocked, a browser without the required functions) |
| "Something went wrong. Please try again later." | Brevo refused the sign-up, or the module is not complete (key, list, template or confirmation page missing) |

The spam protection is solved by the browser, so the form needs JavaScript.
Without it, the form shows "Please enable JavaScript to sign up." below the
button and the sign-up is refused.

## Additional fields

Since version 1.1.0 the module can ask for more than the e-mail address. Tick
the fields under **Additional fields**; they are stored with the contact in
Brevo as its standard attributes:

| Field | On the page | Brevo attribute | Check |
| --- | --- | --- | --- |
| First name | before the e-mail address, next to the last name | the account's default (**Automatic**) or the attribute chosen | one line, at most 64 characters |
| Last name | before the e-mail address | as for the first name | as above |
| Mobile number | after the e-mail address | `SMS` | international format: `+` (or `00`) and country code, 7 to 15 digits; spaces, dots, dashes, slashes and brackets are allowed and removed |
| Landline | after the e-mail address | `LANDLINE_NUMBER` | as for the mobile number |
| Job title | after the e-mail address | `JOB_TITLE` | one line, at most 64 characters |

- **Required fields** decides which of them must be filled in. Optional fields
  get "(optional)" behind their label.
- The labels come in the language of the page; **Field labels** overrides them.
- If Brevo refuses an attribute (an attribute the account does not have, or a
  mobile number that already belongs to another contact), the visitor is still
  signed up, without the additional fields, and **System › System log** says
  which attributes Brevo refused.
- Brevo's own attributes that are not listed here follow in a later version.

## Spam protection

Since version 1.1.0 the sign-up module protects itself. Everything is built in
and always on; there is nothing to install or switch on, and visitors do not
have to click anything.

| Protection | What it does |
| --- | --- |
| Invisible task (proof of work) | When a visitor starts filling in the form, the browser fetches a small computing task from the website (`/api/brevo/challenge`, method of [ALTCHA](https://altcha.org)) and solves it in the background, usually in well under a second. The solution goes with the sign-up; without it, the sign-up is refused. A task is valid for one hour, counts once and is accepted only two seconds after it was handed out. No cookie, nothing from third parties. |
| Hidden field | A field that people do not see; whoever fills it in is a bot. |
| Other websites and scripts | A sign-up sent from another website (the browser says so) or by a script or automated browser (curl, Python, headless browsers …) is refused. |
| One e-mail per address | The same address gets one confirmation e-mail in 24 hours. A repeat sends nothing and says so. |
| Limits per visitor | 5 attempts in 10 minutes, 2 sign-ups an hour and 3 a day from the same connection. |
| Limit for all visitors | **Sign-ups per hour** and **Sign-ups per day** of the module (preset 5 and 20). |

The last limit is the one that matters in an attack. In "subscription bombing",
bots enter the addresses of real people on many websites at once, each time from
another IP address, so that the victims drown in confirmation e-mails. Every one
of those e-mails costs the website's sending quota at Brevo and its reputation
as a sender. With the limit, at most the set number of confirmation e-mails goes
out, whatever the bots do. When the limit is reached, **System › System log**
has the error, once an hour:

> Brevo newsletter: a sign-up in the module "…" (ID …) failed, the visitor was
> not subscribed: the limit of 5 sign-ups an hour is reached, further sign-ups
> are refused until the next full hour. …

What to do then: nothing is urgent, the limit holds. Look in Brevo
(**Transactional › Logs**, tag `optin`) at the addresses of the last
confirmation e-mails. Many unknown addresses in a short time are an attack; real
sign-ups usually come one at a time. Raise the limits only if real visitors are
refused, e.g. after a newsletter campaign.

## The form field in a form

1. Open **Content › Forms**, edit the fields of the form and click **New** (or
   edit a field).
2. **Field type**: **Brevo sign-up**.
3. Fill in **Field name** and **Field label** as for every form field.
4. Section *Brevo sign-up*:
   - **Checkbox text** (required): the text next to the checkbox, e.g.
     "Subscribe to the newsletter – unsubscribe at any time."
   - **Brevo list(s)** (required): the lists the confirmed contact is added to.
   - **Double opt-in template** (required).
   - **Confirmation page** (required).
5. Section *Field mapping*: choose the fields of this form that carry the data.
   The choice lists the text, text area and hidden fields of the form that have
   a field name.
   - **E-mail field** (required)
   - **First name field (optional)**, **Last name field (optional)**
6. Save.

When a visitor sends the form with the checkbox ticked, the extension signs the
address up with double opt-in. The rest of the form processing (e-mail to the
website, storing, forwarding) runs as before. An error at Brevo is written to
**System › System log** and never stops the form. Without a tick, nothing goes to Brevo.

Spam protection of such a form comes from the form itself: from Contao 5.4
add the form field **ALTCHA** (part of Contao, no extension needed); on Contao
5.3 use the form field **Security question**. In addition, the same address gets
one confirmation e-mail in 24 hours here as well. The sign-up module (above) has
its own [spam protection](#spam-protection).

First and last name are sent as the contact attributes `VORNAME` and
`NACHNAME` (the attribute names of German Brevo accounts). If the account does
not know them, Brevo refuses the request; the extension then sends the sign-up
once more without names.

## Websites in several languages

One root page per language, as Contao does it:

- Create **one sign-up module per language**, with the lists, the double
  opt-in template and the confirmation page of that language and its texts.
  Place each module on the pages of its language.
- In the form generator, the form of each language has its own **Brevo
  sign-up** field with its own settings.

Empty text fields use the defaults of the page language (eleven languages
shipped); for other languages, the defaults of the installation's default
language apply, unless the project adds `translations/neo_brevo.<language>.yaml`.

## Testing a sign-up

1. Open the page with the form in a private browser window.
2. Sign up with an address you can read.
3. Check that the success message appears and the confirmation e-mail arrives.
   The same address can be tested again only after 24 hours (one confirmation
   e-mail per address); use another address for a second test.
4. Click the link: the confirmation page opens, and the contact appears in the
   list in Brevo.

If a step fails: [Troubleshooting](troubleshooting.md).
