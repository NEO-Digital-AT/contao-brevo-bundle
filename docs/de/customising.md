---
titel: Anpassen
kurzfassung: Das Anmeldeformular von Contao Brevo Newsletter an die Gestaltung der Website anpassen – CSS-Variablen, Template überschreiben und wie Skript und Stylesheet geladen werden.
zielgruppe: betrieb
sprache: de
stand: 2026-11-27
---

# Anpassen

Das Formular kommt im neutralen Grunddesign. Angepasst wird in der Website,
nicht in der Erweiterung: mit CSS-Variablen, mit einem überschriebenen Template
und mit den Texten des Moduls
([Bedienungsanleitung](usage.md#das-anmeldemodul-anlegen)). Das Formularfeld
**Brevo-Anmeldung** ist eine Checkbox des Formulargenerators und übernimmt die
Gestaltung des Formulars.

## CSS-Variablen

Die Variablen sitzen auf `.brevo-nl`. Sie in einem Stylesheet der Website
setzen, z. B.:

```css
.brevo-nl {
    --bn-accent: #0b6e4f;
    --bn-accent-dark: #085a40;
    --bn-radius: 4px;
}
```

| Variable | Vorgabe | Wofür |
| --- | --- | --- |
| `--bn-accent` | `#1f2328` | Knopf, Fokusrahmen, Häkchen |
| `--bn-accent-dark` | `#000000` | Knopf beim Überfahren |
| `--bn-on-accent` | `#ffffff` | Text des Knopfes |
| `--bn-bg` | `#ffffff` | Hintergrund der Felder |
| `--bn-border` | `#818b98` | Rahmen der Felder; mindestens 3:1 zum Hintergrund halten |
| `--bn-text` | `#1f2328` | Text |
| `--bn-muted` | `#59636e` | Beschriftungen, Einleitung, Einwilligungstext; mindestens 4,5:1 halten |
| `--bn-link` | `#0969da` | Link im Einwilligungstext |
| `--bn-ok`, `--bn-err` | `#1a7f37`, `#cf222e` | Erfolgs- und Fehlermeldungen |
| `--bn-radius` | `8px` | Ecken |
| `--bn-font` | `inherit` | Schrift |

Die zusätzlichen Felder stehen in `.brevo-nl__fields`, jedes in einer
`.brevo-nl__row--<feld>` (`firstname`, `lastname`, `sms`, `landline`,
`job_title`); Vor- und Nachname stehen ab 36 rem Breite nebeneinander. Der
Hinweis ohne JavaScript ist `.brevo-nl__noscript`.

## Template

`contao/templates/frontend_module/brevo_newsletter.html.twig` der Erweiterung
nach `templates/frontend_module/` der Website kopieren und dort ändern. Unter
demselben Namen gilt es für jedes Anmeldemodul. Eine Variante für einzelne
Module kommt in einen Ordner dieses Namens, z. B.
`templates/frontend_module/brevo_newsletter/fusszeile.html.twig`, und wird im
Modul unter **Modul-Template** gewählt. Behalten:

- die Attribute `data-brevo-form` und `data-challenge="{{ challengeUrl }}"` am
  Formular (das zweite sagt dem Skript, wo es die Aufgabe des Spamschutzes holt;
  ohne es wird jede Anmeldung abgelehnt);
- die Feldnamen `mod`, `email`, `website` (verstecktes Feld gegen Spam-Bots),
  `consent` und `lists`;
- an jedem zusätzlichen Feld das Attribut `data-brevo-field="{{ f.key }}"` (die
  Felder kommen als `fieldsBefore` und `fieldsAfter`: vor und nach dem E-Mail-Feld,
  jedes mit `key`, `label`, `type`, `autocomplete`, `required`, `maxlength`);
- das Statuselement `.brevo-nl__msg` mit seinen `data-*`-Attributen (es trägt
  die Meldungen des Moduls).
- den Hinweis `<noscript>{{ noscript }}</noscript>` für Besucher ohne JavaScript;
  seit 1.1.0 trägt das Statuselement auch `data-fields`, `data-phone`,
  `data-repeat` und `data-verify`.

Das Skript findet Formular und Felder daran. Nach einem Update der Erweiterung
das überschriebene Template mit der neuen Fassung vergleichen.

## Wie Skript und Stylesheet geladen werden

`brevo-newsletter.css` und `brevo-newsletter.js` gehen wie die Dateien des
Seitenlayouts an Contao; **Skripte zusammenfassen** im Layout nimmt sie also
mit. Sie kommen nur auf Seiten dazu, auf denen ein Anmeldemodul mit dem
Inhaltselement **Modul** in einem Artikel der Seite oder in einem Bereich des
Seitenlayouts steht. Ein auf anderem Weg eingebundenes Modul (Insert-Tag,
eingefügter Artikel) bekommt weder Skript noch Stylesheet: Das Formular sendet
dann ohne JavaScript und hat keine Gestaltung.
