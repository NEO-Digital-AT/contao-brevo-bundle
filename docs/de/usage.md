---
titel: Bedienungsanleitung
kurzfassung: Das Anmeldemodul Brevo E-Mail-Anmeldung anlegen und einbinden, jedes Feld seines Formulars, das Formularfeld Brevo-Anmeldung in einem Formular des Formulargenerators, Websites in mehreren Sprachen und eine Anmeldung testen.
zielgruppe: anwender
sprache: de
stand: 2026-11-12
---

# Bedienungsanleitung

Die Erweiterung bietet zwei Wege, Besucher anzumelden:

| Weg | Wofür |
| --- | --- |
| Frontend-Modul **Brevo E-Mail-Anmeldung** | Ein eigenes Formular: E-Mail-Adresse, wahlweise eine Auswahl der Verteiler, Einwilligungs-Häkchen, Knopf |
| Formularfeld **Brevo-Anmeldung** | Eine Checkbox in einem beliebigen Formular des Formulargenerators, z. B. dem Kontaktformular; angekreuzt meldet sie den Absender zusätzlich an |

Beide nutzen Double-Opt-in: Brevo schickt eine Bestätigungs-E-Mail, und der
Kontakt kommt erst in die Listen, wenn der Besucher auf ihren Link klickt. Der
Link führt zu der Bestätigungsseite, die im Backend gewählt ist.

Voraussetzung: Der Brevo-API-Schlüssel ist gespeichert (siehe
[Einrichtung](setup.md)).

## Das Anmeldemodul anlegen

1. **Layout › Themes** öffnen, das Theme, dann **Frontend-Module**, und auf
   **Neu** klicken.
2. **Modultyp**: **Brevo E-Mail-Anmeldung** (Gruppe *NEO Digital*). Das
   Formular lädt neu.
3. Der Kasten **Lizenz** oben nennt die Bedingung der kostenlosen Lizenz: Im
   Impressum jeder Website, auf der die Erweiterung öffentlich läuft, wird sie
   mit einem Link genannt. Er enthält den Hinweis als Text mit Link
   („Newsletter-Anmeldung: Contao Brevo Newsletter von NEO Digital“) und als
   HTML zum Kopieren.
4. Die Felder ausfüllen (Tabelle unten) und speichern.

![Das Formular des Anmeldemoduls im Backend. Rahmen 1 markiert den Kasten
„Lizenz“ mit dem Hinweis zum Kopieren, Rahmen 2 den Abschnitt „Verteiler“ mit
den Listen des Kontos und dem Modus, Rahmen 3 den Abschnitt „Double-Opt-In“ mit
der DOI-Vorlage und der Bestätigungsseite, Rahmen 4 den Abschnitt „Formular“
mit den Texten des Formulars.](bilder/module-form.png)

Die Nummern im Bild: 1 der Kasten **Lizenz**, 2 der Abschnitt *Verteiler*, 3 der
Abschnitt *Double-Opt-In*, 4 der Abschnitt *Formular*.

