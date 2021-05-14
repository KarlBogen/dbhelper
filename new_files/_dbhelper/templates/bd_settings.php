<?php
$bd_settings =
"<?php" . PHP_EOL .
"/* ------------------------------------------------------------" . PHP_EOL .
"	BigDump modified by Karl" . PHP_EOL .
"	to use at" . PHP_EOL .
"	modified eCommerce Shopsoftware" . PHP_EOL .
"	http://www.modified-shop.org" . PHP_EOL .
"-------------------------------------------------------------- */" . PHP_EOL .
"" . PHP_EOL .
"// define settings" . PHP_EOL .
"define('BIGDUMP_TESTMODE', '" . $testmode . "'); // Set to true to process the file without actually accessing the database" . PHP_EOL .
"define('BIGDUMP_AJAX_MODE', '" . $ajax_mode . "'); // AJAX mode: import will be done without refreshing the website" . PHP_EOL .
"define('BIGDUMP_LINESPERSESSION', '" . $linespersession . "'); // Lines to be executed per one import session" . PHP_EOL .
"define('BIGDUMP_DELAYPERSESSION', '" . $delaypersession . "'); // You can specify a sleep time in milliseconds after each session" . PHP_EOL .
"// String quotes character" . PHP_EOL .
"define('BIGDUMP_STRING_QUOTES', '" . $string_quotes . "'); // Change to '\"' if your dump file uses double qoutes for strings" . PHP_EOL .
"// How many lines may be considered to be one query (except text lines)" . PHP_EOL .
"define('BIGDUMP_MAX_QUERY_LINES', '" . $query_lines . "');" . PHP_EOL .
"?>";
?>