# DSTAR PHP Script

Das `dstar.php`-Skript zeigt an, wann ein bestimmter Benutzer zuletzt über einen bestimmten D-STAR-Repeater online war.

## Version

- Ursprüngliche Version: v1.0 von Erik Schauer, 07/2014
- Aktualisierte Version: v2.0 von Erik Schauer, 08/2023

## Features

- Ruft eine externe D-STAR-Statusseite ab, um den letzten Status eines bestimmten Rufzeichens zu ermitteln.
- Die Möglichkeit, den Status entweder als reiner Text oder als Bild auszugeben.

## Anwendung

1. **Textausgabe**: 
   - `dstar.php?call=CALL`
   - Dies zeigt an, wann `CALL` zuletzt gehört wurde.
  
2. **Bildausgabe**:
   - `dstar.php?call=CALL&image=1`
   - Dies gibt die Daten als Bild aus, das auf einer Webseite eingebunden werden kann.

## Verbesserungen in Version 2.0

- Veraltete PHP-Methoden wurden entfernt oder ersetzt.
- Eingabevalidierung und -sicherheit hinzugefügt.
- Code für bessere Lesbarkeit und Wartbarkeit refaktorisiert.

## Lizenz

- Originalscript: (c) 07/2014 by Erik Schauer
- Aktualisierungen: Rechte vorbehalten durch den entsprechenden Autor.

## Hinweis

Es wird empfohlen, das Skript in einer sicheren Testumgebung zu überprüfen, bevor es in einer Produktionsumgebung eingesetzt wird. Bei Fragen oder Feedback wenden Sie sich bitte an den ursprünglichen Autor oder den Beitragenden der aktualisierten Version.
