---
titel: Fehlersuche
kurzfassung: Häufige Probleme mit Contao Brevo Newsletter – keine Listen im Backend, Anmeldung scheitert, keine Bestätigungs-E-Mail, Formular ohne Gestaltung, fehlende Rechte – mit Ursache und Lösung.
zielgruppe: betrieb
sprache: de
stand: 2026-11-27
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
| **Verteilerliste(n)** und **DOI-Vorlage** ausgegraut: „Brevo liefert zum gespeicherten Schlüssel keine Listen …“ | Der Schlüssel ist falsch oder widerrufen, das Konto hat keine Liste, oder der Server erreicht `api.brevo.com` nicht | Schlüssel in Brevo und die ausgehende Verbindung prüfen; eine Liste anlegen. Der Schlüssel beginnt mit `xkeysib-`; ein SMTP-Schlüssel (`xsmtpsib-`) geht nicht. Seit 1.1.0 geht auch der „MCP-Server-API-Schlüssel“ (langer Text, beginnt mit `eyJ`): Die Erweiterung holt den Schlüssel daraus. |
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
| „Zu viele Versuche. …“ | Eine Grenze des Spamschutzes: 5 Versuche in 10 Minuten, 2 Anmeldungen pro Stunde oder 3 pro Tag von derselben Verbindung, oder **Anmeldungen pro Stunde** / **pro Tag** des Moduls für alle Besucher zusammen | Warten. Werden regelmäßig echte Besucher abgewiesen, die Grenzen im Modul anheben ([Spamschutz](usage.md#spamschutz)). |
| System-Log: „the limit of … sign-ups an hour (a day) is reached …“ | Mehr Anmeldungen, als das Modul erlaubt; typisch für Bots, die fremde Adressen eintragen | Nichts eilt, die Grenze hält. Die letzten Bestätigungsmails in Brevo ansehen (**Transaktional › Logs**, Tag `optin`). |
| „An diese Adresse ist bereits eine Bestätigungsmail unterwegs. …“ | Dieselbe Adresse wurde in den letzten 24 Stunden angemeldet | Die erste Mail suchen (auch im Spam-Ordner); mit einer anderen Adresse testen. |
| „Die Sicherheitsprüfung hat nicht geklappt. …“ | Die unsichtbare Aufgabe wurde nicht gelöst: Die Seite war länger als eine Stunde offen, ein Skript-Blocker hat `/api/brevo/challenge` gesperrt, die Seite läuft nicht über HTTPS (Browser bieten die nötigen Funktionen nur dort), oder ein sehr alter Browser | Seite neu laden; HTTPS verwenden; `/api/brevo/challenge` in Firewall oder Blocker freigeben. |
| „Bitte aktivieren Sie JavaScript, um sich anzumelden.“ | JavaScript ist aus; der Spamschutz braucht es | So gewollt. |
| „Bitte geben Sie die Telefonnummer im internationalen Format ein …“ | Eine Mobil- oder Festnetznummer ohne `+` (oder `00`) und Ländervorwahl | Mit `+`, Ländervorwahl und Nummer eingeben. |
| „Bitte füllen Sie alle Pflichtfelder aus.“ | Ein zusätzliches Pflichtfeld ist leer | Ausfüllen, oder unter **Pflichtfelder** abhaken. |
| System-Log: „Brevo refused the attributes …; the visitor is signed up without them“ | Dem Konto fehlt das Attribut, oder die Mobilnummer gehört in Brevo schon zu einem anderen Kontakt | Das Attribut in Brevo anlegen oder unter **Brevo-Attribut für den Vornamen / Nachnamen** wählen; eine doppelte Mobilnummer bleibt ohne Nummer. |
| „Bitte geben Sie eine gültige E-Mail-Adresse ein.“, obwohl die Adresse stimmt | Das Einwilligungs-Häkchen war nicht gesetzt | Das Häkchen setzen. |
| Das Formular hat keine Gestaltung und lädt beim Absenden die Seite neu | Skript und Stylesheet fehlen: Das Modul steht per Insert-Tag oder in einem eingefügten Artikel | Mit dem Inhaltselement **Modul** oder im Seitenlayout einbinden ([Anpassen](customising.md#wie-skript-und-stylesheet-geladen-werden)). |
| Eine Auswahl der Verteiler zeigt `#12` statt eines Namens | Brevo hat den Namen der Liste nicht geliefert | Unter **Anzeigenamen (optional)** einen Namen eintragen. |
| Das Formularfeld meldet niemanden an | Die Checkbox war nicht angekreuzt; oder **E-Mail-Feld** zeigt auf ein Feld ohne gültige Adresse; oder das Formularfeld ist nicht vollständig | Die Feld-Zuordnung prüfen; das **System › System-Log** nennt eine fehlende Einstellung oder die Meldung von Brevo. |
| Vor- und Nachname fehlen in Brevo | Das Konto hat keine Attribute `VORNAME` und `NACHNAME`; die Erweiterung meldet dann ohne Namen an | Die Attribute in Brevo anlegen. |
