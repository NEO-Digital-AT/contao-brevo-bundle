---
titel: Bedienungsanleitung
kurzfassung: Das Anmeldemodul Brevo E-Mail-Anmeldung anlegen und einbinden, jedes Feld seines Formulars, die zusätzlichen Felder (Name, Telefon, Position), der eingebaute Spamschutz, das Formularfeld Brevo-Anmeldung in einem Formular des Formulargenerators, Websites in mehreren Sprachen und eine Anmeldung testen.
zielgruppe: anwender
sprache: de
stand: 2026-11-27
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
| Zusätzliche Felder | **Zusätzliche Felder** | nein | Felder neben der E-Mail-Adresse, beim Kontakt in Brevo gespeichert: **Vorname**, **Nachname**, **Mobilnummer** (Brevo-Attribut `SMS`), **Festnetz** (`LANDLINE_NUMBER`), **Position** (`JOB_TITLE`). Keines angehakt: nur die E-Mail-Adresse (wie vor 1.1.0). Siehe [Zusätzliche Felder](#zusätzliche-felder). |
| | **Pflichtfelder** | nein | Angehakte Felder müssen ausgefüllt werden; die anderen tragen auf der Seite „(optional)“. Es zählen nur Felder, die angezeigt werden. |
| | **Brevo-Attribut für den Vornamen** / **… für den Nachnamen** | nein | **Automatisch** (Vorgabe): das Standard-Attribut des Kontos (`FIRSTNAME`, `VORNAME`, `PRENOM` …). Oder ein Attribut des Kontos. Ausgegraut, solange das Namensfeld nicht angezeigt wird. |
| Spamschutz | **Anmeldungen pro Stunde** | nein | Bestätigungsmails pro Stunde für alle Besucher zusammen; Vorgabe 5, `0` = keine Grenze. Siehe [Spamschutz](#spamschutz). |
| | **Anmeldungen pro Tag** | nein | Dasselbe pro Kalendertag; Vorgabe 20, `0` = keine Grenze. |
| Beschriftungen der Felder | **Beschriftung: Vorname** … **Beschriftung: Position** | nein | Beschriftungen der zusätzlichen Felder |
| Meldungen | **Beschriftung der Verteiler-Auswahl** | nein | Überschrift der Auswahl der Verteiler; ausgegraut, außer im Modus *Auswahl* |
| | **Meldung: ungültige E-Mail-Adresse** | nein | |
| | **Meldung: Pflichtfeld leer** | nein | |
| | **Meldung: Telefonnummer nicht international** | nein | |
| | **Meldung: keine Liste gewählt** | nein | |
| | **Meldung: Adresse schon angemeldet** | nein | |
| | **Meldung: zu viele Versuche** | nein | |
| | **Meldung: Sicherheitsprüfung fehlgeschlagen** | nein | |
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
| „Bitte füllen Sie alle Pflichtfelder aus.“ | Ein zusätzliches Pflichtfeld ist leer |
| „Bitte geben Sie die Telefonnummer im internationalen Format ein, mit + und Ländervorwahl.“ | Eine Telefonnummer ohne `+` (oder `00`) und Ländervorwahl |
| „An diese Adresse ist bereits eine Bestätigungsmail unterwegs. Bitte sehen Sie im Posteingang und im Spam-Ordner nach.“ | Dieselbe Adresse wurde in den letzten 24 Stunden angemeldet |
| „Zu viele Versuche. Bitte probieren Sie es später erneut.“ | Eine der Grenzen des [Spamschutzes](#spamschutz) ist erreicht |
| „Die Sicherheitsprüfung hat nicht geklappt. Bitte laden Sie die Seite neu und versuchen Sie es noch einmal.“ | Die unsichtbare Aufgabe des Spamschutzes wurde nicht gelöst (Seite länger als eine Stunde offen, JavaScript blockiert, ein Browser ohne die nötigen Funktionen) |
| „Etwas ist schiefgelaufen. Bitte versuchen Sie es später erneut.“ | Brevo hat die Anmeldung abgelehnt, oder das Modul ist nicht vollständig (Schlüssel, Liste, Vorlage oder Bestätigungsseite fehlt) |

Den Spamschutz löst der Browser, deshalb braucht das Formular JavaScript. Ohne
JavaScript zeigt es unter dem Knopf „Bitte aktivieren Sie JavaScript, um sich
anzumelden.“, und die Anmeldung wird abgelehnt.

## Zusätzliche Felder

Seit Version 1.1.0 kann das Modul mehr als die E-Mail-Adresse abfragen. Die
Felder unter **Zusätzliche Felder** anhaken; sie werden beim Kontakt in Brevo als
dessen Standard-Attribute gespeichert:

| Feld | Auf der Seite | Brevo-Attribut | Prüfung |
| --- | --- | --- | --- |
| Vorname | vor der E-Mail-Adresse, neben dem Nachnamen | das Standard-Attribut des Kontos (**Automatisch**) oder das gewählte Attribut | eine Zeile, höchstens 64 Zeichen |
| Nachname | vor der E-Mail-Adresse | wie beim Vornamen | wie oben |
| Mobilnummer | nach der E-Mail-Adresse | `SMS` | internationales Format: `+` (oder `00`) und Ländervorwahl, 7 bis 15 Ziffern; Leerzeichen, Punkte, Bindestriche, Schrägstriche und Klammern sind erlaubt und fallen weg |
| Festnetz | nach der E-Mail-Adresse | `LANDLINE_NUMBER` | wie bei der Mobilnummer |
| Position | nach der E-Mail-Adresse | `JOB_TITLE` | eine Zeile, höchstens 64 Zeichen |

- **Pflichtfelder** legt fest, welche davon ausgefüllt werden müssen. Freiwillige
  Felder tragen „(optional)“ hinter der Beschriftung.
- Die Beschriftungen kommen in der Sprache der Seite; **Beschriftungen der
  Felder** überschreibt sie.
- Lehnt Brevo ein Attribut ab (ein Attribut, das das Konto nicht hat, oder eine
  Mobilnummer, die schon zu einem anderen Kontakt gehört), wird der Besucher
  trotzdem angemeldet, ohne die zusätzlichen Felder; **System › System-Log** nennt
  die abgelehnten Attribute.
- Eigene Attribute des Brevo-Kontos folgen in einer späteren Version.

## Spamschutz

Seit Version 1.1.0 schützt sich das Anmeldemodul selbst. Alles ist eingebaut und
immer aktiv; es gibt nichts zu installieren oder einzuschalten, und Besucher
müssen nichts anklicken.

| Schutz | Was er tut |
| --- | --- |
| Unsichtbare Aufgabe (Proof of Work) | Sobald ein Besucher das Formular ausfüllt, holt der Browser eine kleine Rechenaufgabe von der Website (`/api/brevo/challenge`, Verfahren von [ALTCHA](https://altcha.org)) und löst sie im Hintergrund, meist in deutlich unter einer Sekunde. Die Lösung geht mit der Anmeldung mit; ohne sie wird die Anmeldung abgelehnt. Eine Aufgabe gilt eine Stunde, zählt einmal und wird erst zwei Sekunden nach der Ausgabe angenommen. Kein Cookie, nichts von Dritten. |
| Verstecktes Feld | Ein Feld, das Menschen nicht sehen; wer es ausfüllt, ist ein Bot. |
| Fremde Websites und Skripte | Eine Anmeldung, die von einer anderen Website kommt (das sagt der Browser) oder von einem Skript oder automatisierten Browser (curl, Python, Headless-Browser …), wird abgelehnt. |
| Eine Mail pro Adresse | Dieselbe Adresse bekommt in 24 Stunden eine Bestätigungsmail. Eine Wiederholung schickt nichts und sagt das. |
| Grenzen pro Besucher | 5 Versuche in 10 Minuten, 2 Anmeldungen pro Stunde und 3 pro Tag von derselben Verbindung. |
| Grenze für alle Besucher | **Anmeldungen pro Stunde** und **Anmeldungen pro Tag** des Moduls (Vorgabe 5 und 20). |

Bei einem Angriff zählt die letzte Grenze. Beim „Subscription Bombing“ tragen
Bots die Adressen echter Menschen gleichzeitig auf vielen Websites ein, jedes Mal
von einer anderen IP-Adresse, damit die Opfer in Bestätigungsmails untergehen.
Jede dieser Mails kostet die Website Versandkontingent bei Brevo und ihren Ruf als
Absender. Mit der Grenze gehen höchstens so viele Bestätigungsmails hinaus wie
eingestellt, egal was die Bots tun. Wird die Grenze erreicht, steht in
**System › System-Log** einmal pro Stunde der Fehler:

> Brevo newsletter: a sign-up in the module "…" (ID …) failed, the visitor was
> not subscribed: the limit of 5 sign-ups an hour is reached, further sign-ups
> are refused until the next full hour. …

Was dann zu tun ist: Nichts eilt, die Grenze hält. In Brevo (**Transaktional ›
Logs**, Tag `optin`) die Adressen der letzten Bestätigungsmails ansehen. Viele
unbekannte Adressen in kurzer Zeit sind ein Angriff; echte Anmeldungen kommen
meist einzeln. Die Grenzen nur anheben, wenn echte Besucher abgewiesen werden,
z. B. nach einer Newsletter-Aktion.

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
Erweiterung nötig), unter Contao 5.3 das Formularfeld **Sicherheitsfrage**.
Zusätzlich bekommt auch hier dieselbe Adresse in 24 Stunden nur eine
Bestätigungsmail. Das Anmeldemodul (oben) hat einen eigenen
[Spamschutz](#spamschutz).

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
   Dieselbe Adresse lässt sich erst nach 24 Stunden wieder testen (eine
   Bestätigungsmail pro Adresse); für einen zweiten Test eine andere Adresse nehmen.
4. Auf den Link klicken: Die Bestätigungsseite öffnet sich, und der Kontakt
   steht in der Liste in Brevo.

Scheitert ein Schritt: [Fehlersuche](troubleshooting.md).
