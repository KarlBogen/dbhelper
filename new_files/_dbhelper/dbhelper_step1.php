<?php
/* -----------------------------------------------------------------------------------------
   $Id: dbhelper_step1.php Karl

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	require_once ('includes/application_top.php');

	// language
	require_once (DIR_FS_INSTALLER . 'lang/' . $_SESSION['language'] . '.php');

	// smarty
	$smarty = new Smarty();
	$smarty->setTemplateDir(__DIR__ . '/templates')
		->registerResource('file', new EvaledFileResource())
		->setConfigDir(__DIR__ . '/lang')
		->SetCaching(0);

	if (isset($_POST['action']) && $_POST['action'] == 'process')
	{
		$valid_params = array(
			'db_server',
			'db_username',
			'db_password',
			'db_database',
			'db_type',
			'db_charset',
			'db_pconnect',
			'db_install',

			'http_server',
			'https_server',
			'session',
			'use_ssl',
			'write_configure',
			'admin_directory',
		);

		// prepare variables
		foreach ($_POST as $key => $value)
		{
			if ((!isset(${$key}) || !is_object(${$key})) && in_array($key , $valid_params))
			{
				${$key} = addslashes($value);
			}
		}

		if (isset($admin_directory) && $admin_directory != trim(DIR_ADMIN, '/'))
		{
			$admin_directory = preg_replace('/[^a-zA-Z0-9_]/', '', $admin_directory);
			if (!is_dir(DIR_FS_CATALOG.$admin_directory))
			{
				@rename(DIR_FS_CATALOG.trim(DIR_ADMIN, '/'), DIR_FS_CATALOG.$admin_directory);
			}
		}

		// Database
		require_once (DIR_FS_INC . 'db_functions_' . $db_type . '.inc.php');
		require_once (DIR_FS_INC . 'db_functions.inc.php');

		$_SESSION['language_charset'] = (($db_charset == 'utf8') ? 'utf-8' : 'ISO-8859-15');

		$connection = xtc_db_connect($db_server, $db_username, $db_password, $db_database, 'db_link');
		if (is_object($connection) || is_resource($connection))
		{
			$error = false;

			if (strpos($http_server, 'https:') !== false)
			{
				$use_ssl = 'true';
			}

			//create  includes/configure.php
			include (DIR_FS_INSTALLER . 'templates/configure.php');
			if (file_exists(DIR_FS_CATALOG . '/includes/local/configure.php'))
			{
				$fp = fopen(DIR_FS_CATALOG . 'includes/local/configure.php', 'w');
			}
			else
			{
				$fp = fopen(DIR_FS_CATALOG . 'includes/configure.php', 'w');
			}
			fputs($fp, $file_contents);
			fclose($fp);

		}
		else
		{
			$messageStack->add_session('dbhelper_step1', ERROR_DATABASE_CONNECTION);
			xtc_redirect(xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step1.php', '', $request_type));
		}
		// form
		$smarty->assign('FORM_ACTION', xtc_draw_form('update_configure', xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step2.php', '', $request_type), 'post') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()));
		$smarty->assign('BUTTON_SUBMIT', '<button type="submit">' . BUTTON_FORWARD . '</button>');
		$smarty->assign('FORM_END', '</form>');
		$smarty->assign('success', TEXT_CONFIGURE_SUCCESS);
		$smarty->assign('NEXT_STEP', 'true');
	    $smarty->assign('BUTTON_SHOP', '<a href="' . xtc_href_link('', '', $request_type) . '">' . BUTTON_SHOP . '</a>');
		$smarty->clear_assign('BUTTON_FORWARD');
	}
	else
	{
		// default
//		$db_server = ((defined('DB_SERVER')) ? DB_SERVER : '');
//		$db_database = ((defined('DB_DATABASE')) ? DB_DATABASE : '');
//		$db_username = ((defined('DB_SERVER_USERNAME')) ? DB_SERVER_USERNAME : '');
//		$db_password = ((defined('DB_SERVER_PASSWORD')) ? DB_SERVER_PASSWORD : '');

		$db_type = ((defined('DB_MYSQL_TYPE')) ? DB_MYSQL_TYPE : '');
		$db_charset = (defined('DB_SERVER_CHARSET') ? DB_SERVER_CHARSET : 'utf8');
		$db_pconnect = ((defined('USE_PCONNECT')) ? USE_PCONNECT : 'false');

		$http_server = HTTP_SERVER;
		$https_server = HTTPS_SERVER;
		$use_ssl = ((defined('ENABLE_SSL') && ENABLE_SSL == true) ? 'true' : 'false');
		$session = 'mysql';

		// database
		$db_type_array = array();
		if (function_exists('mysqli_connect'))
		{
			$db_type_array[] = array('id' => 'mysqli', 'text' => 'MySQLi');
		}
		if (function_exists('mysql_connect') && count($db_type_array) > 1)
		{
			$db_type_array[] = array('id' => 'mysql', 'text' => 'MySQL');
		}

		$db_charset_array = array(array('id' => 'latin1', 'text' => 'ISO-8859-15'), array('id' => 'utf8', 'text' => 'UTF-8'),);
		$session_array = array(array('id' => 'mysql', 'text' => 'Datenbank'), array('id' => 'files', 'text' => 'Datei'),);
		$boolean_array = array(array('id' => 'true', 'text' => 'Ja'), array('id' => 'false', 'text' => 'Nein'),);
		$smarty->assign('INPUT_DB_SERVER', xtc_draw_input_fieldNote(array('name' => 'db_server')));
		$smarty->assign('INPUT_DB_USERNAME', xtc_draw_input_fieldNote(array('name' => 'db_username')));
		$smarty->assign('INPUT_DB_PASSWORD', xtc_draw_password_fieldNote(array('name' => 'db_password')));
		$smarty->assign('INPUT_DB_DATABSE', xtc_draw_input_fieldNote(array('name' => 'db_database')));
		$smarty->assign('INPUT_DB_MYSQL_TYPE', xtc_draw_pull_down_menuNote(array('name' => 'db_type'), $db_type_array, $db_type));
		$smarty->assign('INPUT_DB_CHARSET', xtc_draw_pull_down_menuNote(array('name' => 'db_charset'), $db_charset_array, $db_charset));
		$smarty->assign('INPUT_DB_PCONNECT', xtc_draw_pull_down_menuNote(array('name' => 'db_pconnect'), $boolean_array, $db_pconnect));

		// server
		$smarty->assign('INPUT_HTTP_SERVER', xtc_draw_input_fieldNote(array('name' => 'http_server')));
		$smarty->assign('INPUT_HTTPS_SERVER', xtc_draw_input_fieldNote(array('name' => 'https_server')));
		$smarty->assign('INPUT_SESSION', xtc_draw_pull_down_menuNote(array('name' => 'session'), $session_array, $session));
		$smarty->assign('INPUT_USE_SSL', xtc_draw_pull_down_menuNote(array('name' => 'use_ssl'), $boolean_array, $use_ssl));

		$smarty->assign('INPUT_ADMIN_DIRECTORY', xtc_draw_input_fieldNote(array('name' => 'admin_directory'), trim(DIR_ADMIN, '/')));
		$smarty->assign('ADMIN_DIRECTORY_SUGGEST', 'admin_' . xtc_random_charcode(10, true));

		// form
		$smarty->assign('FORM_ACTION', xtc_draw_form('update_configure', xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step1.php', '', $request_type), 'post') . xtc_draw_hidden_field('action', 'process') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()));
		$smarty->assign('BUTTON_SUBMIT', '<button type="submit">' . TEXT_CONFIGURE . '</button>');
		$smarty->assign('FORM_END', '</form>');
		$smarty->assign('BUTTON_FORWARD', '<a href="' . xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step2.php', '', $request_type) . '">' . BUTTON_FORWARD . '</a>');
	}

	if ($messageStack->size('dbhelper_step1') > 0)
	{
		$smarty->assign('error', $messageStack->output('dbhelper_step1'));
	}

	$smarty->assign('language', $_SESSION['language']);
	$module_content = $smarty->fetch('dbhelper_step1.html');

	require ('includes/header.php');
	$smarty->assign('module_content', $module_content);
	$smarty->assign('logo', xtc_href_link(DIR_WS_INSTALLER . 'images/logo_head.png', '', $request_type));

	if (!defined('RM'))
	{
		$smarty->load_filter('output', 'note');
	}
	$smarty->display('index.html');
	require_once ('includes/application_bottom.php');
?>