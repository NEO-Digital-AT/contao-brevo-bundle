---
titel: Installation
kurzfassung: Voraussetzungen, Installation von Contao Brevo Newsletter mit dem Contao Manager oder Composer, öffentliche Dateien, Backend-Sprachen, Aktualisieren von einer früheren Fassung und Entfernen.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Installation

## Voraussetzungen

| Was | Wofür |
| --- | --- |
| Contao 5.3 bis 6.0 (`contao/core-bundle ^5.3 \|\| ^6.0`) | alles |
| PHP 8.2 bis 8.5, soweit die Contao-Fassung sie unterstützt (Contao 5.7 braucht 8.3, Contao 6.0 braucht 8.4) | alles |
| `neo-digital/contao-basic-bundle` | wird automatisch mitinstalliert; es stellt die Menügruppe und die Seite **Zugänge und Lizenzen**, auf der der Brevo-API-Schlüssel steht. Die Erweiterung braucht keinen Lizenzschlüssel. |
| Ein Brevo-Konto mit API-Schlüssel, mindestens einer Kontaktliste und einer Double-Opt-in-Vorlage | jede Anmeldung (siehe [Einrichtung](setup.md)) |
| Ausgehende HTTPS-Verbindungen vom Server zu `api.brevo.com` | Listen, Vorlagen und Anmeldungen |

## Installation mit dem Contao Manager

1. Den Contao Manager öffnen.
2. Nach `neo-digital/contao-brevo-bundle` suchen.
3. Auf **Hinzufügen** und danach auf **Änderungen anwenden** klicken.
4. Wenn der Contao Manager fragt, die Datenbank aktualisieren und alle
   vorgeschlagenen Änderungen ausführen.

## Installation mit Composer

```bash
composer require neo-digital/contao-brevo-bundle
php vendor/bin/contao-console contao:migrate
```

`contao:migrate` ergänzt die Felder des Moduls in `tl_module`, die des
Formularfelds in `tl_form_field` und das Feld des API-Schlüssels auf der Seite
*Zugänge und Lizenzen*. Composer kopiert Skript und Stylesheet des Formulars
nach `public/bundles/neobrevonewsletter/`; falls das nicht geschehen ist:

```bash
php vendor/bin/contao-console assets:install
```

### Aus einem lokalen Ordner

Um das Paket aus einem Ordner des Projekts zu installieren, z. B. beim
Anpassen, ein Pfad-Repository in `composer.json` eintragen:

```json
"repositories": [{ "type": "path", "url": "bundles/contao-brevo-bundle", "options": { "symlink": true } }],
"require": { "neo-digital/contao-brevo-bundle": "@dev" }
```

## Nach der Installation

Die Erweiterung ergänzt den Modultyp **Brevo E-Mail-Anmeldung** (Gruppe *NEO
Digital*), den Feldtyp **Brevo-Anmeldung** und den Abschnitt **Brevo** unter
**NEO Digital › Zugänge und Lizenzen**. Weiter mit [Einrichtung](setup.md).

## Backend-Sprachen

Backend und Standardtexte des Formulars gibt es auf Englisch, Deutsch,
Französisch, Niederländisch, Italienisch, Polnisch, Tschechisch, Ungarisch,
Slowenisch, Kroatisch und Spanisch. Eine Datei
`translations/neo_brevo.<sprache>.yaml` im Projekt überschreibt einzelne
Standardtexte oder ergänzt eine Sprache. Ungarisch und Kroatisch bietet Contao
als Backend-Sprache erst an, wenn sie in `config/config.yaml` freigeschaltet
sind:

```yaml
contao:
    intl:
        enabled_locales: ['+hu', '+hr']
```

## Aktualisieren

1. Das Paket mit dem Contao Manager aktualisieren oder mit
   `composer update neo-digital/contao-brevo-bundle`.
2. Die Datenbank aktualisieren (`contao:migrate`).
3. `CHANGELOG.md` der neuen Fassung lesen. Braucht eine Fassung neue Rechte
   oder einen Schritt nach dem Aktualisieren, steht es dort.

**Von einer Fassung, die den Schlüssel in den Systemeinstellungen hielt.**
`contao:migrate` übernimmt den API-Schlüssel einmal aus *System ›
Einstellungen* nach *Zugänge und Lizenzen*. Ein dort schon gespeicherter
Schlüssel bleibt. Der alte Wert bleibt in `system/config/localconfig.php` und
wird nicht mehr gelesen; bei Gelegenheit dort löschen.

## Entfernen

1. Die Frontend-Module **Brevo E-Mail-Anmeldung** und die Formularfelder
   **Brevo-Anmeldung** löschen oder ersetzen.
2. Das Paket mit dem Contao Manager entfernen oder mit
   `composer remove neo-digital/contao-brevo-bundle`.
3. Die Datenbank aktualisieren. Contao bietet dann an, die Felder der
   Erweiterung in `tl_module`, `tl_form_field` und `tl_neo_access` zu löschen.

Die Kontakte bleiben im Brevo-Konto.
