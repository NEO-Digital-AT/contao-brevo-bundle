---
titel: Einrichtung
kurzfassung: Was Contao Brevo Newsletter im Brevo-Konto braucht, wo der API-Schlüssel eingetragen wird, wie Listen und Vorlagen ins Backend kommen, und die Umgebungsvariable als Rückfall.
zielgruppe: betrieb
sprache: de
stand: 2026-11-12
---

# Einrichtung

## 1. In Brevo

| Was | Wo in Brevo | Wozu |
| --- | --- | --- |
| Ein API-Schlüssel | **SMTP & API** › **API-Schlüssel** | Damit liest die Erweiterung Listen und Vorlagen und schickt die Anmeldungen. |
| Mindestens eine Kontaktliste | **Kontakte** › **Listen** | Bestätigte Kontakte kommen hinein. |
| Eine Double-Opt-in-Vorlage | **Vorlagen**: eine Vorlage mit dem Bestätigungslink des Double-Opt-in | Damit verschickt Brevo die Bestätigungs-E-Mail. |
| Ein bestätigter Absender | **Absender, Domains und dedizierte IPs** | Brevo verschickt die Bestätigungs-E-Mail nur von einem bestätigten Absender. |

Die Vorlage in der Sprache der Website schreiben. Bei einer Website in mehreren
Sprachen je Sprache eine Vorlage anlegen.

## 2. API-Schlüssel in Contao

1. **NEO Digital › Zugänge und Lizenzen** öffnen.
2. Im Abschnitt **Brevo** den Schlüssel unter **Brevo-API-Schlüssel**
   eintragen und speichern.

Ein Schlüssel dient allen Anmeldemodulen und Formularfeldern der Installation.
Der Schlüssel wird verschlüsselt gespeichert und nie wieder angezeigt; das Feld
zeigt dann acht Punkte. Bleibt das Feld beim nächsten Speichern leer, bleibt der
gespeicherte Schlüssel.

Solange kein Schlüssel gespeichert ist, zeigt jedes Brevo-Modul und jedes
Formularfeld oben: „Noch kein Brevo-API-Schlüssel hinterlegt. Bis dahin lassen
sich keine Verteiler und Vorlagen wählen, und die Anmeldung auf der Website
funktioniert nicht.“

**Umgebungsvariable als Rückfall.** Ist auf der Seite kein Schlüssel
gespeichert, liest die Erweiterung `BREVO_API_KEY` aus der Umgebung (z. B.
`.env.local`). Ein Schlüssel auf der Seite hat immer Vorrang.

## 3. Verbindung prüfen

Die Seite *Zugänge und Lizenzen* hat für Brevo keine Verbindungsprüfung. Das
Formular eines Anmeldemoduls zeigt, ob der Schlüssel wirkt:

- **Verteilerliste(n)** zeigt die Listen des Kontos: Der Schlüssel wirkt.
- Die Felder **Verteilerliste(n)** und **DOI-Vorlage** sind ausgegraut mit
  „Brevo liefert zum gespeicherten Schlüssel keine Listen (Schlüssel falsch oder
  Brevo nicht erreichbar): Es gibt nichts zu wählen.“: Schlüssel und die
  ausgehende Verbindung zu `api.brevo.com` prüfen.

## Listen und Vorlagen im Backend

Das Backend holt Listen und Vorlagen live aus dem Brevo-Konto und behält sie
eine Stunde (eine Minute, wenn Brevo keine geliefert hat). Eine in Brevo neu
angelegte Liste oder Vorlage erscheint im Backend spätestens nach dieser
Stunde.

| Auswahl | Was das Backend anbietet |
| --- | --- |
| Listen | die 50 zuletzt angelegten Listen des Kontos, mit Namen |
| Vorlagen | die ersten 100 Vorlagen, als „Name (#ID)“, inaktive mit „– inactive“ markiert |

Ohne Schlüssel oder ohne Antwort von Brevo sind beide Felder ausgegraut; eine
früher gespeicherte Auswahl bleibt und wird mit ihrer Nummer gezeigt (`#12`).
Eine Liste, die Brevo nicht mehr anbietet (gelöscht oder älter als die 50
neuesten Listen), fehlt in der Auswahl; beim Speichern des Formulars fällt sie
dann aus dem Modul.

## Nächste Schritte

Das Anmeldemodul oder das Formularfeld anlegen:
[Bedienungsanleitung](usage.md). Der Lizenzkasten oben im Modulformular
enthält den Hinweis für das Impressum (siehe
[Bedienungsanleitung](usage.md#das-anmeldemodul-anlegen)).
