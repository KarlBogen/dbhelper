# Datenbankhelfer für die modified eCommerce Shopsoftware

Voraussetzung: Modified eCommerce Shopsoftware - ab Version 2.0.5.0


## Installation und Start des Helfers

Im Verzeichnis **new_files** befindet sich der Ordner **_dbhelper**.<br />
Diesen Ordner mit allen Dateien in den Shoproot kopieren.<br />
Anschließend im Browser **meinshop.de/_dbhelper/** aufrufen.<br />

## Allgemeines

Dieser Helfer unterstützt bei,

- der Aktualisierung der Konfigurations-Datei (configure.php).
- der Wiederherstellung einer Datenbanksicherung.
- dem Umzug einer Datenbank mit Hilfe einer Datenbanksicherung.

*Hinweis:*
Das Tool erwartet ein Datenbankbackup im Ordner **admin/backups/** als unkomprimierte SQL-Datei (*.sql) oder als komprimierte GZIP-Datei (*.gz).<br />
Vollständige Insert's verhindern Fehler beim Verarbeiten der Backupteile.<br />
Empfohlen wird die Verwendung des shopinternen Datenbank Managers mit den Optionen "Keine Komprimierung (Raw SQL)" und "Vollständige 'INSERT's".<br />

Für die Wiederherstellung der MySQL-Datenbank, also dem Import eines Backups, wir eine modifizierte Version des Skriptes **BigDump** benutzt, dass nacheinander kleine Teile des Backups verarbeitet.<br /><br />

<img src="images/screenshot_1.png" width="500">


## Konfigurationsdaten

Hier besteht die Möglichkeit die Konfigurationsdatei **includes/configure.php** zu aktualisieren.<br />
Die Daten aus der Konfigurationsdatei werden in Datenbankwiederherstellung übernommen.<br /><br />

<img src="images/screenshot_2.png" width="500">


## BigDump Einstellungen

Hier können die BigDump Einstellungen verändert werden.<br /><br />

<img src="images/screenshot_3.png" width="500">


## Datenbankwiederherstellung

Die Startseite der Datenbankwiederherstellung zeigt alle vorhanden Sicherungen im Backupordner (Standard: "admin/backups").<br /><br />

<img src="images/screenshot_4.png" width="500">

Durch Klick auf den entsprechenden Link **Import starten** wird die Wiederherstellung begonnen.<br /><br />

<img src="images/screenshot_5.png" width="500">

**Das Skript arbeitet schrittweise** alle SQL-Anweisungen der Backupdatei ab.<br /><br />
Die Sicherungsdatei kann komprimierte Dateien<br /><br />

<img src="images/screenshot_6.png" width="500">

und unkomprimierte Dateien verabreiten<br /><br />

<img src="images/screenshot_7.png" width="500">

Die Abschlußmeldung zeigt eine Zusammenfassung der Wiederherstellung<br /><br />

<img src="images/screenshot_8.png" width="500">

<br />**Wichtig: Nach Abschluß der Wiederherstellung ist das Verzeichnis "_dbhelper" zu löschen!**<br />

<br />
Viel Spaß!<br />
Karl
