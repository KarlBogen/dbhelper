<?php
/* ------------------------------------------------------------
	BigDump modified by Karl
	to use at
	modified eCommerce Shopsoftware
	http://www.modified-shop.org
-------------------------------------------------------------- */

// define settings
define('BIGDUMP_TESTMODE', 'false'); // Set to true to process the file without actually accessing the database
define('BIGDUMP_AJAX_MODE', 'true'); // AJAX mode: import will be done without refreshing the website
define('BIGDUMP_LINESPERSESSION', '1000'); // Lines to be executed per one import session
define('BIGDUMP_DELAYPERSESSION', '0'); // You can specify a sleep time in milliseconds after each session
// String quotes character
define('BIGDUMP_STRING_QUOTES', 'quote'); // Change to '"' if your dump file uses double qoutes for strings
// How many lines may be considered to be one query (except text lines)
define('BIGDUMP_MAX_QUERY_LINES', '300');
?>