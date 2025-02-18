<?php
/* ------------------------------------------------------------
	BigDump modified by Karl
	to use at
	modified eCommerce Shopsoftware
	http://www.modified-shop.org
-------------------------------------------------------------- */

error_reporting(E_ALL);

// BigDump ver. 0.37b from 2023-09-25
// Staggered import of an large MySQL Dump (like phpMyAdmin 2.x Dump)
// Even through the webservers with hard runtime limit and those in safe mode
// Works fine with latest Chrome, Internet Explorer and Firefox

// Author:       Alexey Ozerov (alexey at ozerov dot de)
//               AJAX & CSV functionalities: Krzysiek Herod (kr81uni at wp dot pl)
// Copyright:    GPL (C) 2003-2023
// More Infos:   http://www.ozerov.de/bigdump

// This program is free software; you can redistribute it and/or modify it under the
// terms of the GNU General Public License as published by the Free Software Foundation;
// either version 2 of the License, or (at your option) any later version.

// THIS SCRIPT IS PROVIDED AS IS, WITHOUT ANY WARRANTY OR GUARANTEE OF ANY KIND

// USAGE

// 1. Adjust the database configuration and charset in this file
// 2. Remove the old tables on the target database if your dump doesn't contain "DROP TABLE"
// 3. Create the working directory (e.g. dump) on your web server
// 4. Upload bigdump.php and your dump files (.sql, .gz) via FTP to the working directory
// 5. Run the bigdump.php from your browser via URL like http://www.yourdomain.com/dump/bigdump.php
// 6. BigDump can start the next import session automatically if you enable the JavaScript
// 7. Wait for the script to finish, do not close the browser window
// 8. IMPORTANT: Remove bigdump.php and your dump files from the web server

// If Timeout errors still occure you may need to adjust the $linepersession setting in this file

// LAST CHANGES

// *** PHP8 compatibility

// Database configuration
$db_server   = (defined('DB_SERVER') ? DB_SERVER : 'localhost');
$db_name     = (defined('DB_DATABASE') ? DB_DATABASE : '');
$db_username = (defined('DB_SERVER_USERNAME') ? DB_SERVER_USERNAME : '');
$db_password = (defined('DB_SERVER_PASSWORD') ? DB_SERVER_PASSWORD : '');

// Connection charset should be the same as the dump file charset (utf8, latin1, cp1251, koi8r etc.)
// See http://dev.mysql.com/doc/refman/5.0/en/charset-charsets.html for the full list
// Change this if you have problems with non-latin letters
$db_connection_charset = (defined('DB_SERVER_CHARSET') ? DB_SERVER_CHARSET : 'utf8');

// OPTIONAL SETTINGS 
$filename           = '';     // Specify the dump filename to suppress the file selection dialog
$ajax               = (defined('BIGDUMP_AJAX_MODE') ? (BIGDUMP_AJAX_MODE == 'true' ? true : false) : true);   // AJAX mode: import will be done without refreshing the website
$linespersession    = (defined('BIGDUMP_LINESPERSESSION') ? (int)BIGDUMP_LINESPERSESSION : 2000);   // Lines to be executed per one import session
$delaypersession    = (defined('BIGDUMP_DELAYPERSESSION') ? (int)BIGDUMP_DELAYPERSESSION : 0);      // You can specify a sleep time in milliseconds after each session
                              // Works only if JavaScript is activated. Use to reduce server overrun
// Allowed comment markers: lines starting with these strings will be ignored by BigDump
$comment[] = '#';                       // Standard comment lines are dropped by default
$comment[] = '-- ';
$comment[] = 'DELIMITER';               // Ignore DELIMITER switch as it's not a valid SQL statement
// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
$comment[] = '/*!';                     // Or add your own string to leave out other proprietary things

// Default query delimiter: this character at the line end tells Bigdump where a SQL statement ends
// Can be changed by DELIMITER statement in the dump file (normally used when defining procedures/functions)
$delimiter = ';';

// String quotes character
//$string_quotes = '\'';                  // Change to '"' if your dump file uses double qoutes for strings
$string_quotes = (defined('BIGDUMP_STRING_QUOTES') ? (BIGDUMP_STRING_QUOTES == 'quote' ? '\'' : '"') : '\''); // Change to '"' if your dump file uses double qoutes for strings

// How many lines may be considered to be one query (except text lines)
$max_query_lines = (defined('BIGDUMP_MAX_QUERY_LINES') ? (int)BIGDUMP_MAX_QUERY_LINES : 300);

// Where to put the upload files into (default: bigdump folder)
$upload_dir = DIR_FS_BACKUP;

// *******************************************************************************************
// If not familiar with PHP please don't change anything below this line
// *******************************************************************************************

