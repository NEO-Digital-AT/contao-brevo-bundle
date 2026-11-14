---
titel: Fehlersuche
kurzfassung: Häufige Probleme mit Contao Brevo Newsletter – keine Listen im Backend, Anmeldung scheitert, keine Bestätigungs-E-Mail, Formular ohne Gestaltung, fehlende Rechte – mit Ursache und Lösung.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Fehlersuche

Jede Anmeldung, die Brevo nicht erreicht, steht als Fehler im **System ›
System-Log**, mit Modul oder Formularfeld und dem Grund: „Brevo newsletter: a
sign-up in the module "…" (ID …) failed, the visitor was not subscribed: …“
(Modul) oder „Brevo newsletter: the sign-up through the form field "…" (ID …,
form ID …) failed …“ (Formularfeld). Der Grund ist einer von dreien: Das Modul
oder Feld ist nicht vollständig (mit dem, was fehlt: API key, list, DOI
template, confirmation page), Brevo hat abgelehnt (mit Status und Meldung von
Brevo), oder Brevo hat nicht geantwortet. Die Protokolldatei der Installation
(`var/logs/`) hat zusätzlich die ganze Antwort von Brevo mit Vorlage, Listen
und Bestätigungsseite: „Brevo rejected the sign-up (HTTP …): …“. Die
E-Mail-Adresse wird nie protokolliert. Fehlende Felder im Backend sind fast
immer fehlende Rechte; siehe [Rechte](permissions.md).

## Backend

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| „Noch kein Brevo-API-Schlüssel hinterlegt. …“ oben im Modul oder Formularfeld | Kein Schlüssel unter *Zugänge und Lizenzen* und kein `BREVO_API_KEY` | Den Schlüssel eintragen ([Einrichtung](setup.md#2-api-schlüssel-in-contao)). |
| **Verteilerliste(n)** und **DOI-Vorlage** ausgegraut: „Brevo liefert zum gespeicherten Schlüssel keine Listen …“ | Der Schlüssel ist falsch oder widerrufen, das Konto hat keine Liste, oder der Server erreicht `api.brevo.com` nicht | Schlüssel in Brevo und die ausgehende Verbindung prüfen; eine Liste anlegen. |
| Eine neue Liste oder Vorlage fehlt in der Auswahl | Das Backend behält Listen und Vorlagen eine Stunde | Bis zu einer Stunde warten. |
| Eine Liste fehlt, obwohl es sie gibt | Angeboten werden nur die 50 zuletzt angelegten Listen | Ungenutzte Listen in Brevo löschen oder die Liste neu anlegen. |
| Eine Vorlage ist mit „– inactive“ markiert | Die Vorlage ist in Brevo nicht aktiv | In Brevo aktivieren. |
| **Beschriftung der Verteiler-Auswahl** ist ausgegraut | Der Modus ist *Fix* | So vorgesehen; das Feld wirkt nur bei *Auswahl*. |
| **E-Mail-Feld** bietet kein Feld an | Das Formular hat kein Text-, Textarea- oder verstecktes Feld mit Feldnamen | Zuerst das E-Mail-Feld im Formular anlegen und ihm einen Feldnamen geben. |
| Modultyp **Brevo E-Mail-Anmeldung** oder Feldtyp **Brevo-Anmeldung** fehlt | Der Gruppe fehlt er unter **Frontend-Module** oder **Formularfelder** | Erlauben ([Rechte](permissions.md)). |

## Frontend

| Was man sieht | Warum | Was zu tun ist |
| --- | --- | --- |
| „Etwas ist schiefgelaufen. …“ bei jeder Anmeldung | Das Modul ist nicht vollständig (Schlüssel, Liste, Vorlage oder Bestätigungsseite fehlt), oder Brevo hat die Anfrage abgelehnt | Das Modul vervollständigen; das **System › System-Log** nennt, was fehlt, oder die Meldung von Brevo. |
| System-Log: Brevo meldet, die Vorlage sei keine Double-Opt-in-Vorlage | Die gewählte Vorlage hat keinen Bestätigungslink des Double-Opt-in | In Brevo eine Double-Opt-in-Vorlage wählen oder anlegen. |
| System-Log: Brevo lehnt den Absender ab | Der Absender der Vorlage ist in Brevo nicht bestätigt | Den Absender in Brevo bestätigen. |
| System-Log: Brevo lehnt die Weiterleitungsadresse ab | Die Bestätigungsseite hat keine gültige öffentliche Adresse | Eine veröffentlichte Seite wählen; die Domain des Startpunkts prüfen. |
| Keine Bestätigungs-E-Mail, obwohl die Erfolgsmeldung kam | Brevo hat die Anfrage angenommen; die E-Mail liegt im Spam, oder die Adresse ist schon ein bestätigter Kontakt | Spam prüfen; den Kontakt in Brevo prüfen. |
| „Zu viele Versuche. …“ | Mehr als 8 Versuche innerhalb einer Minute von derselben Verbindung | Eine Minute warten. |
| „Bitte geben Sie eine gültige E-Mail-Adresse ein.“, obwohl die Adresse stimmt | Das Einwilligungs-Häkchen war nicht gesetzt | Das Häkchen setzen. |
| Das Formular hat keine Gestaltung und lädt beim Absenden die Seite neu | Skript und Stylesheet fehlen: Das Modul steht per Insert-Tag oder in einem eingefügten Artikel | Mit dem Inhaltselement **Modul** oder im Seitenlayout einbinden ([Anpassen](customising.md#wie-skript-und-stylesheet-geladen-werden)). |
| Nach dem Absenden ohne JavaScript erscheint keine Meldung | Ohne JavaScript zeigt die Seite keine Meldung; das Ergebnis steht in der Adresse (`?nl=…`) | So vorgesehen. |
| Eine Auswahl der Verteiler zeigt `#12` statt eines Namens | Brevo hat den Namen der Liste nicht geliefert | Unter **Anzeigenamen (optional)** einen Namen eintragen. |
| Das Formularfeld meldet niemanden an | Die Checkbox war nicht angekreuzt; oder **E-Mail-Feld** zeigt auf ein Feld ohne gültige Adresse; oder das Formularfeld ist nicht vollständig | Die Feld-Zuordnung prüfen; das **System › System-Log** nennt eine fehlende Einstellung oder die Meldung von Brevo. |
| Vor- und Nachname fehlen in Brevo | Das Konto hat keine Attribute `VORNAME` und `NACHNAME`; die Erweiterung meldet dann ohne Namen an | Die Attribute in Brevo anlegen. |