| Abschnitt | Feld | Pflicht | Bedeutung |
| --- | --- | --- | --- |
| Titel und Typ | **Überschrift** | nein | Überschrift über dem Formular, mit ihrer Ebene (Vorgabe `h2`) |
| Text | **Einleitung** | nein | Text über dem Formular |
| Verteiler | **Verteilerliste(n)** | ja | Die Brevo-Listen des Kontos. Im Modus *Fix* kommt der Kontakt in alle; im Modus *Auswahl* sind es die Listen, aus denen Besucher wählen. |
| | **Modus** | – | **Fix – immer in die gewählten Listen** (Vorgabe) oder **Auswahl – Besucher wählt im Frontend** |
| | **Auswahltyp** (nur bei *Auswahl*) | – | **Einfachauswahl (Selectbox)** oder **Mehrfachauswahl (Checkboxen)** |
| | **Anzeigenamen (optional)** (nur bei *Auswahl*) | nein | Eigene Bezeichnung je Liste: Schlüssel = Brevo-Listen-ID, Wert = Anzeigename. Leer: der Name in Brevo. |
| Double-Opt-In | **DOI-Vorlage** | ja | Die Double-Opt-in-Vorlage des Kontos; damit verschickt Brevo die Bestätigungs-E-Mail |
| | **Bestätigungsseite** | ja | Die Seite, zu der der Link in der Bestätigungs-E-Mail führt, z. B. „Danke für die Bestätigung“ |
| Formular | **Label E-Mail-Feld** | nein | Beschriftung des E-Mail-Felds |
| | **Button-Text** | nein | Text des Knopfes |
| | **Einwilligungstext** | ja | Text neben dem Pflicht-Häkchen der Einwilligung. Insert-Tags sind erlaubt, z. B. `{{link::datenschutz::Datenschutzerklärung}}`. |
| | **Erfolgsmeldung** | nein | Erscheint nach einer erfolgreichen Anmeldung |
| Meldungen | **Beschriftung der Verteiler-Auswahl** | nein | Überschrift der Auswahl der Verteiler; ausgegraut, außer im Modus *Auswahl* |
| | **Meldung: ungültige E-Mail-Adresse** | nein | |
| | **Meldung: keine Liste gewählt** | nein | |
| | **Meldung: zu viele Versuche** | nein | |
| | **Meldung: sonstiger Fehler** | nein | |

Jedes leere Textfeld zeigt seine Vorgabe grau an. Auf der Seite kommt die
Vorgabe in der Sprache der Seite. Die Abschnitte **Template-Einstellungen**,
**Zugriffsschutz** und **Experteneinstellungen** sind Contaos eigene Felder
jedes Moduls.

**Verteilerliste(n)** und **DOI-Vorlage** sind ausgegraut, wenn kein Schlüssel
gespeichert ist oder Brevo keine Listen liefert; der Grund steht am Feld.

## Das Modul einbinden

Zwei Wege:

- In einem Artikel: Inhaltselement **Modul**, dann das Anmeldemodul wählen.
- Im Seitenlayout: das Modul einem Bereich des Layouts hinzufügen.

