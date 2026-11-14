# Contao Brevo Newsletter

A newsletter sign-up for Contao 5 via Brevo with double opt-in. Brevo sends the confirmation e-mail and adds the contact to the chosen lists once the visitor confirms. The form comes in a neutral design that every website adapts with CSS variables.

Free to use with a credit in the legal notice — see [License](#license).

*Deutsche Fassung weiter unten: [Deutsch](#contao-brevo-newsletter-deutsch).*

## Features

- Front-end module **Brevo Newsletter** with its own lists, double opt-in template, confirmation page and texts per module (e.g. one per language).
- Form field **Brevo sign-up**: a checkbox for any form of the form generator that signs the sender up with double opt-in while the rest of the form runs unchanged.
- One API key for the installation on **Access keys and licences**, stored encrypted; the environment variable `BREVO_API_KEY` as fallback.
- Lists and double opt-in templates chosen live from the Brevo account; display names per list.
- Mode *Fixed* (all chosen lists) or *Choice* (visitors pick, single or multiple choice).
- Limit of 8 attempts per minute, hidden field against spam bots, required consent checkbox, status messages for screen readers.
- Every visible text editable per module, defaults in eleven languages; back end in eleven languages.

## Requirements

- Contao 5.3 to 6.0 with PHP 8.2 to 8.5, as far as the Contao version supports it (Contao 5.7 needs PHP 8.3, Contao 6.0 PHP 8.4).
- `neo-digital/contao-basic-bundle`, installed automatically; it holds the API key. No licence key is needed.
- A Brevo account with an API key, a contact list and a double opt-in template.

## Installation

### Contao Manager

1. Search for `neo-digital/contao-brevo-bundle`.
2. Click **Add** and then **Apply changes**.
3. Run the database update.

### Composer

```bash
composer require neo-digital/contao-brevo-bundle
php vendor/bin/contao-console contao:migrate
```

Then enter the Brevo API key under **NEO Digital › Access keys and licences**: [Setup](docs/en/setup.md).

## Documentation

The full documentation comes with the extension: [docs/en/README.md](docs/en/README.md).

- [Installation](docs/en/installation.md) – requirements, updating, removing
- [Setup](docs/en/setup.md) – Brevo account, API key, lists and templates
- [Permissions](docs/en/permissions.md) – what editors need
- [User manual](docs/en/usage.md) – sign-up module, form field, several languages
- [Customising](docs/en/customising.md) – CSS variables, template
- [Privacy](docs/en/privacy.md) – what goes to Brevo
- [Troubleshooting](docs/en/troubleshooting.md)

## Development

The unit tests (PHPUnit 11, on PHP 8.2 with Contao 5.3 PHPUnit 10.5; folder `tests/`) need neither a database server nor a Contao installation:

```
composer install
composer test
```

The workflow `.github/workflows/tests.yml` runs them on PHP 8.2 to 8.5 and checks `composer.json` with `composer validate`.

## License

Free of charge on any number of websites, on the condition that the legal notice of every website on which the extension runs publicly names it with a link, as shown in the box **Licence** of the module form. Leaving out the credit needs a permission, given on request.

The version available at the time of the order (for free use: of the download) for the then current Contao long-term support version works with it until its end of life; there is no entitlement to versions for later long-term support versions. Support by separate agreement. Full terms: [LICENSE](LICENSE).

---

# Contao Brevo Newsletter (Deutsch)

Newsletter-Anmeldung für Contao 5 über Brevo mit Double-Opt-in. Brevo verschickt die Bestätigungs-E-Mail und trägt den Kontakt nach der Bestätigung in die gewählten Listen ein. Das Formular kommt im neutralen Grunddesign, das jede Website über CSS-Variablen anpasst.

Kostenlos mit Nennung im Impressum, siehe [Lizenz](#lizenz).

## Funktionen

- Frontend-Modul **Brevo E-Mail-Anmeldung** mit eigenen Listen, Double-Opt-in-Vorlage, Bestätigungsseite und Texten je Modul (z. B. eines je Sprache).
- Formularfeld **Brevo-Anmeldung**: eine Checkbox für jedes Formular des Formulargenerators, die den Absender mit Double-Opt-in anmeldet, während das übrige Formular unverändert läuft.
- Ein API-Schlüssel für die Installation unter **Zugänge und Lizenzen**, verschlüsselt gespeichert; die Umgebungsvariable `BREVO_API_KEY` als Rückfall.
- Listen und Double-Opt-in-Vorlagen live aus dem Brevo-Konto gewählt; Anzeigenamen je Liste.
- Modus *Fix* (alle gewählten Listen) oder *Auswahl* (Besucher wählen, Einfach- oder Mehrfachauswahl).
- Grenze von 8 Versuchen je Minute, verstecktes Feld gegen Spam-Bots, Pflicht-Häkchen für die Einwilligung, Statusmeldungen für Screenreader.
- Jeder sichtbare Text je Modul änderbar, Vorgaben in elf Sprachen; Backend in elf Sprachen.

## Voraussetzungen

- Contao 5.3 bis 6.0 mit PHP 8.2 bis 8.5, soweit die Contao-Fassung sie unterstützt (Contao 5.7 braucht PHP 8.3, Contao 6.0 PHP 8.4).
- `neo-digital/contao-basic-bundle`, wird automatisch mitinstalliert; es hält den API-Schlüssel. Ein Lizenzschlüssel ist nicht nötig.
- Ein Brevo-Konto mit API-Schlüssel, einer Kontaktliste und einer Double-Opt-in-Vorlage.

## Installation

### Contao Manager

1. Nach `neo-digital/contao-brevo-bundle` suchen.
2. Auf **Hinzufügen** und danach auf **Änderungen anwenden** klicken.
3. Die Datenbank aktualisieren.

### Composer

```bash
composer require neo-digital/contao-brevo-bundle
php vendor/bin/contao-console contao:migrate
```

Danach den Brevo-API-Schlüssel unter **NEO Digital › Zugänge und Lizenzen** eintragen: [Einrichtung](docs/de/setup.md).

## Dokumentation

Die vollständige Dokumentation liegt der Erweiterung bei: [docs/de/README.md](docs/de/README.md).

- [Installation](docs/de/installation.md) – Voraussetzungen, Aktualisieren, Entfernen
- [Einrichtung](docs/de/setup.md) – Brevo-Konto, API-Schlüssel, Listen und Vorlagen
- [Rechte](docs/de/permissions.md) – was Redakteure brauchen
- [Bedienungsanleitung](docs/de/usage.md) – Anmeldemodul, Formularfeld, mehrere Sprachen
- [Anpassen](docs/de/customising.md) – CSS-Variablen, Template
- [Datenschutz](docs/de/privacy.md) – was an Brevo geht
- [Fehlersuche](docs/de/troubleshooting.md)

## Entwicklung

Die Unit-Tests (PHPUnit 11, auf PHP 8.2 mit Contao 5.3 PHPUnit 10.5; Ordner `tests/`) brauchen weder einen Datenbankserver noch eine Contao-Installation:

```
composer install
composer test
```

Der Workflow `.github/workflows/tests.yml` führt sie auf PHP 8.2 bis 8.5 aus und prüft `composer.json` mit `composer validate`.

## Lizenz

Kostenlos auf beliebig vielen Websites, unter der Bedingung, dass das Impressum jeder Website, auf der die Erweiterung öffentlich läuft, sie mit einem Link nennt, wie im Kasten **Lizenz** des Modulformulars gezeigt. Ohne Nennung nur mit einer Erlaubnis, die es auf Anfrage gibt.

Die bei der Bestellung (bei unentgeltlicher Nutzung: beim Herunterladen) für die dann aktuelle Long-Term-Support-Version von Contao bereitstehende Fassung funktioniert mit dieser bis zu deren End of Life; ein Anspruch auf Fassungen für spätere Long-Term-Support-Versionen besteht nicht. Support nach gesonderter Vereinbarung. Vollständige Bedingungen: [LICENSE](LICENSE).
