<?php
/* -----------------------------------------------------------------------------------------
   $Id: german.php 13059 2020-12-12 08:00:14Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
  
  
  define('PHP_DATE_TIME_FORMAT', 'd.m.Y H:i:s');

  // buttons
  define('BUTTON_BACK', 'Zur&uuml;ck');
  define('BUTTON_SUBMIT', 'Best&auml;tigen');
  define('BUTTON_INSTALL', 'Neu installieren');
  define('BUTTON_UPDATE', 'Update');
  define('BUTTON_SHOP', 'Zum Shop');

  define('BUTTON_CONFIGURE', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_SYSTEM_UPDATES', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_DB_UPDATE', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_SQL_UPDATE', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_SQL_MANUELL', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_DB_BACKUP', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_DB_RESTORE', 'ausf&uuml;hren <i class="fa fa-caret-right"></i>');
  define('BUTTON_PAYMENT_INSTALL', 'installieren <i class="fa fa-caret-right"></i>');
  
  // text
  define('TEXT_SQL_SUCCESS', '%s');
  define('TEXT_INFO_DONATIONS_IMG_ALT','Unterst&uuml;tzen Sie dieses Projekt mit Ihrer Spende');
  define('BUTTON_DONATE','<a href="https://www.modified-shop.org/spenden" target="_blank"><img src="https://www.paypal.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" alt="' . TEXT_INFO_DONATIONS_IMG_ALT . '" border="0" /></a>');
  define('TEXT_START', '<b>Willkommen zur modified eCommerce Shopsoftware Installation</b><br /><br />Die modified eCommerce Shopsoftware ist eine Open-Source e-commerce L&ouml;sung, die st&auml;ndig vom modified eCommerce Shopsoftware Team und einer grossen Gemeinschaft weiterentwickelt wird.<br /> Seine out-of-the-box Installation erlaubt es dem Shop-Besitzer seinen Online-Shop mit einem Minimum an Aufwand und Kosten zu installieren, zu betreiben und zu verwalten.<br /><br />Die modified eCommerce Shopsoftware ist auf jedem System lauff&auml;hig, welches eine PHP Umgebung (ab PHP '.PHP_VERSION_MIN.') und MySQL (ab MySQL 5.0.0) zur Verf&uuml;gung stellt, wie zum Beispiel Linux, Solaris, BSD, und Microsoft Windows.<br /><br />Die modified eCommerce Shopsoftware ist ein OpenSource-Projekt &ndash; wir stecken jede Menge Arbeit und Freizeit in dieses Projekt und w&uuml;rden uns daher &uuml;ber eine <b>Spende</b> als kleine Anerkennung freuen.<br /><br />' . BUTTON_DONATE);
  define('TEXT_UPDATER_HEADING', 'Bitte ausw&auml;hlen');
  define('TEXT_UPDATER', 'Willkommen beim Updater der modified eCommerce Shopsoftware.');
  define('TEXT_UPDATE_CONFIG', 'Konfigurations-Datei (configure.php) aktualisieren');
  define('TEXT_UPDATE_SYSTEM', 'System Updates');
  define('TEXT_UPDATE_SYSTEM_SUCCESS', 'System Updates wurden erfolgreich ausgef&uuml;hrt.');
  
  define('TEXT_CONFIGURE', 'Konfigurations-Datei (configure.php) aktualisieren');
  define('TEXT_CONFIGURE_DESC', 'Hier k&ouml;nnen Sie die configure.php Datei aktualisieren um sicher zu gehen, dass sie dem aktuelle Stand entspricht.');
  define('TEXT_CONFIGURE_SUCCESS', 'configure.php geschrieben!');
  
  define('TEXT_SQL_UPDATE', 'Datenbank Update');
  define('TEXT_SQL_UPDATE_HEADING', 'SQL Update ausw&auml;hlen');
  define('TEXT_SQL_UPDATE_DESC', 'Bitte w&auml;hlen Sie hier nur die Update-Dateien aus, die f&uuml;r Ihre derzeitige Shopversion notwendig sind.');
  define('TEXT_EXECUTED_SUCCESS', '<b>Erfolgreich ausgef&uuml;hrt:</b>');
  define('TEXT_EXECUTED_ERROR', '<b>Mit Fehlern ausgef&uuml;hrt:</b>');
  
  define('TEXT_SQL_MANUELL', 'Manuelle SQL-Eingabe');
  define('TEXT_SQL_MANUELL_HEADING', 'SQL Befehl eingeben:');
  define('TEXT_SQL_MANUELL_DESC', 'SQL-Befehle m&uuml;ssen mit einem Semikolon ( ; ) abgeschlossen werden!');

  define('TEXT_DB_RESTORE', 'Datenbank Wiederherstellung');
  define('TEXT_DB_RESTORE_DESC', 'Sie k&ouml;nnen hier Ihre Datenbank aus einem vorhandenen Backup wiederherstellen.');
  define('TEXT_INFO_DO_RESTORE', 'Die Datenbank wird wiederhergestellt!');
  define('TEXT_INFO_DO_RESTORE_OK', 'Die Datenbank wurde erfolgreich wiederhergestellt!');
  
  define('TEXT_DB_BACKUP', 'Datenbank-Backup');
  define('TEXT_DB_BACKUP_DESC', 'Sie k&ouml;nnen hier Ihre Datenbank sichern.');
  define('TEXT_DB_COMPRESS', 'Backup komprimieren');
  define('TEXT_DB_REMOVE_COLLATE', 'Ohne Zeichenkodierung \'COLLATE\' und \'DEFAULT CHARSET\'');
  define('TEXT_DB_REMOVE_ENGINE', 'Ohne Speicherengines \'ENGINE\'');
  define('TEXT_DB_COMPLETE_INSERTS', 'Vollst&auml;ndige \'INSERT\'s');
  define('TEXT_DB_UFT8_CONVERT', 'Datenbank auf UTF-8 konvertieren');
  define('TEXT_DB_COMPRESS_GZIP', 'Mit GZIP');
  define('TEXT_DB_COMPRESS_RAW', 'Keine Komprimierung (Raw SQL)');
  define('TEXT_DB_SIZE', 'Gr&ouml;&szlig;e');
  define('TEXT_DB_DATE', 'Datum');
  define('TEXT_DB_BACKUP_ALL', 'Alle Tabellen sichern');
  define('TEXT_DB_BACKUP_CUSTOM', 'Ausgew&auml;hlte Tabellen sichern');
  
  define('TEXT_INFO_DO_UPDATE_OK', 'Die Datenbank wurde erfolgreich aktualisiert!');
  define('TEXT_INFO_DO_UPDATE', 'Die Datenbank wird aktualisiert!');

  define('TEXT_INFO_DO_BACKUP_OK', 'Die Datenbank wurde erfolgreich gesichert!');
  define('TEXT_INFO_DO_BACKUP', 'Die Datenbank wird gesichert!');
  define('TEXT_INFO_WAIT', 'Bitte warten!');
  define('TEXT_INFO_FINISH', 'FERTIG!');
  define('TEXT_INFO_UPDATE', 'Tabellen aktualisiert: ');
  define('TEXT_INFO_RESTORE', 'Tabellen wiederhergestellt: ');
  define('TEXT_INFO_BACKUP', 'Tabellen gesichert: ');
  define('TEXT_INFO_LAST', 'Zuletzt bearbeitet: ');
  define('TEXT_INFO_CALLS', 'Seitenaufrufe: ');
  define('TEXT_INFO_TIME', 'Scriptlaufzeit: ');
  define('TEXT_INFO_ROWS', 'Anzahl Zeilen: ');
  define('TEXT_INFO_FROM', ' von ');
  define('TEXT_INFO_MAX_RELOADS', 'Maximale Seitenreloads wurden erreicht: ');
  define('TEXT_NO_EXTENSION', 'Keine');
  
  define('TEXT_DB_UPDATE', 'Datenbankstruktur Update');
  define('TEXT_DB_UPDATE_DESC', 'Hier k&ouml;nnen Sie die Datenbank Ihrer Shopinstallation auf den aktuellen Stand bringen.');
  define('TEXT_DB_UPDATE_FINISHED', 'DB Update erfolgreich abgesclossen!');
  define('TEXT_FROM', ' von ');
  //define('TEXT_DB_UPDATE_BEFORE', 'Text davor'); // Not used yet
  //define('TEXT_DB_UPDATE_AFTER', 'Text danach'); // Not used yet

  define('TEXT_DB_HEADING', 'Angaben zur Datenbank:');
  define('TEXT_DB_SERVER', 'Server:');
  define('TEXT_DB_USERNAME', 'Benutzername:');
  define('TEXT_DB_PASSWORD', 'Passwort:');
  define('TEXT_DB_DATABASE', 'Datenbank:');
  define('TEXT_DB_MYSQL_TYPE', 'Typ:');
  define('TEXT_DB_CHARSET', 'Zeichensatz:');
  define('TEXT_DB_PCONNECT', 'Persistent:');
  define('TEXT_DB_EXISTS', 'Datenbank existiert bereits');
  define('TEXT_DB_EXISTS_DESC', 'Wenn Sie "Best&auml;tigen" klicken werden alle Tabellen dieser Datenbank &uuml;berschrieben! Wenn Sie dies nicht m&ouml;chten, dann klicken Sie auf "Zur&uuml;ck" und geben eine andere Datenbank an. Andersfalls klicken Sie auf "Best&auml;tigen".');
  define('TEXT_DB_INSTALL', 'Datenbank Installation (Zwingend erforderlich bei Erstinstallation). Bestehende Tabellen werden dabei geleert!');

  define('TEXT_SERVER_HEADING', 'Angaben zum Shop:');
  define('TEXT_SERVER_HTTP_SERVER', 'HTTP:');
  define('TEXT_SERVER_HTTPS_SERVER', 'HTTPS:');
  define('TEXT_SERVER_USE_SSL', 'SSL:');
  define('TEXT_SERVER_SESSION', 'Session:');

  define('TEXT_ADMIN_DIRECTORY_HEADING','Admin Verzeichnis:');
  define('TEXT_ADMIN_DIRECTORY_DESCRIPTION', 'Bitte &auml;ndern Sie aus Sicherheitsgr&uuml;nden den Namen des Admin Verzeichnisses.');
  define('TEXT_ADMIN_DIRECTORY', 'Hier ein per Zufallsgenerator generierter Vorschlag:');

  define('TEXT_ACCOUNT','Der Installer richtet den Admin-Account ein und schreibt noch diverse Daten in die Datenbank.<br />Die angegebenen Daten f&uuml;r <b>Land</b> und <b>PLZ</b> werden f&uuml;r die Versand- und Steuerberechnungen genutzt.');
  define('TEXT_ACCOUNT_HEADING', 'Angaben zum Account:');
  define('TEXT_ACCOUNT_FIRSTNAME', 'Vorname:');
  define('TEXT_ACCOUNT_LASTNAME', 'Nachname:');
  define('TEXT_ACCOUNT_COMPANY', 'Firma:');
  define('TEXT_ACCOUNT_STREET', 'Stra&szlig;e/Nr.:');
  define('TEXT_ACCOUNT_CODE', 'PLZ:');
  define('TEXT_ACCOUNT_CITY', 'Stadt:');
  define('TEXT_ACCOUNT_COUNTRY', 'Land:');
  define('TEXT_ACCOUNT_EMAIL', 'E-Mail:');
  define('TEXT_ACCOUNT_CONFIRM_EMAIL', 'E-Mail best&auml;tigen:');
  define('TEXT_ACCOUNT_PASSWORD', 'Passwort:');
  define('TEXT_ACCOUNT_CONFIRMATION', 'Passwort best&auml;tigen:');
  
  define('TEXT_FINISHED', 'Hier k&ouml;nnen Sie bereits die beliebten Zahlungsweisen von PayPal installieren.');
  define('TEXT_MODULES_INSTALLED', 'Installiert:');
  define('TEXT_MODULES_UNINSTALLED', 'Nicht installiert:');
  define('TEXT_INFO_DO_INSTALL', 'Die Datenbank wird installiert.');
  
  define('TEXT_ERROR_JAVASCRIPT','In ihrem Browser ist Javascript deaktiviert. Sie m&uuml;ssen Javascript aktivieren, um den Installer ausf&uuml;hren zu k&ouml;nnen.');
  define('TEXT_ERROR_PERMISSION_FILES', 'Die folgenden Dateien ben&ouml;tigen Schreibrechte (CHMOD 777):');
  define('TEXT_ERROR_PERMISSION_FOLDER', 'Die folgenden Ordner ben&ouml;tigen Schreibrechte (CHMOD 777):');
  define('TEXT_ERROR_PERMISSION_RFOLDER', 'Folgende Ordner inklusive aller Dateien und Unterordner ben&ouml;tigen rekursive Schreibrechte (CHMOD 777):');
  define('TEXT_ERROR_REQUIREMENTS', 'Voraussetzungen');
  define('TEXT_ERROR_REQUIREMENTS_NAME', 'Name');
  define('TEXT_ERROR_REQUIREMENTS_VERSION', 'Version');
  define('TEXT_ERROR_REQUIREMENTS_MIN', 'Min');
  define('TEXT_ERROR_REQUIREMENTS_MAX', 'Max');
  define('TEXT_ERROR_FTP', 'Rechte per FTP &auml;ndern:');
  define('TEXT_ERROR_FTP_HOST', 'FTP Host:');
  define('TEXT_ERROR_FTP_PORT', 'FTP Port:');
  define('TEXT_ERROR_FTP_PATH', 'FTP Pfad:');
  define('TEXT_ERROR_FTP_USER', 'FTP Benutzer:');
  define('TEXT_ERROR_FTP_PASS', 'FTP Passwort:');
  define('TEXT_ERROR_UNLINK_FILES', 'Folgende Dateien m&uuml;ssen gel&ouml;scht werden:');
  define('TEXT_ERROR_UNLINK_FOLDER', 'Folgende Ordner m&uuml;ssen gel&ouml;scht werden:');
  
  // errors
  define('ERROR_DATABASE_CONNECTION', 'Bitte DB Daten pr&uuml;fen');
  define('ERROR_DATABASE_NOT_EMPTY', 'ACHTUNG: Die angegebene Datenbank enth&auml;lt bereits Tabellen!');
  define('ERROR_MODULES_PAYMENT', 'Leider konnten wir diese Zahlart nicht finden...');
  define('ERROR_SQL_UPDATE_NO_FILE', 'Leider konnten wir keine SQL-Update-Datei finden...');
  define('ERROR_FTP_LOGIN_NOT_POSSIBLE', 'FTP-Zugangsdaten fehlerhaft, Host nicht erreichbar');
  define('ERROR_FTP_CHMOD_WAS_NOT_SUCCESSFUL', '&Auml;ndern der Verzeichnisrechte war nicht erfolgreich');

  // warning
  define('WARNING_INVALID_DOMAIN', 'Ihre Shop Domain konnte nicht validiert werden (M&ouml;gliche Ursachen: Fehler beim Format der Domain oder internationalisierte Domainnamen (internationalized domain name, IDN) - Umlautdomain)');

  define('ENTRY_FIRST_NAME_ERROR', 'Ihr Vorname muss aus mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_LAST_NAME_ERROR', 'Ihr Nachname muss aus mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_EMAIL_ADDRESS_ERROR', 'Ihre E-Mail-Adresse muss aus mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ihre eingegebene E-Mail-Adresse ist fehlerhaft oder bereits registriert.');
  define('ENTRY_EMAIL_ERROR_NOT_MATCHING', 'Ihre E-Mail-Adressen stimmen nicht &uuml;berein.');
  define('ENTRY_STREET_ADDRESS_ERROR', 'Stra&szlig;e/Nr. muss aus mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_POST_CODE_ERROR', 'Ihre Postleitzahl muss aus mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_CITY_ERROR', 'Ort muss aus mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_PASSWORD_ERROR', 'Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.');
  define('ENTRY_PASSWORD_ERROR_MIN_LOWER', 'Ihr Passwort muss mindestens %s Kleinbuchstaben enthalten.');
  define('ENTRY_PASSWORD_ERROR_MIN_UPPER', 'Ihr Passwort muss mindestens %s Grossbuchstaben enthalten.');
  define('ENTRY_PASSWORD_ERROR_MIN_NUM', 'Ihr Passwort muss mindestens %s Zahl enthalten.');
  define('ENTRY_PASSWORD_ERROR_MIN_CHAR', 'Ihr Passwort muss mindestens %s Sonderzeichen enthalten.');
  define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Ihre Passw&ouml;rter stimmen nicht &uuml;berein.');
  define('ENTRY_PASSWORD_CURRENT_ERROR', 'Ihr aktuelles Passwort darf nicht leer sein.');

// dbhelper
  define('YES','Ja');
  define('NO','Nein');
  define('BUTTON_FORWARD', 'zum Datenbankhelfer');
  define('BUTTON_CANCEL', 'Abbrechen');
  define('BUTTON_SAVE_SETTINGS', 'Einstellungen speichern');

  define('TEXT_START_HELPER', '<b>Willkommen beim Datenbankhelfer f&uuml;r die modified eCommerce Shopsoftware</b><br /><br />Dieser Helfer unterst&uuml;tzt bei,<br />
		<ul><li>der Aktualisierung der Konfigurations-Datei (configure.php).</li><li>der Wiederherstellung einer Datenbanksicherung.</li><li>dem Umzug einer Datenbank mit Hilfe einer Datenbanksicherung.</li></ul>
        <p><u>Hinweis:</u><br />Das Tool erwartet ein Datenbankbackup im Ordner <strong>' . DIR_ADMIN . 'backups/</strong> als unkomprimierte SQL-Datei (*.sql) oder als komprimierte GZIP-Datei (*.gz). Vollständige Insert\'s verhindern Fehler beim Verarbeiten der Backupteile.<br />
		<u>Empfohlen wird</u> die Verwendung des shopinternen Datenbank Managers mit den Optionen "Keine Komprimierung (Raw SQL)" und "Vollständige \'INSERT\'s".</p>
		<p>F&uuml;r die Wiederherstellung der MySQL-Datenbank, also dem Import eines Backups, wir eine modifizierte Version des Skriptes <strong>BigDump</strong> benutzt, dass nacheinander kleine Teile des Backups verarbeitet.</p><br />Die modified eCommerce Shopsoftware ist ein OpenSource-Projekt &ndash; wir stecken jede Menge Arbeit und Freizeit in dieses Projekt und w&uuml;rden uns daher &uuml;ber eine <b>Spende</b> als kleine Anerkennung freuen.<br /><br />' . BUTTON_DONATE);
  define('TEXT_CONFIG_HEADING_HELPER', 'Konfigurationsdaten');
  define('TEXT_DB_RESTORE_HELPER', 'Datenbankwiederherstellung');
  define('TEXT_DB_RESTORE_READ_FILE_HELPER', 'Die Datenbanksicherung wird gelesen<br />und die Verarbeitung der ersten %s Zeilen gestartet!');
  define('TEXT_ERROR_JAVASCRIPT_HELPER','In ihrem Browser ist Javascript deaktiviert. Sie sollten Javascript aktivieren, um alle Funktionen des Datenbankhelfers nutzen zu k&ouml;nnen.');

  define('BIGDUMP_MYSQLI_CONNECT_ERROR', '<p class="errormessage">Die Datenbankverbindung ist aufgrund von %s fehlgeschlagen.<br />Bearbeiten Sie die Datenbankeinstellungen in den Konfigurationsdaten.</p><br />');
  define('BIGDUMP_HEADING_BACKUPFILES', 'Dateien im Admin Backup Verzeichnis');
  define('BIGDUMP_HEADING_BACKUPFILES_TABLE', '<tr><th>Dateiname</th><th>Gr&ouml;&szlig;e</th><th>Datum &amp; Zeit</th><th>Typ</th><th>&nbsp;</th>');
  define('BIGDUMP_START_IMPORT_LINK', 'Import starten');
  define('BIGDUMP_FROM_TABLE_TO_SERVER', 'zu "%s" auf "%s"');
  define('BIGDUMP_MODIFIED_BY', 'angepasst von');
  define('BIGDUMP_NO_BACKUPFILES', 'Keine SQL- oder GZ-Datei im Admin Backup Verzeichnis gefunden!');
  define('BIGDUMP_LISTING_ERROR_BACKUPFILES', 'Fehler beim Lesen des Admin Backup Verzeichnises!');
  define('BIGDUMP_CANNOT_OPEN_CURFILE', '<div class="errormessage"><p>Kann die Datei "%s" nicht &ouml;ffnen.<br />&Uuml;berpr&uuml;fen Sie, ob Ihr Dump-Dateiname nur alphanumerische Zeichen enth&auml;lt, und benennen Sie die Datei entsprechend um.</p></div>');
  define('BIGDUMP_CANNOT_SEEK', 'Kann die Datei "%s" nicht durchsuchen');
  define('BIGDUMP_ERROR_NON_NUMERIC', 'Fehler: Nicht numerische Werte f&uuml;r Start und Offset!');
  define('BIGDUMP_TEST_MODE_ON', 'TESTMODUS AKTIVIERT!');
  define('BIGDUMP_PROCESSING_FILE', 'Verarbeitungsdatei');
  define('BIGDUMP_START_LINE', 'Starte von Zeile: ');
  define('BIGDUMP_ERROR_POINT_TO_END', 'Fehler: Der Dateizeiger kann nicht hinter das Dateiende gesetzt werden!');
  define('BIGDUMP_ERROR_POINT_TO_OFFSET', 'Fehler: Der Dateizeiger kann nicht an den aktuellen Punkt gesetzt werden: ');
  define('BIGDUMP_ERROR_TO_MUCH_LINES', '<div class="errormessage"><p>Skript gestoppt in Zeile %s.</p><p>An dieser Stelle enth&auml;lt die aktuelle Abfrage mehr als "%s" Zeilen. Dies kann passieren, wenn Ihre Dump-Datei von einem Tool erstellt wurde, das kein Komma gefolgt von einem Zeilenumbruch am Ende jeder Abfrage platziert, oder wenn Ihr Dump "extended inserts" oder sehr lange Prozedurdefinitionen enth&auml;lt. Bitte lesen Sie <a href="http://www.ozerov.de/bigdump/usage/" target="_blank">BigDump Anwendungshinweise</a> f&uuml;r weitere Infomationen.</p></div>');
  define('BIGDUMP_ERROR_AT_LINE', 'Fehler in Zeile');
  define('BIGDUMP_ERROR_READ_POINTER_OFFSET', 'Fehler: Der Dateizeiger "Offset" kann nicht gelesen werden!');
  define('BIGDUMP_HEADING_SQLMODE_TABLE', '<th class="bg4">Session</th><th class="bg4">erledigt</th><th class="bg4">noch offen</th><th class="bg4">Gesamt</th>');
  define('BIGDUMP_LINES', 'Zeilen');
  define('BIGDUMP_DONE', 'erledigt');
  define('BIGDUMP_CONGRATULATIONS', 'Herzlichen Gl&uuml;ckwunsch - das Dateiende ist erreicht, keine Fehler erkannt - alles OK!');
  define('BIGDUMP_NOTE_REMOVE_DBHELPER', 'WICHTIG: L&Ouml;SCHEN SIE UMGEHEND DAS VERZEICHNIS \"<strong>_dbhelper</strong>\" VOM SERVER!');
  define('BIGDUMP_DELAY_MESSAGE', '<b>Warte %s Millisekunden</b> bevor ich die n&auml;chste Session starte...');
  define('BIGDUMP_TEXT_PRESS', 'Dr&uuml;cke');
  define('BIGDUMP_CONTINUE_FROM_LINE', 'Fortfahren von Zeile ');
  define('BIGDUMP_TEXT_ENABLE_JS', '(Aktivieren Sie JavaScript, um dies automatisch zu tun)');
  define('BIGDUMP_TEXT_OR_WAIT', 'um den Import abzubrechen <b>ODER WARTE!</b>');
  define('BIGDUMP_TEXT_STOP_ERROR', 'Wegen Fehler gestoppt!');
  define('BIGDUMP_TEXT_START_NEW', 'Vorgang neu starten');
  define('BIGDUMP_ALERT_PAGE_UNAVAILABLE', 'Seite nicht verfügbar oder falsche URL!');
  define('BIGDUMP_PROGRESSBAR', 'Fortschritt');
  define('BIGDUMP_IMPORT_WITH_AJAX', 'Datenimport wurde per Ajax gestartet, die Bearbeitung der Session kann einige Zeit dauern!');
  define('BIGDUMP_IMPORT_WITHOUT_AJAX', 'Datenimport wurde gestartet, die Bearbeitung der Session kann einige Zeit dauern!');
  define('BIGDUMP_HELP_LINK', 'BigDump Hilfe  ');
  define('BIGDUMP_SETTINGS_LINK', 'BigDump Einstellungen');
  define('BIGDUMP_SETTINGS_SUCCESS', 'Einstellungsdatei aktualisiert!');

// BigDump settings
  define('TEXT_BIGDUMP_HEADING_SETTINGS', 'BigDump Einstellungen');
  define('TEXT_BIGDUMP_TESTMODE', 'Testmodus:');
  define('TEXT_BIGDUMP_AJAX_MODE', 'Ajax-Modus:');
  define('TEXT_BIGDUMP_LINESPERSESSION', 'Zeilen pro Session:');
  define('TEXT_BIGDUMP_DELAYPERSESSION', 'Wartezeit nach Session:');
  define('TEXT_BIGDUMP_STRING_QUOTES', 'Im Backup benutzte Anf&uuml;hrungszeichen:');
  define('TEXT_BIGDUMP_MAX_QUERY_LINES', 'Maximale Anzahl an Zeilen pro Datenabfrage-Query:');
  define('TEXT_BIGDUMP_TESTMODE_DESC', 'Stellen Sie "Ja" ein, um die Wiederherstellung im Testmodus zu starten, ohne tats&auml;chlich auf die Datenbank zuzugreifen!<br /><strong>Standard: Nein</strong>');
  define('TEXT_BIGDUMP_AJAX_MODE_DESC', 'Stellen Sie den Ajax-Modus auf "Ja" und der Import erfolgt ohne Aktualisierung der Website!<br /><strong>Standard: Ja</strong>');
  define('TEXT_BIGDUMP_LINESPERSESSION_DESC', 'Anzahl der Zeilen, die pro Importsession ausgef&uuml;hrt werden sollen!<br /><strong>Standard: 3000</strong>');
  define('TEXT_BIGDUMP_DELAYPERSESSION_DESC', 'Sie k&ouml;nnen nach jeder Session eine Ruhezeit in Sekunden angeben!<br /><strong>Standard: 0</strong>');
  define('TEXT_BIGDUMP_STRING_QUOTES_DESC', 'Wechseln sie zu  \'"\' (doppelten Anf&uuml;hrungszeichen), wenn ihr Backup doppelte Anf&uuml;hrungszeichen f&uuml;r Zeichenstrings verwendet!<br /><strong>Standard: \' (einfache Anf&uuml;hrungszeichen)</strong>');
  define('TEXT_BIGDUMP_MAX_QUERY_LINES_DESC', 'Anzahl der Zeilen die eine Datenbankabfrage (Query) enthalten darf (außer Textzeilen)!<br /><strong>Standard: 300</strong>');
?>