if ($ajax)
{
	ob_start();
}

define('BIGDUMP_VERSION', '0.37b');
define('DATA_CHUNK_LENGTH', 16384);  // How many chars are read per time
define('TESTMODE', (defined('BIGDUMP_TESTMODE') ? (BIGDUMP_TESTMODE == 'false' ? false : true) : false));           // Set to true to process the file without actually accessing the database

header("Expires: Mon, 1 Dec 2003 01:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

@ini_set('auto_detect_line_endings', true);
@set_time_limit(0);

// Clean and strip anything we don't want from user's input [0.27b]
foreach ($_REQUEST as $key => $val)
{
	$val = preg_replace("/[^_A-Za-z0-9-\.&= ;\$]/i",'', $val);
	$_REQUEST[$key] = $val;
}


$string = '';
$error = false;
$file  = false;


// Connect to the database, set charset and execute pre-queries
if (!$error && !TESTMODE)
{
	$mysqli = new mysqli($db_server, $db_username, $db_password, $db_name);

	if (!$error && $db_connection_charset !== '')
	{
		$mysqli->query("SET NAMES $db_connection_charset");
	}
	$mysqli->query("SET SESSION sql_mode=''");

	if (mysqli_connect_error())
	{
		$string .= sprintf(BIGDUMP_MYSQLI_CONNECT_ERROR, mysqli_connect_error());
		$error = true;
	}
}
else
{
	$dbconnection = false;
}

// DIAGNOSTIC
// echo("<h1>Checkpoint!</h1>");

// List uploaded files in multifile mode
if (!$error && !isset($_REQUEST['fn']) && $filename == '')
{
	if ($dirhandle = opendir($upload_dir))
	{
		$files = array();
		while (false !== ($files[] = readdir($dirhandle)));
		closedir($dirhandle);
		$dirhead = false;

		if (sizeof($files)>0)
		{
			sort($files);
			foreach ($files as $dirfile)
			{
				if ($dirfile != "." && $dirfile != ".." && $dirfile != basename($_SERVER["SCRIPT_FILENAME"]) && preg_match("/\.(sql|gz)$/i", $dirfile))
				{
					if (!$dirhead)
					{
						$string .= '<h3 class="text-center">' . BIGDUMP_HEADING_BACKUPFILES . '</h3>' . "\n";
						$string .= '<table id="backuptable">' . "\n";
						$string .= BIGDUMP_HEADING_BACKUPFILES_TABLE . "\n";
						$dirhead = true;
					}
					$string .= '<tr><td>' . $dirfile . '</td><td class="right">' . filesize($upload_dir . '/' . $dirfile) . '</td><td>' . date(PHP_DATE_TIME_FORMAT, filemtime($upload_dir . '/' . $dirfile)) . '</td>';

					if (preg_match("/\.sql$/i", $dirfile))
					{
						$string .= '<td>SQL</td>';
					}
						elseif (preg_match("/\.gz$/i", $dirfile))
					{
						$string .= '<td>GZip</td>';
					}
					else
					{
						$string .= '<td>Misc</td>';
					}

					if ((preg_match("/\.gz$/i", $dirfile) && function_exists('gzopen')) || preg_match("/\.sql$/i", $dirfile))
					{
						$string .= '<td><a class="startlink bold" href="dbhelper_step2.php?start=1&amp;fn=' . urlencode($dirfile) . '&amp;foffset=0&amp;totalqueries=0&amp;delimiter=' . urlencode($delimiter) . '">' . BIGDUMP_START_IMPORT_LINK . '</a> ' . sprintf(BIGDUMP_FROM_TABLE_TO_SERVER, $db_name, $db_server) . '</td>' . "\n" . '</tr>' . "\n";
					}
					else
					{
						$string .= '<td>&nbsp;</td>' . "\n" . '</tr>' . "\n";
					}
				}
			}
		}

		if ($dirhead)
		{
			$string .= '</table>' . "\n";
		}
		else
		{
			$string .= '<p class="text-center">' . BIGDUMP_NO_BACKUPFILES . '</p>' . "\n";
		}
	}
	else
	{
		$string .= '<p class="errormessage">' . BIGDUMP_LISTING_ERROR_BACKUPFILES . '</p>' . "\n";
		$error = true;
	}
}


// Single file mode
if (!$error && !isset($_REQUEST['fn']) && $filename != '')
{
	$string .= '<p><a href="dbhelper_step2.php?start=1&amp;fn=' . urlencode($filename) . '&amp;foffset=0&amp;totalqueries=0">' . BIGDUMP_START_IMPORT_LINK . '</a> - ' . $filename . ' ' . sprintf(BIGDUMP_FROM_TABLE_TO_SERVER , $db_name, $db_server) . '</p>' . "\n";
}


// Open the file
if (!$error && isset($_REQUEST['start']))
{ 

	// Set current filename ($filename overrides $_REQUEST["fn"] if set)
	if ($filename != '')
	{
		$curfilename = $filename;
	}
	else if (isset($_REQUEST['fn']))
	{
		$curfilename = urldecode($_REQUEST['fn']);
	}
	else
	{
		$curfilename = '';
	}

	// Recognize GZip filename
	if (preg_match("/\.gz$/i",$curfilename))
	{
		$gzipmode = true;
	}
	else
	{
		$gzipmode = false;
	}

	if ((!$gzipmode && !$file = @fopen($upload_dir . '/' . $curfilename, 'r')) || ($gzipmode && !$file = @gzopen($upload_dir . '/' . $curfilename, 'r')))
	{
		$string .= sprintf(BIGDUMP_CANNOT_OPEN_CURFILE, $curfilename) . "\n";
		$error = true;
	}
	// Get the file size (can't do it fast on gzipped files, no idea how)
	else if ((!$gzipmode && @fseek($file, 0, SEEK_END) == 0) || ($gzipmode && @gzseek($file, 0) == 0))
	{
		if (!$gzipmode)
		{
			$filesize = ftell($file);
		}
		else
		{
			$filesize = gztell($file); // Always zero, ignore
		}
	}
	else
	{
		$string .= '<p class="errormessage">' . sprintf(BIGDUMP_CANNOT_SEEK, $curfilename) . '</p>' . "\n";
		$error = true;
	}
}


// *******************************************************************************************
// START IMPORT SESSION HERE
// *******************************************************************************************

if (!$error && isset($_REQUEST['start']) && isset($_REQUEST['foffset']) && preg_match("/(\.(sql|gz))$/i",$curfilename))
{

	// Check start and foffset are numeric values
	if (!is_numeric($_REQUEST['start']) || !is_numeric($_REQUEST['foffset']))
	{
		$string .= '<p class="errormessage">' .BIGDUMP_ERROR_NON_NUMERIC . '</p>' . "\n";
		$error = true;
	}
	else
	{
		$_REQUEST['start']   = floor($_REQUEST['start']);
		$_REQUEST['foffset'] = floor($_REQUEST['foffset']);
	}

	// Set the current delimiter if defined
	if (isset($_REQUEST['delimiter']))
	{
		$delimiter = $_REQUEST['delimiter'];
	}

	// Print start message
	if (!$error)
	{
		$string .= '<div class="bigdump">' . "\n";
		if (TESTMODE)
		{
			$string .= '	<p class="text-center">' . BIGDUMP_TEST_MODE_ON . '</p>' . "\n";
		}
		$string .= '	<p class="text-center">' . BIGDUMP_PROCESSING_FILE . ': <b>' . $curfilename . '</b></p>' . "\n";
		$string .= '	<p id="startline" class="small text-center">' . BIGDUMP_START_LINE . ($_REQUEST['start'] + $linespersession) . '</p>' ."\n";
		$string .= '	</div>' . "\n";
	}

	// Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)
	if (!$error && !$gzipmode && $_REQUEST['foffset'] > $filesize)
	{
		$string .= '<p class="errormessage">' . BIGDUMP_ERROR_POINT_TO_END . '</p>' . "\n";
		$error = true;
	}

	// Set file pointer to $_REQUEST["foffset"]
	if (!$error && ((!$gzipmode && fseek($file, $_REQUEST['foffset']) != 0) || ($gzipmode && gzseek($file, $_REQUEST['foffset']) != 0)))
	{
		$string .= '<p class="errormessage">' . BIGDUMP_ERROR_POINT_TO_OFFSET . $_REQUEST['foffset'] . '</p>' . "\n";
		$error = true;
	}

	// Start processing queries from $file
	if (!$error)
	{
		$query = '';
		$queries = 0;
		$totalqueries = $_REQUEST['totalqueries'];
		$linenumber = $_REQUEST['start'];
		$querylines = 0;
		$inparents = false;

		// Stay processing as long as the $linespersession is not reached or the query is still incomplete
		while ($linenumber < $_REQUEST['start'] + $linespersession || $query != '')
		{

			// Read the whole next line
			$dumpline = '';
			while (!feof($file) && substr ($dumpline, -1) != "\n" && substr ($dumpline, -1) != "\r")
			{
				if (!$gzipmode)
				{
					$dumpline .= fgets($file, DATA_CHUNK_LENGTH);
				}
				else
				{
					$dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
				}
			}
			if ($dumpline === '')
			{
				break;
			}

			// Remove UTF8 Byte Order Mark at the file beginning if any
			if ($_REQUEST['foffset'] == 0)
			{
				$dumpline = preg_replace('|^\xEF\xBB\xBF|', '', $dumpline);
			}

			// Handle DOS and Mac encoded linebreaks (I don't know if it really works on Win32 or Mac Servers)
			$dumpline = str_replace("\r\n", "\n", $dumpline);
			$dumpline = str_replace("\r", "\n", $dumpline);
            
			// DIAGNOSTIC
			// echo ("<p>Line $linenumber: $dumpline</p>\n");

			// Recognize delimiter statement
			if (!$inparents && strpos($dumpline, 'DELIMITER ') === 0)
			{
				$delimiter = str_replace('DELIMITER ', '', trim($dumpline));
			}

			// Skip comments and blank lines only if NOT in parents
			if (!$inparents)
			{
				$skipline = false;
				reset($comment);
				foreach ($comment as $comment_value)
				{
					// DIAGNOSTIC
					// echo ($comment_value);
					if (trim($dumpline) == '' || strpos (trim($dumpline), $comment_value) === 0)
					{
						$skipline = true;
						break;
					}
				}
				if ($skipline)
				{
					$linenumber++;
					// DIAGNOSTIC
					// echo ("<p>Comment line skipped</p>\n");
					continue;
				}
			}

			// Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
			$dumpline_deslashed = str_replace ("\\\\", '', $dumpline);

			// Count ' and \' (or " and \") in the dumpline to avoid query break within a text field ending by $delimiter
			$parents = substr_count($dumpline_deslashed, $string_quotes) - substr_count($dumpline_deslashed, "\\$string_quotes");
			if ($parents % 2 != 0)
			{
				$inparents =! $inparents;
			}

			// Add the line to query
			$query .= $dumpline;

			// Don't count the line if in parents (text fields may include unlimited linebreaks)
			if (!$inparents)
			{
				$querylines++;
			}

			// Stop if query contains more lines as defined by $max_query_lines
			if ($querylines > $max_query_lines)
			{
				$string .= sprintf(BIGDUMP_ERROR_TO_MUCH_LINES, $linenumber, $max_query_lines) . "\n";
				$error = true;
				break;
			}

			// Execute query if end of query detected ($delimiter as last character) AND NOT in parents

			// DIAGNOSTIC
			// echo ("<p>Regex: ".'/'.preg_quote($delimiter).'$/'."</p>\n");
			// echo ("<p>In Parents: ".($inparents?"true":"false")."</p>\n");
			// echo ("<p>Line: $dumpline</p>\n");

			if ((preg_match('/' . preg_quote($delimiter,'/') . '$/', trim($dumpline)) || $delimiter == '') && !$inparents)
			{
				// Cut off delimiter of the end of the query
				$query = substr(trim($query), 0, -1*strlen($delimiter));

				// DIAGNOSTIC
				// echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");

				if (!TESTMODE && !$mysqli->query($query))
				{
					$string .= '<div class="errormessage"><p>' . BIGDUMP_ERROR_AT_LINE . ' ' . $linenumber .': ' . trim($dumpline) . '</p>' ."\n";
					$string .= '<p>Query: ' . trim(nl2br(htmlentities($query))) . '</p>' . "\n";
					$string .= '<p>MySQL: ' . $mysqli->error . '</p></div>' . "\n";
					$error = true;
					break;
				}
				$totalqueries++;
				$queries++;
				$query = '';
				$querylines = 0;
			}
			$linenumber++;
		}
	}

	// Get the current file position
	if (!$error)
	{
		if (!$gzipmode)
		{
			$foffset = ftell($file);
		}
		else
		{
			$foffset = gztell($file);
		}
		if (!$foffset)
		{
			$string .= '<p class="errormessage">' . BIGDUMP_ERROR_READ_POINTER_OFFSET . '</p>' . "\n";
			$error = true;
		}
	}

	// Print statistics
	$string .= '	<div class="bigdump mt">';

	// echo ("<p class=\"centr\"><b>Statistics</b></p>\n");

	if (!$error)
	{
		$lines_this   = $linenumber - $_REQUEST['start'];
		$lines_done   = $linenumber - 1;
		$lines_togo   = ' ? ';
		$lines_tota   = ' ? ';

		$queries_this = $queries;
		$queries_done = $totalqueries;
		$queries_togo = ' ? ';
		$queries_tota = ' ? ';

		$bytes_this   = $foffset-$_REQUEST['foffset'];
		$bytes_done   = $foffset;
		$kbytes_this  = round($bytes_this/1024,2);
		$kbytes_done  = round($bytes_done/1024,2);
		$mbytes_this  = round($kbytes_this/1024,2);
		$mbytes_done  = round($kbytes_done/1024,2);
   
		if (!$gzipmode)
		{
			$bytes_togo  = $filesize - $foffset;
			$bytes_tota  = $filesize;
			$kbytes_togo = round($bytes_togo/1024,2);
			$kbytes_tota = round($bytes_tota/1024,2);
			$mbytes_togo = round($kbytes_togo/1024,2);
			$mbytes_tota = round($kbytes_tota/1024,2);

			$pct_this   = ceil($bytes_this/$filesize*100);
			$pct_done   = ceil($foffset/$filesize*100);
			$pct_togo   = 100 - $pct_done;
			$pct_tota   = 100;

			if ($bytes_togo == 0)
			{
				$lines_togo   = '0';
				$lines_tota   = $linenumber - 1;
				$queries_togo = '0';
				$queries_tota = $totalqueries;
			}

			$pct_bar    = '<div style="height:15px;width:' . $pct_done . '%;background-color:#4c7eb4;margin:0px;"></div>';
		}
		else
		{
			$bytes_togo  = ' ? ';
			$bytes_tota  = ' ? ';
			$kbytes_togo = ' ? ';
			$kbytes_tota = ' ? ';
			$mbytes_togo = ' ? ';
			$mbytes_tota = ' ? ';

			$pct_this    = ' ? ';
			$pct_done    = ' ? ';
			$pct_togo    = ' ? ';
			$pct_tota    = 100;
			$pct_bar     = 'Not available for gzipped files';
		}
    
		if (!$gzipmode)
		{
			$string .= '
			<table class="sqlmode">
				<tr><th class="bg4"> </th>' . BIGDUMP_HEADING_SQLMODE_TABLE . '</tr>
				<tr><th class="bg2">' . BIGDUMP_LINES . '</th><td class="bg3">' . $lines_this . '</td><td class="bg3">' . $lines_done . '</td><td class="bg3">' . $lines_togo .'</td><td class="bg3">' . $lines_tota . '</td></tr>
				<tr><th class="bg2">Queries</th><td class="bg3">' . $queries_this . '</td><td class="bg3">' . $queries_done . '</td><td class="bg3">' . $queries_togo . '</td><td class="bg3">' . $queries_tota . '</td></tr>
				<tr><th class="bg2">Bytes</th><td class="bg3">' . $bytes_this . '</td><td class="bg3">' . $bytes_done . '</td><td class="bg3">' . $bytes_togo . '</td><td class="bg3">'  . $bytes_tota . '</td></tr>
				<tr><th class="bg2">KB</th><td class="bg3">' . $kbytes_this . '</td><td class="bg3">' . $kbytes_done . '</td><td class="bg3">' . $kbytes_togo . '</td><td class="bg3">' . $kbytes_tota . '</td></tr>
				<tr><th class="bg2">MB</th><td class="bg3">' . $mbytes_this . '</td><td class="bg3">' . $mbytes_done . '</td><td class="bg3">' . $mbytes_togo . '</td><td class="bg3">' . $mbytes_tota . '</td></tr>
				<tr><th class="bg2">%</th><td class="bg3">' . $pct_this . '</td><td class="bg3">' . $pct_done . '</td><td class="bg3">' . $pct_togo . '</td><td class="bg3">' . $pct_tota . '</td></tr>
				<tr><th class="bg2">' . BIGDUMP_PROGRESSBAR . '</th><td class="bgpctbar" colspan="4">' . $pct_bar . '</td></tr>
			</table>' . "\n";
		}
		else
		{
			$string .= '
			<table class="gzipmode">
				<tr><th class="bg4"> </th><th class="bg4">Session</th><th class="bg4">' . BIGDUMP_DONE . '</th></tr>
				<tr><th class="bg2">' . BIGDUMP_LINES . '</th><td class="bg3">' . $lines_this . '</td><td class="bg3">' . $lines_done . '</td></tr>
				<tr><th class="bg2">Queries</th><td class="bg3">' . $queries_this . '</td><td class="bg3">' . $queries_done . '</td></tr>
				<tr><th class="bg2">Bytes</th><td class="bg3">' . $bytes_this . '</td><td class="bg3">' . $bytes_done . '</td></tr>
				<tr><th class="bg2">KB</th><td class="bg3">' . $kbytes_this . '</td><td class="bg3">' . $kbytes_done . '</td></tr>
				<tr><th class="bg2">MB</th><td class="bg3">' . $mbytes_this . '</td><td class="bg3">' . $mbytes_done . '</td></tr>
			</table>' . "\n";
		}

		// Finish message and restart the script
		if ($linenumber < $_REQUEST['start'] + $linespersession)
		{
			$string .= '<p class="successmessage text-center bold">' . BIGDUMP_CONGRATULATIONS . '</p>' . "\n";
			$string .= '<p class="errormessage text-center">' . BIGDUMP_NOTE_REMOVE_DBHELPER . '</p>' . "\n";

			$error = true; // This is a semi-error telling the script is finished
			$finish = true; // the script is finished
		}
		else
		{
			if ($delaypersession != 0)
			{
				$string .= '<p class="text-center">' . sprintf(BIGDUMP_DELAY_MESSAGE, $delaypersession) . '</p>' . "\n";
			}
			if (!$ajax)
			{
				$string .= '<script language="JavaScript" type="text/javascript">window.setTimeout(\'location.href="dbhelper_step2.php?start=' . $linenumber . '&fn=' . urlencode($curfilename) . '&foffset=' . $foffset . '&totalqueries=' . $totalqueries . '&delimiter=' . urlencode($delimiter) .'";\',500+' . $delaypersession . ');</script>' . "\n";
				$string .= '<div id="spinner" class="mb text-center" style="display: none;"><p>' . BIGDUMP_IMPORT_WITHOUT_AJAX . '</p><p><i class="fa fa-spinner fa-3x fa-pulse"></i></p></div>' . "\n";
			}
			else
			{
				$string .= '<div id="spinner" class="mb text-center" style="display: none;"><p>' . BIGDUMP_IMPORT_WITH_AJAX . '</p><p><i class="fa fa-spinner fa-3x fa-pulse"></i></p></div>' . "\n";
			}
			$string .= '<noscript>' . "\n";
			$string .= '<p class="text-center"><a class="bold" href="dbhelper_step2.php?start=' . $linenumber . '&amp;fn=' . urlencode($curfilename) . '&amp;foffset=' . $foffset . '&amp;totalqueries=' . $totalqueries . '&amp;delimiter=' . urlencode($delimiter) . '">' . BIGDUMP_CONTINUE_FROM_LINE . $linenumber . '</a> ' . BIGDUMP_TEXT_ENABLE_JS . '</p>' . "\n";
			$string .= '</noscript>' . "\n";

			$string .= '<p class="mt text-center">' . BIGDUMP_TEXT_PRESS . ' <b><a href="dbhelper_step2.php">&nbsp;&nbsp;STOP&nbsp;&nbsp;</a></b> ' . BIGDUMP_TEXT_OR_WAIT . '</p>' . "\n";
		}
	}
	else
	{
		$string .= '<p class="errormessage">' . BIGDUMP_TEXT_STOP_ERROR . '</p>' . "\n";
	}
	$string .= '	</div>';
}

if ($error)
{
	$string .= '<p class="text-center bold"><a href="dbhelper_step2.php">' . BIGDUMP_TEXT_START_NEW . '</a></p>' . "\n";
}
if (!empty($mysqli))
{
	$mysqli->close();
}
if ($file && !$gzipmode)
{
	fclose($file);
}
else if ($file && $gzipmode)
{
	gzclose($file);
}

// If error or finished put out the whole output from above and stop
if ($error || (isset($finish) && $finish === true))
{
	return;
}

// If Ajax enabled and in import progress creates responses  (XML response or script for the initial page)
if ($ajax && isset($_REQUEST['start']))
{
	if (isset($_REQUEST['ajaxrequest']))
	{
		ob_end_clean();
		create_xml_response();
		exit;
	}
	else
	{
		$js_script = create_ajax_script();
	}
}

// Anyway put out the output from above
//ob_flush();

// THE MAIN SCRIPT ENDS HERE

// *******************************************************************************************
// 				AJAX utilities
// *******************************************************************************************

function create_xml_response() 
{
	global $linenumber, $foffset, $totalqueries, $curfilename, $delimiter,
				$lines_this, $lines_done, $lines_togo, $lines_tota,
				$queries_this, $queries_done, $queries_togo, $queries_tota,
				$bytes_this, $bytes_done, $bytes_togo, $bytes_tota,
				$kbytes_this, $kbytes_done, $kbytes_togo, $kbytes_tota,
				$mbytes_this, $mbytes_done, $mbytes_togo, $mbytes_tota,
				$pct_this, $pct_done, $pct_togo, $pct_tota, $pct_bar, $gzipmode;

	header('Content-Type: application/xml');
	header('Cache-Control: no-cache');
	
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
	echo "<root>";

	// data - for calculations
	echo '<linenumber>' . $linenumber . '</linenumber>';
	echo '<foffset>' . $foffset . '</foffset>';
	echo '<fn>' . $curfilename . '</fn>';
	echo '<totalqueries>' . $totalqueries . '</totalqueries>';
	echo '<delimiter>' . $delimiter . '</delimiter>';

	// results - for page update
	if (!$gzipmode)
	{
		echo '<elem1>' . $lines_this . '</elem1>';
		echo '<elem2>' . $lines_done . '</elem2>';
		echo '<elem3>' . $lines_togo . '</elem3>';
		echo '<elem4>' . $lines_tota . '</elem4>';

		echo '<elem5>' . $queries_this . '</elem5>';
		echo '<elem6>' . $queries_done . '</elem6>';
		echo '<elem7>' . $queries_togo . '</elem7>';
		echo '<elem8>' . $queries_tota . '</elem8>';

		echo '<elem9>' . $bytes_this . '</elem9>';
		echo '<elem10>' . $bytes_done . '</elem10>';
		echo '<elem11>' . $bytes_togo . '</elem11>';
		echo '<elem12>' . $bytes_tota . '</elem12>';

		echo '<elem13>' . $kbytes_this . '</elem13>';
		echo '<elem14>' . $kbytes_done . '</elem14>';
		echo '<elem15>' . $kbytes_togo . '</elem15>';
		echo '<elem16>' . $kbytes_tota . '</elem16>';

		echo '<elem17>' . $mbytes_this . '</elem17>';
		echo '<elem18>' . $mbytes_done . '</elem18>';
		echo '<elem19>' . $mbytes_togo . '</elem19>';
		echo '<elem20>' . $mbytes_tota . '</elem20>';

		echo '<elem21>' . $pct_this . '</elem21>';
		echo '<elem22>' . $pct_done . '</elem22>';
		echo '<elem23>' . $pct_togo . '</elem23>';
		echo '<elem24>' . $pct_tota . '</elem24>';
		echo '<elem_bar>' . htmlentities($pct_bar) . '</elem_bar>';
	}
	else
	{
		echo '<elem1>' . $lines_this . '</elem1>';
		echo '<elem2>' . $lines_done . '</elem2>';

		echo '<elem3>' . $queries_this . '</elem3>';
		echo '<elem4>' . $queries_done . '</elem4>';

		echo '<elem5>' . $bytes_this . '</elem5>';
		echo '<elem6>' . $bytes_done . '</elem6>';

		echo '<elem7>' . $kbytes_this . '</elem7>';
		echo '<elem8>' . $kbytes_done . '</elem8>';

		echo '<elem9>' . $mbytes_this . '</elem9>';
		echo '<elem10>' . $mbytes_done . '</elem10>';
	}
	echo '</root>';
}


function create_ajax_script() 
{
	global $linenumber, $foffset, $totalqueries, $delaypersession, $curfilename, $delimiter, $gzipmode;

	$jsString = '';

	$jsString .= '	// creates next action url (upload page, or XML response)'.PHP_EOL;
	$jsString .= '	function get_url(linenumber,fn,foffset,totalqueries,delimiter) {'.PHP_EOL;
	$jsString .= '		return "dbhelper_step2.php?start="+linenumber+"&fn="+fn+"&foffset="+foffset+"&totalqueries="+totalqueries+"&delimiter="+delimiter+"&ajaxrequest=true";'.PHP_EOL;
	$jsString .= '	}'.PHP_EOL;

	$jsString .= '	// extracts text from XML element (itemname must be unique)'.PHP_EOL;
	$jsString .= '	function get_xml_data(itemname,xmld) {'.PHP_EOL;
	$jsString .= '		return xmld.getElementsByTagName(itemname).item(0).firstChild.data;'.PHP_EOL;
	$jsString .= '	}'.PHP_EOL;

	$jsString .= '	function makeRequest(url) {'.PHP_EOL;
	$jsString .= '		http_request = false;'.PHP_EOL;
	$jsString .= '		if (window.XMLHttpRequest) {'.PHP_EOL;
	$jsString .= '		// Mozilla etc.'.PHP_EOL;
	$jsString .= '			http_request = new XMLHttpRequest();'.PHP_EOL;
	$jsString .= '			if (http_request.overrideMimeType) {'.PHP_EOL;
	$jsString .= '				http_request.overrideMimeType("text/xml");'.PHP_EOL;
	$jsString .= '			}'.PHP_EOL;
	$jsString .= '		} else if (window.ActiveXObject) {'.PHP_EOL;
	$jsString .= '		// IE'.PHP_EOL;
	$jsString .= '			try {'.PHP_EOL;
	$jsString .= '				http_request = new ActiveXObject("Msxml2.XMLHTTP");'.PHP_EOL;
	$jsString .= '			} catch(e) {'.PHP_EOL;
	$jsString .= '				try {'.PHP_EOL;
	$jsString .= '					http_request = new ActiveXObject("Microsoft.XMLHTTP");'.PHP_EOL;
	$jsString .= '				} catch(e) {}'.PHP_EOL;
	$jsString .= '			}'.PHP_EOL;
	$jsString .= '		}'.PHP_EOL;
	$jsString .= '		if (!http_request) {'.PHP_EOL;
	$jsString .= '				alert("Cannot create an XMLHTTP instance");'.PHP_EOL;
	$jsString .= '				return false;'.PHP_EOL;
	$jsString .= '		}'.PHP_EOL;
	$jsString .= '		http_request.onreadystatechange = server_response;'.PHP_EOL;
	$jsString .= '		http_request.open("GET", url, true);'.PHP_EOL;
	$jsString .= '		http_request.send(null);'.PHP_EOL;
	$jsString .= '	}'.PHP_EOL;

	$jsString .= '	function server_response()'.PHP_EOL;
	$jsString .= '	{'.PHP_EOL;

	$jsString .= '	  // waiting for correct response'.PHP_EOL;
	$jsString .= '	  if (http_request.readyState != 4)'.PHP_EOL;
	$jsString .= '		return;'.PHP_EOL;

	$jsString .= '	  if (http_request.status != 200)'.PHP_EOL;
	$jsString .= '	  {'.PHP_EOL;
	$jsString .= '	    alert("'.BIGDUMP_ALERT_PAGE_UNAVAILABLE.'")'.PHP_EOL;
	$jsString .= '	    return;'.PHP_EOL;
	$jsString .= '	  }'.PHP_EOL;

	$jsString .= '		// r = xml response'.PHP_EOL;
	$jsString .= '		var r = http_request.responseXML;'.PHP_EOL;

	$jsString .= '		//if received not XML but HTML with new page to show'.PHP_EOL;
	$jsString .= '		if (!r || r.getElementsByTagName("root").length == 0)'.PHP_EOL;
	$jsString .= '		{	var text = http_request.responseText;'.PHP_EOL;
	$jsString .= '			document.open();'.PHP_EOL;
	$jsString .= '			document.write(text);'.PHP_EOL;
	$jsString .= '			document.close();'.PHP_EOL;
	$jsString .= '			return;'.PHP_EOL;
	$jsString .= '		}'.PHP_EOL;

	$jsString .= '		// update "Starting from line: "'.PHP_EOL;
	$jsString .= '		document.getElementById("startline").innerHTML ='.PHP_EOL;
	$jsString .= '			"'.BIGDUMP_START_LINE.'" +'.PHP_EOL;
	$jsString .= '			   r.getElementsByTagName("linenumber").item(0).firstChild.nodeValue;'.PHP_EOL;

	$jsString .= '		// update table with new values'.PHP_EOL;
	if (!$gzipmode)
	{
		$jsString .= '		for(i = 1; i <= 24; i++)'.PHP_EOL;
	}
	else
	{
		$jsString .= '		for(i = 1; i <= 10; i++)'.PHP_EOL;
	}
	$jsString .= '			document.getElementsByTagName("td").item(i-1).firstChild.data = get_xml_data("elem"+i,r);'.PHP_EOL;

	$jsString .= '		// update color bar'.PHP_EOL;
	if (!$gzipmode)
	{
		$jsString .= '		document.getElementsByTagName("td").item(24).innerHTML ='.PHP_EOL;
		$jsString .= '			r.getElementsByTagName("elem_bar").item(0).firstChild.nodeValue;'.PHP_EOL;
	}
	$jsString .= '		// action url (XML response)'.PHP_EOL;
	$jsString .= '		url_request =  get_url('.PHP_EOL;
	$jsString .= '			get_xml_data("linenumber",r),'.PHP_EOL;
	$jsString .= '			get_xml_data("fn",r),'.PHP_EOL;
	$jsString .= '			get_xml_data("foffset",r),'.PHP_EOL;
	$jsString .= '			get_xml_data("totalqueries",r),'.PHP_EOL;
	$jsString .= '			get_xml_data("delimiter",r));'.PHP_EOL;

	$jsString .= '		// ask for XML response'.PHP_EOL;
	$jsString .= '		window.setTimeout("makeRequest(url_request)",500+'. $delaypersession .');'.PHP_EOL;
	$jsString .= '	}'.PHP_EOL;

	$jsString .= '	// First Ajax request from initial page'.PHP_EOL;

	$jsString .= '	var http_request = false;'.PHP_EOL;
	$jsString .= '	var url_request =  get_url('.$linenumber.',"'.urlencode($curfilename).'",'.$foffset.','.$totalqueries.',"'.urlencode($delimiter).'");'.PHP_EOL;
	$jsString .= '	window.setTimeout("makeRequest(url_request)",500+'. $delaypersession .');'.PHP_EOL;

	return $jsString;
}