Skript und Stylesheet des Formulars kommen nur auf Seiten dazu, auf denen das
Modul auf einem dieser beiden Wege steht (siehe
[Anpassen](customising.md#wie-skript-und-stylesheet-geladen-werden)).

## Was Besucher sehen

Überschrift und Einleitung, das E-Mail-Feld, im Modus *Auswahl* die Auswahl der
Verteiler, das Einwilligungs-Häkchen und den Knopf.

![Das Anmeldeformular auf einer Seite mit der Überschrift „Newsletter“ und einer
Einleitung. Rahmen 1 markiert das E-Mail-Feld mit seiner Beschriftung, Rahmen 2
das Einwilligungs-Häkchen mit seinem Text, Rahmen 3 den Knopf
„Anmelden“.](bilder/signup-form.png)

Die Nummern im Bild: 1 das E-Mail-Feld, 2 das Einwilligungs-Häkchen, 3 der
Knopf. Nach **Anmelden** erscheint
die Meldung unter dem Formular, z. B. „Fast geschafft – bitte bestätigen Sie
Ihre Anmeldung über die E-Mail, die wir Ihnen gerade geschickt haben.“ Danach
bekommen Besucher die Bestätigungs-E-Mail; der Klick auf ihren Link trägt sie in
die Listen ein und öffnet die Bestätigungsseite.

| Meldung (Vorgabe) | Wann |
| --- | --- |
| „Bitte geben Sie eine gültige E-Mail-Adresse ein.“ | Die Adresse ist ungültig, oder das Einwilligungs-Häkchen fehlt |
| „Bitte wählen Sie mindestens eine Liste.“ | Modus *Auswahl* und keine Liste gewählt |
| „Zu viele Versuche. Bitte probieren Sie es in ein paar Minuten erneut.“ | Mehr als 8 Versuche innerhalb einer Minute von derselben Verbindung |
| „Etwas ist schiefgelaufen. Bitte versuchen Sie es später erneut.“ | Brevo hat die Anmeldung abgelehnt, oder das Modul ist nicht vollständig (Schlüssel, Liste, Vorlage oder Bestätigungsseite fehlt) |

Ohne JavaScript schickt das Formular die Anmeldung trotzdem. Der Besucher
kommt dann auf die Seite zurück; die Seite zeigt keine Meldung, das Ergebnis
steht nur in der Adresse (`?nl=ok` oder ein Fehlercode).

## Das Formularfeld in einem Formular

1. **Inhalte › Formulare** öffnen, die Felder des Formulars bearbeiten und auf
   **Neu** klicken (oder ein Feld bearbeiten).
2. **Feldtyp**: **Brevo-Anmeldung**.
3. **Feldname** und **Feldbezeichnung** wie bei jedem Formularfeld ausfüllen.
4. Abschnitt *Brevo-Anmeldung*:
   - **Checkbox-Text** (Pflicht): der Text neben der Checkbox, z. B.
     „Newsletter abonnieren – jederzeit abbestellbar.“
   - **Brevo-Verteiler** (Pflicht): die Listen, in die der bestätigte Kontakt
     kommt.
   - **Double-Opt-in-Vorlage** (Pflicht).
   - **Bestätigungsseite** (Pflicht).
5. Abschnitt *Feld-Zuordnung*: die Felder dieses Formulars wählen, die die
   Angaben liefern. Zur Wahl stehen die Text-, Textarea- und versteckten Felder
   des Formulars, die einen Feldnamen haben.
   - **E-Mail-Feld** (Pflicht)
   - **Vorname-Feld (optional)**, **Nachname-Feld (optional)**
6. Speichern.

Schickt ein Besucher das Formular mit angekreuzter Checkbox ab, meldet die
Erweiterung die Adresse mit Double-Opt-in an. Die übrige Verarbeitung des
Formulars (E-Mail an die Website, Speichern, Weiterleitung) läuft wie bisher.
Ein Fehler bei Brevo landet im **System › System-Log** und hält das Formular nie auf. Ohne
Häkchen geht nichts an Brevo.

Den Spam-Schutz eines solchen Formulars bringt das Formular selbst mit: ab
Contao 5.4 das Formularfeld **ALTCHA** hinzufügen (Teil von Contao, keine
Erweiterung nötig), unter Contao 5.3 das Formularfeld **Sicherheitsfrage**. Das
Anmeldemodul (oben) hat einen eigenen Schutz: ein verstecktes Feld und eine
Grenze für Versuche.

Vor- und Nachname gehen als Kontakt-Attribute `VORNAME` und `NACHNAME` mit (die
Attributnamen deutschsprachiger Brevo-Konten). Kennt das Konto sie nicht, lehnt
Brevo die Anfrage ab; die Erweiterung schickt die Anmeldung dann noch einmal
ohne Namen.

## Websites in mehreren Sprachen

Ein Startpunkt je Sprache, wie es Contao vorsieht:

- **Ein Anmeldemodul je Sprache** anlegen, mit den Listen, der
  Double-Opt-in-Vorlage und der Bestätigungsseite dieser Sprache und mit ihren
  Texten. Jedes Modul auf den Seiten seiner Sprache einbinden.
- Im Formulargenerator hat das Formular jeder Sprache ein eigenes Feld
  **Brevo-Anmeldung** mit eigenen Einstellungen.

Leere Textfelder nutzen die Vorgaben der Sprache der Seite (elf Sprachen liegen
bei); für andere Sprachen gelten die Vorgaben der Standardsprache der
Installation, außer das Projekt ergänzt `translations/neo_brevo.<sprache>.yaml`.

## Eine Anmeldung testen

1. Die Seite mit dem Formular in einem privaten Browserfenster öffnen.
2. Mit einer Adresse anmelden, deren Post man lesen kann.
3. Prüfen, dass die Erfolgsmeldung erscheint und die Bestätigungs-E-Mail
   ankommt.
4. Auf den Link klicken: Die Bestätigungsseite öffnet sich, und der Kontakt
   steht in der Liste in Brevo.

Scheitert ein Schritt: [Fehlersuche](troubleshooting.md).
