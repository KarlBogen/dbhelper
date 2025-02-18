<?php
/* -----------------------------------------------------------------------------------------
   $Id: dbhelper_step2.php Karl

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	require_once 'includes/application_top.php';

	// Database
	require_once DIR_FS_INC . 'db_functions_' . DB_MYSQL_TYPE . '.inc.php';
	require_once DIR_FS_INC . 'db_functions.inc.php';

	// language
	require_once DIR_FS_INSTALLER . 'lang/' . $_SESSION['language'] . '.php';

	// make a connection to the database... now
	xtc_db_connect() or die('Unable to connect to database server!');

	// bigdump
	include 'includes/bigdump_settings.php';
	include 'includes/bigdump.php';

	// smarty
	$smarty = new Smarty();
	$smarty->setTemplateDir(__DIR__ . '/templates')
	    ->registerResource('file', new EvaledFileResource())
	    ->setConfigDir(__DIR__ . '/lang')
	    ->SetCaching(0);

	$smarty->assign('bigdump_help_link', '<a class="mr-auto" href="https://www.ozerov.de/bigdump/usage/" target="_blank">' . BIGDUMP_HELP_LINK . '<i class="fa fa-external-link" aria-hidden="true"></i></a>');
	$smarty->assign('bigdump_settings_link', '<a href="' . xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_bd_settings.php', '', $request_type) . '">' . BIGDUMP_SETTINGS_LINK . '</a>');
	$smarty->assign('bigdump_read_message', sprintf(TEXT_DB_RESTORE_READ_FILE_HELPER, BIGDUMP_LINESPERSESSION));

	$smarty->assign('bigdump_string', $string);
	$smarty->assign('bigdump_jsstring', isset($js_script) ? $js_script : '');

	if (isset($finish) && $finish === true)
	{
	    $smarty->assign('BUTTON_SHOP', '<div class="cssButtonRow cf"><div class="cssButton cssColor_3"><a href="' . xtc_href_link('', '', $request_type) . '">' . BUTTON_SHOP . '</a></div></div>');
	}
	else
	{
	    $smarty->assign('BUTTON_SHOP', '<div id="buttonRow" class="cssButtonRow cf"><div class="cssButton cssColor_2"><a href="' . xtc_href_link('', '', $request_type) . '">' . BUTTON_CANCEL . '</a></div></div>');
	}
	$smarty->assign('language', $_SESSION['language']);
	$module_content = $smarty->fetch('dbhelper_step2.html');

	require 'includes/header.php';
	$smarty->assign('module_content', $module_content);
	$smarty->assign('logo', xtc_href_link(DIR_WS_INSTALLER . 'images/logo_head.png', '', $request_type));

	if (!defined('RM'))
	{
	    $smarty->load_filter('output', 'note');
	}
	$smarty->display('index.html');
	require_once 'includes/application_bottom.php';
?>