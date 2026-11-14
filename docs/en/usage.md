---
title: User manual
summary: Creating and placing the sign-up module Brevo Newsletter, every field of its form, the form field Brevo sign-up in a form of the form generator, websites in several languages and testing a sign-up.
audience: users
language: en
updated: 2026-11-12
---

# User manual

The extension offers two ways to sign visitors up:

| Way | Use |
| --- | --- |
| Front-end module **Brevo Newsletter** | A form of its own: e-mail address, optional list choice, consent checkbox, button |
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
| Messages | **Label of the list choice** | no | Heading of the list choice; greyed out unless the mode is *Choice* |
| | **Message: invalid e-mail address** | no | |
| | **Message: no list chosen** | no | |
| | **Message: too many attempts** | no | |
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
| "Too many attempts. Please try again in a few minutes." | More than 8 attempts within one minute from the same connection |
| "Something went wrong. Please try again later." | Brevo refused the sign-up, or the module is not complete (key, list, template or confirmation page missing) |

Without JavaScript, the form still sends the sign-up. The visitor then returns
to the page; the page shows no message, the result is only in the address
(`?nl=ok` or an error code).

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
5.3 use the form field **Security question**. The sign-up module (above) has
its own protection: a hidden field and a limit of attempts.

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
4. Click the link: the confirmation page opens, and the contact appears in the
   list in Brevo.

If a step fails: [Troubleshooting](troubleshooting.md).
