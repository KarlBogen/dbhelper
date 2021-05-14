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

	if (isset($_POST['action']) && $_POST['action'] == 'bd_settings')
	{
		$valid_params = array(
			'testmode',
			'ajax_mode',
			'linespersession',
			'delaypersession',
			'string_quotes',
			'query_lines',
		);

		// prepare variables
		foreach ($_POST as $key => $value)
		{
			if ((!isset(${$key}) || !is_object(${$key})) && in_array($key , $valid_params))
			{
				${$key} = addslashes($value);
			}
		}

		//create  includes/configure.php
		include (DIR_FS_INSTALLER . 'templates/bd_settings.php');
		$fp = fopen(DIR_FS_INSTALLER . 'includes/bigdump_settings.php', 'w');
		fputs($fp, $bd_settings);
		fclose($fp);

		// form
		$smarty->assign('FORM_ACTION', xtc_draw_form('update_configure', xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step2.php', '', $request_type), 'post') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()));
		$smarty->assign('BUTTON_SUBMIT', '<button type="submit">' . BUTTON_FORWARD . '</button>');
		$smarty->assign('FORM_END', '</form>');
		$smarty->assign('success', BIGDUMP_SETTINGS_SUCCESS);
		$smarty->assign('NEXT_STEP', 'true');
		$smarty->clear_assign('BUTTON_BACK');
	}
	else
	{

		include(DIR_FS_INSTALLER . '/includes/bigdump_settings.php');

		$testmode = (defined('BIGDUMP_TESTMODE') ? BIGDUMP_TESTMODE : 'false');
		$ajax_mode = (defined('BIGDUMP_AJAX_MODE') ? BIGDUMP_AJAX_MODE : 'true');
		$linespersession = (defined('BIGDUMP_LINESPERSESSION') ? BIGDUMP_LINESPERSESSION : '2000');
		$delaypersession = (defined('BIGDUMP_DELAYPERSESSION') ? BIGDUMP_DELAYPERSESSION : '0');
		$string_quotes = (defined('BIGDUMP_STRING_QUOTES') ? BIGDUMP_STRING_QUOTES : 'quote');
		$query_lines = (defined('BIGDUMP_MAX_QUERY_LINES') ? BIGDUMP_MAX_QUERY_LINES : '300');

		$boolean_array = array(array('id' => 'true', 'text' => 'Ja'), array('id' => 'false', 'text' => 'Nein'),);
		$lines = array(array('id' => '1000', 'text' => '1000'), array('id' => '2000', 'text' => '2000'), array('id' => '3000', 'text' => '3000'), array('id' => '4000', 'text' => '4000'),);
		$delay = array(array('id' => '0', 'text' => '0'), array('id' => '1000', 'text' => '1 s'), array('id' => '2000', 'text' => '2 s'), array('id' => '3000', 'text' => '3 s'), array('id' => '4000', 'text' => '4 s'),);
		$quotes = array(array('id' => 'quote', 'text' => '&nbsp;&nbsp;\'&nbsp;&nbsp;'), array('id' => 'doublequote', 'text' => '&nbsp;&nbsp;"&nbsp;&nbsp;'),);
		$length = array(array('id' => '100', 'text' => '100'), array('id' => '200', 'text' => '200'), array('id' => '300', 'text' => '300'), array('id' => '400', 'text' => '400'),);

		$smarty->assign('INPUT_BIGDUMP_TESTMODE', xtc_draw_pull_down_menuNote(array('name' => 'testmode'), $boolean_array, $testmode));
		$smarty->assign('INPUT_BIGDUMP_AJAX_MODE', xtc_draw_pull_down_menuNote(array('name' => 'ajax_mode'), $boolean_array, $ajax_mode));
		$smarty->assign('INPUT_BIGDUMP_LINESPERSESSION', xtc_draw_pull_down_menuNote(array('name' => 'linespersession'), $lines, $linespersession));
		$smarty->assign('INPUT_BIGDUMP_DELAYPERSESSION', xtc_draw_pull_down_menuNote(array('name' => 'delaypersession'), $delay, $delaypersession));
		$smarty->assign('INPUT_BIGDUMP_STRING_QUOTES', xtc_draw_pull_down_menuNote(array('name' => 'string_quotes'), $quotes, $string_quotes));
		$smarty->assign('INPUT_BIGDUMP_MAX_QUERY_LINES', xtc_draw_pull_down_menuNote(array('name' => 'query_lines'), $length, $query_lines));

		// form
		$smarty->assign('FORM_ACTION', xtc_draw_form('bd_settings', xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_bd_settings.php', '', $request_type), 'post') . xtc_draw_hidden_field('action', 'bd_settings') . xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()));
		$smarty->assign('BUTTON_SUBMIT', '<button type="submit">' . BUTTON_SAVE_SETTINGS . '</button>');
		$smarty->assign('FORM_END', '</form>');
		$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step2.php', '', $request_type) . '">' . BUTTON_BACK . '</a>');
	}

	$smarty->assign('language', $_SESSION['language']);
	$module_content = $smarty->fetch('dbhelper_bd_settings.html');

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