---
title: Permissions
summary: Which Contao permissions a user group needs for the sign-up module, for placing it, for the form field in the form generator and for the Brevo API key.
audience: operations
language: en
updated: 2026-11-12
---

# Permissions

Administrators can do everything without any further setting. For other users,
all permissions are set in the back end under **User groups** (or **Users**),
with the names Contao shows there. The extension has no switches of its own; it
uses Contao's permissions for front-end modules, content elements, forms and
the page *Access keys and licences*.

## Per function

| Function | Contao permission | Setting |
| --- | --- | --- |
| Entering the Brevo API key | **Back end modules** | *NEO Digital*: **Access keys and licences** |
| | **Allowed fields**, table `tl_neo_access` | Brevo API key `[brevo_api_key]` |
| | **Table permissions** (Contao 5.7 and later), `tl_neo_access` | Update |
| Creating and editing the sign-up module | **Back end modules** | *Layout*: **Themes** |
| | **Theme modules** | **Front end modules** |
| | **Front end modules** | **Brevo Newsletter** |
| | **Allowed fields**, table `tl_module` | the fields below, plus Contao's fields of the module (name, headline, type) |
| | **Table permissions** (Contao 5.7 and later), `tl_module` | Create, Update, Delete as needed |
| Placing the module in an article | **Content elements** | **Module** |
| | Contao's permissions for articles and content elements | as for every content element |
| Placing the module in the page layout | **Theme modules** | **Page layouts** |
| Adding the form field | **Back end modules** | *Content*: **Forms** |
| | **Allowed forms** | the forms |
| | **Form fields** | **Brevo sign-up** |
| | **Allowed fields**, table `tl_form_field` | the fields below, plus Contao's fields of the form field (type, name, label) |
| | **Table permissions** (Contao 5.7 and later), `tl_form_field` | Create, Update, Delete as needed |

Without access to *Access keys and licences*, an editor sees the message about
the missing key without a link to the page.

As with Contao's own permissions, a user gets the permissions of the user, those
of the groups, or both, depending on **Permission inheritance**.

## The fields

| Table | Fields of the extension |
| --- | --- |
| `tl_module` | Intro `[brevo_intro]`, Contact list(s) `[brevo_lists]`, Mode `[brevo_mode]`, Choice type `[brevo_choice_type]`, Display names (optional) `[brevo_list_labels]`, DOI template `[brevo_doi_template]`, Confirmation page `[brevo_redirect]`, E-mail field label `[brevo_email_label]`, Button text `[brevo_button]`, Consent text `[brevo_consent]`, Success message `[brevo_success]`, Label of the list choice `[brevo_lists_label]`, Message: invalid e-mail address `[brevo_error_invalid]`, Message: no list chosen `[brevo_error_choose]`, Message: too many attempts `[brevo_error_limit]`, Message: other error `[brevo_error_generic]` |
| `tl_form_field` | Checkbox text `[brevo_optin_label]`, Brevo list(s) `[brevo_lists]`, Double opt-in template `[brevo_doi_template]`, Confirmation page `[brevo_redirect]`, E-mail field `[brevo_email_field]`, First name field (optional) `[brevo_firstname_field]`, Last name field (optional) `[brevo_lastname_field]` |
| `tl_neo_access` | Brevo API key `[brevo_api_key]` |

Required fields: **Contact list(s)**, **DOI template**, **Confirmation page**
and **Consent text** of the module; **Checkbox text**, **Brevo list(s)**,
**Double opt-in template**, **Confirmation page** and **E-mail field** of the
form field. Allow them, otherwise the forms cannot be saved.

## Example group "Web design: newsletter"

For the person who builds the sign-up forms; the key is entered by an
administrator:

1. **Back end modules**: **Themes**, **Forms**.
2. **Theme modules**: **Front end modules**.
3. **Front end modules**: **Brevo Newsletter**.
4. **Form fields**: **Brevo sign-up** and the field types the forms use.
5. **Allowed forms**: the forms.
6. **Allowed fields** → `tl_module` and `tl_form_field`: the fields of the list
   above and Contao's fields the group edits otherwise.
7. **Table permissions** (Contao 5.7 and later): `tl_module`, `tl_form_field`
   → Create, Update, Delete.
8. Save.

Then log in with a test user, open a sign-up module and check that **Contact
list(s)** shows the lists of the account.

## Several websites in one installation

The API key exists once for the installation; every module and form field uses
it. Separate websites with separate Brevo accounts are not possible in one
installation. Lists, template and confirmation page are set per module and per
form field.
