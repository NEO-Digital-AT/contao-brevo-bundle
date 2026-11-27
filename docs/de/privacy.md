---
titel: Datenschutz
kurzfassung: Was Contao Brevo Newsletter speichert, welche Daten wann an Brevo gehen, was protokolliert wird und was in die Datenschutzerklärung der Website gehört.
zielgruppe: betrieb
sprache: de
stand: 2026-11-27
---

# Datenschutz

Das Formular schickt die Anmeldung an den eigenen Server der Website, der sie
an Brevo weitergibt. Der Browser des Besuchers lädt nichts von Brevo: kein
Skript, kein Cookie, keine Schrift. Das Anmeldeformular braucht deshalb keinen
Eintrag in einem Cookie-Hinweis.

Der Spamschutz (seit 1.1.0) arbeitet genauso: Der Browser holt seine Aufgabe von
der Website selbst und löst sie dort; kein Cookie, nichts von Dritten.

## Was an Brevo geht

| Wann | Was | Wohin |
| --- | --- | --- |
| Ein Besucher schickt das Anmeldemodul ab | E-Mail-Adresse, die im Modul eingeschalteten und ausgefüllten zusätzlichen Felder (Vor- und Nachname, Mobilnummer, Festnetz, Position), die Listen, die Nummer der Double-Opt-in-Vorlage, die Adresse der Bestätigungsseite | Brevo-API (`api.brevo.com`) |
| Ein Besucher schickt ein Formular mit angekreuzter **Brevo-Anmeldung** ab | E-Mail-Adresse, Vor- und Nachname, wenn zugeordnet (Attribute `VORNAME`, `NACHNAME`), die Listen, Vorlage, Bestätigungsseite | Brevo-API |
| Ein Redakteur öffnet ein Modul oder Formularfeld im Backend | der API-Schlüssel, um Listen und Vorlagen zu lesen | Brevo-API |

Brevo (Sendinblue SAS, Paris) verschickt dann die Bestätigungs-E-Mail, hält
den Kontakt und trägt ihn nach der Bestätigung in die Listen ein. Was Brevo wie
lange speichert, regeln das Brevo-Konto und dessen Bedingungen.

## Was die Website speichert

| Was | Wo | Wie lange |
| --- | --- | --- |
| Die E-Mail-Adresse der Anmeldung | von der Erweiterung weder gespeichert noch protokolliert | – |
| Ein Hash (HMAC mit dem App-Secret) der E-Mail-Adresse, für die Regel „eine Bestätigungsmail pro Adresse in 24 Stunden“; die Adresse lässt sich daraus nicht zurückgewinnen | Cache der Anwendung | 24 Stunden |
| Ein Hash der IP-Adresse, für die Grenzen pro Besucher (5 Versuche in 10 Minuten, 2 Anmeldungen pro Stunde, 3 pro Tag) | Cache der Anwendung | bis zu einem Tag |
| Zähler der Anmeldungen pro Modul (nur Zahlen, keine personenbezogenen Daten) | Cache der Anwendung | bis zu einem Tag |
| Gelöste Aufgaben des Spamschutzes (Zufallszahlen, keine personenbezogenen Daten), damit jede nur einmal zählt | Cache der Anwendung | eine Stunde |
| Der Brevo-API-Schlüssel | Seite *Zugänge und Lizenzen*, verschlüsselt mit dem App-Secret | bis zur Änderung |
| Listen und Vorlagen des Kontos (Namen und Nummern) | Cache der Anwendung | eine Stunde |
| Fehler bei Brevo: Status, Meldung von Brevo, Nummer der Vorlage, Nummern der Listen, Bestätigungsseite; nie die E-Mail-Adresse | Protokolldatei der Installation (`var/logs/`) | wie die Protokollrotation der Installation |
| Gescheiterte Anmeldungen: Name und ID des Moduls oder Formularfelds, der Grund (fehlende Einstellung, Status und Meldung von Brevo); nie die E-Mail-Adresse | **System › System-Log** (mit Browserkennung und Adresse der Anfrage, wie Contao sie bei jedem Eintrag festhält) | wie unter **System › Einstellungen › Speicherzeit für Log-Einträge** eingestellt |

Der Formulargenerator kann die übrigen Angaben eines Formulars nach seiner
Einstellung in Contao speichern oder versenden (**Eingaben speichern**, **Per
E-Mail versenden**); das gehört nicht zu dieser Erweiterung.

## Datenschutzerklärung

Die Datenschutzerklärung der Website sollte beschreiben:

- die Newsletter-Anmeldung mit Double-Opt-in und die an Brevo gesendeten Daten
  (Tabelle oben), Brevo als Auftragsverarbeiter und seinen Sitz in der EU;
- den Zweck (Versand des Newsletters) und die Einwilligung als Grundlage;
- den Spamschutz: Die E-Mail-Adresse wird 24 Stunden, die IP-Adresse bis zu einem
  Tag als Hash aufbewahrt, um Missbrauch des Formulars zu verhindern (berechtigtes
  Interesse); kein Cookie;
- wie Abonnenten sich abmelden (Abmeldelink in den E-Mails, die Brevo
  verschickt) und ihre Einwilligung widerrufen.

Die Datenschutzerklärung im **Einwilligungstext** des Moduls verlinken, z. B.
mit `{{link::datenschutz::Datenschutzerklärung}}`, und im **Checkbox-Text**
oder im Formular eines Formularfelds.
