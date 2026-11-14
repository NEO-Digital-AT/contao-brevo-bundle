---
titel: Rechte
kurzfassung: Welche Contao-Rechte eine Benutzergruppe für das Anmeldemodul, sein Einbinden, das Formularfeld im Formulargenerator und den Brevo-API-Schlüssel braucht.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Rechte

Administratoren können alles ohne weitere Einstellung. Für andere Benutzer
werden alle Rechte im Backend unter **Benutzergruppen** (oder **Benutzer**)
gesetzt, mit den Bezeichnungen, die Contao dort zeigt. Die Erweiterung hat
keine eigenen Schalter; sie nutzt Contaos Rechte für Frontend-Module,
Inhaltselemente, Formulare und die Seite *Zugänge und Lizenzen*.

## Je Funktion

| Funktion | Contao-Recht | Einstellung |
| --- | --- | --- |
| Brevo-API-Schlüssel eintragen | **Backend-Module** | *NEO Digital*: **Zugänge und Lizenzen** |
| | **Erlaubte Felder**, Tabelle `tl_neo_access` | Brevo-API-Schlüssel `[brevo_api_key]` |
| | **Tabellenrechte** (ab Contao 5.7), `tl_neo_access` | Bearbeiten |
| Anmeldemodul anlegen und bearbeiten | **Backend-Module** | *Layout*: **Themes** |
| | **Theme-Module** | **Frontend-Module** |
| | **Frontend-Module** | **Brevo E-Mail-Anmeldung** |
| | **Erlaubte Felder**, Tabelle `tl_module` | die Felder unten, dazu Contaos Felder des Moduls (Name, Überschrift, Typ) |
| | **Tabellenrechte** (ab Contao 5.7), `tl_module` | Anlegen, Bearbeiten, Löschen nach Bedarf |
| Modul in einen Artikel einbinden | **Inhaltselemente** | **Modul** |
| | Contaos Rechte für Artikel und Inhaltselemente | wie bei jedem Inhaltselement |
| Modul ins Seitenlayout einbinden | **Theme-Module** | **Seitenlayouts** |
| Formularfeld ergänzen | **Backend-Module** | *Inhalte*: **Formulare** |
| | **Erlaubte Formulare** | die Formulare |
| | **Formularfelder** | **Brevo-Anmeldung** |
| | **Erlaubte Felder**, Tabelle `tl_form_field` | die Felder unten, dazu Contaos Felder des Formularfelds (Typ, Name, Bezeichnung) |
| | **Tabellenrechte** (ab Contao 5.7), `tl_form_field` | Anlegen, Bearbeiten, Löschen nach Bedarf |

Ohne Zugang zu *Zugänge und Lizenzen* sieht ein Redakteur die Meldung über den
fehlenden Schlüssel ohne Link auf die Seite.

Wie bei Contaos eigenen Rechten bekommt ein Benutzer die Rechte des Benutzers,
die der Gruppen oder beide, je nach **Rechtevererbung**.

## Die Felder

| Tabelle | Felder der Erweiterung |
| --- | --- |
| `tl_module` | Einleitung `[brevo_intro]`, Verteilerliste(n) `[brevo_lists]`, Modus `[brevo_mode]`, Auswahltyp `[brevo_choice_type]`, Anzeigenamen (optional) `[brevo_list_labels]`, DOI-Vorlage `[brevo_doi_template]`, Bestätigungsseite `[brevo_redirect]`, Label E-Mail-Feld `[brevo_email_label]`, Button-Text `[brevo_button]`, Einwilligungstext `[brevo_consent]`, Erfolgsmeldung `[brevo_success]`, Beschriftung der Verteiler-Auswahl `[brevo_lists_label]`, Meldung: ungültige E-Mail-Adresse `[brevo_error_invalid]`, Meldung: keine Liste gewählt `[brevo_error_choose]`, Meldung: zu viele Versuche `[brevo_error_limit]`, Meldung: sonstiger Fehler `[brevo_error_generic]` |
| `tl_form_field` | Checkbox-Text `[brevo_optin_label]`, Brevo-Verteiler `[brevo_lists]`, Double-Opt-in-Vorlage `[brevo_doi_template]`, Bestätigungsseite `[brevo_redirect]`, E-Mail-Feld `[brevo_email_field]`, Vorname-Feld (optional) `[brevo_firstname_field]`, Nachname-Feld (optional) `[brevo_lastname_field]` |
| `tl_neo_access` | Brevo-API-Schlüssel `[brevo_api_key]` |

Pflichtfelder: **Verteilerliste(n)**, **DOI-Vorlage**, **Bestätigungsseite** und
**Einwilligungstext** des Moduls; **Checkbox-Text**, **Brevo-Verteiler**,
**Double-Opt-in-Vorlage**, **Bestätigungsseite** und **E-Mail-Feld** des
Formularfelds. Sie erlauben, sonst lassen sich die Formulare nicht speichern.

## Beispielgruppe „Webdesign: Newsletter“

Für die Person, die die Anmeldeformulare baut; den Schlüssel trägt ein
Administrator ein:

1. **Backend-Module**: **Themes**, **Formulare**.
2. **Theme-Module**: **Frontend-Module**.
3. **Frontend-Module**: **Brevo E-Mail-Anmeldung**.
4. **Formularfelder**: **Brevo-Anmeldung** und die Feldtypen, die die
   Formulare nutzen.
5. **Erlaubte Formulare**: die Formulare.
6. **Erlaubte Felder** → `tl_module` und `tl_form_field`: die Felder der Liste
   oben und Contaos Felder, die die Gruppe sonst bearbeitet.
7. **Tabellenrechte** (ab Contao 5.7): `tl_module`, `tl_form_field` →
   Anlegen, Bearbeiten, Löschen.
8. Speichern.

Dann mit einem Testbenutzer anmelden, ein Anmeldemodul öffnen und prüfen, dass
**Verteilerliste(n)** die Listen des Kontos zeigt.

## Mehrere Websites in einer Installation

Den API-Schlüssel gibt es einmal für die Installation; jedes Modul und jedes
Formularfeld nutzt ihn. Getrennte Websites mit getrennten Brevo-Konten sind in
einer Installation nicht möglich. Listen, Vorlage und Bestätigungsseite werden
je Modul und je Formularfeld eingestellt.
