<?php
/* -----------------------------------------------------------------------------------------
   $Id: index.php 13421 2021-02-16 15:21:48Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	require_once ('includes/application_top.php');

	defined('CURRENT_TEMPLATE') or define('CURRENT_TEMPLATE', DEFAULT_TEMPLATE);

	// language
	require_once (DIR_FS_INSTALLER . 'lang/' . $_SESSION['language'] . '.php');

	// smarty
	$smarty = new Smarty();
	$smarty->setTemplateDir(__DIR__ . '/templates')
		->registerResource('file', new EvaledFileResource())
		->setConfigDir(__DIR__ . '/lang')
		->SetCaching(0);

	// check for errors
	$error = false;

	// check requirements
	require_once ('includes/check_requirements.php');

	// check permissions
	require_once ('includes/check_permissions.php');

	if ($error === true)
	{
		$smarty->assign('PERMISSION_ARRAY', $permission_array);
		$smarty->assign('REQUIREMENT_ARRAY', $requirement_array);
		$smarty->assign('UNLINKED_ARRAY', $unlinked_files);

		if (count($permission_array['file_permission']) > 0 || count($permission_array['folder_permission']) > 0 || count($permission_array['rfolder_permission']) > 0)
		{
			// ftp
			$smarty->assign('INPUT_FTP_HOST', xtc_draw_input_fieldNote(array('name' => 'ftp_host')));
			$smarty->assign('INPUT_FTP_PORT', xtc_draw_input_fieldNote(array('name' => 'ftp_port')));
			$smarty->assign('INPUT_FTP_PATH', xtc_draw_input_fieldNote(array('name' => 'ftp_path')));
			$smarty->assign('INPUT_FTP_USER', xtc_draw_input_fieldNote(array('name' => 'ftp_user')));
			$smarty->assign('INPUT_FTP_PASS', xtc_draw_input_fieldNote(array('name' => 'ftp_pass')));

			// form
			$smarty->assign('FORM_ACTION', xtc_draw_form('ftp', xtc_href_link(DIR_WS_INSTALLER . basename($PHP_SELF), '', $request_type), 'post') . xtc_draw_hidden_field('action', 'ftp'));
			$smarty->assign('BUTTON_SUBMIT', '<button type="submit">' . BUTTON_SUBMIT . '</button>');
			$smarty->assign('FORM_END', '</form>');
		}

		if ($messageStack->size('ftp_message') > 0)
		{
			$smarty->assign('error', $messageStack->output('ftp_message'));
		}

		$smarty->assign('language', $_SESSION['language']);
		$module_content = $smarty->fetch('error.html');
	}
	else
	{
		$smarty->assign('BUTTON_FORWARD', '<a href="' . xtc_href_link(DIR_WS_INSTALLER . 'dbhelper_step1.php', '', $request_type) . '">' . BUTTON_FORWARD . '</a>');
		$module_content = $smarty->fetch('dbhelper_start.html');
	}

	require ('includes/header.php');
	$smarty->assign('module_content', $module_content);

	$language_array = array(array('link' => xtc_href_link(DIR_WS_INSTALLER . basename($PHP_SELF), 'language=de', $request_type), 'code' => 'de',), array('link' => xtc_href_link(DIR_WS_INSTALLER . basename($PHP_SELF), 'language=en', $request_type), 'code' => 'en',));
	$smarty->assign('language_array', $language_array);
	$smarty->assign('logo', xtc_href_link(DIR_WS_INSTALLER . 'images/logo_head.png', '', $request_type));

	if (!defined('RM'))
	{
		$smarty->load_filter('output', 'note');
	}
	$smarty->display('index.html');
	require_once ('includes/application_bottom.php');
?>