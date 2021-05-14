# Datenbankhelfer für die modified eCommerce Shopsoftware

Voraussetzung: Modified eCommerce Shopsoftware - Version ab 2.0.5.0


## Installation und Start des Helfers

Im Verzeichnis **new_files** befindet sich der Ordner **_dbhelper**.
Diesen Ordner mit allen Dateien in den Shoproot kopieren.
Anschließend im Browser **meinshop.de/_dbhelper/** aufrufen.

## Allgemeines

Dieser Helfer unterstützt bei,

- der Aktualisierung der Konfigurations-Datei (configure.php).
- der Wiederherstellung einer Datenbanksicherung.
- dem Umzug einer Datenbank mit Hilfe einer Datenbanksicherung.

*Hinweis:*
Das Tool erwartet ein Datenbankbackup im Ordner **admin/backups/** als unkomprimierte SQL-Datei (*.sql) oder als komprimierte GZIP-Datei (*.gz). Vollständige Insert's verhindern Fehler beim Verarbeiten der Backupteile.
Empfohlen wird die Verwendung des shopinternen Datenbank Managers mit den Optionen "Keine Komprimierung (Raw SQL)" und "Vollständige 'INSERT's".

Für die Wiederherstellung der MySQL-Datenbank, also dem Import eines Backups, wir eine modifizierte Version des Skriptes **BigDump** benutzt, dass nacheinander kleine Teile des Backups verarbeitet.

![](images/screenshot_1.png)

<img src="images/screenshot_1.png" width="400">


## Konfigurationsdaten

Hier besteht die Möglichkeit die Konfigurationsdatei **includes/configure.php** zu aktualisieren.
Die Daten aus der Konfigurationsdatei werden in Datenbankwiederherstellung übernommen.

<img src="images/screenshot_2.png" width="400">


## BigDump Einstellungen

Hier können die BigDump Einstellungen verändert werden.

<img src="images/screenshot_3.png" width="400">


## Datenbankwiederherstellung

Die Startseite der Datenbankwiederherstellung zeigt alle vorhanden Sicherungen im Backupordner (Standard: "admin/backups").

<img src="images/screenshot_4.png" width="400">

Durch Klick auf den entsprechenden Link **Import starten** wird die Wiederherstellung begonnen.

<img src="images/screenshot_5.png" width="400">

**Das Skript arbeitet schrittweise** alle SQL-Anweisungen der Backupdatei ab.
Die Sicherungsdatei kann komprimierte Dateien

<img src="images/screenshot_6.png" width="400">

und unkomprimierte Dateien verabreiten

<img src="images/screenshot_7.png" width="400">

Die Abschlußmeldung zeigt eine Zusammenfassung der Wiederherstellung

<img src="images/screenshot_8.png" width="400">

<br />
Viel Spaß!<br />
Karl
