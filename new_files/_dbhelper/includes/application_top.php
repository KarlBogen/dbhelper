<?php
/* -----------------------------------------------------------------------------------------
   $Id: application_top.php 14530 2022-06-14 10:28:47Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  // set the level of error reporting
  @ini_set('display_errors', false);
  error_reporting(0);

  // set the type of request (secure or not)
  if (file_exists('../includes/request_type.php')) {
    include_once('../includes/request_type.php');
  } else {
    $request_type = 'NONSSL';
  }
  
  // configuration parameters
  require_once(__DIR__.'/configure.php');

  // configuration parameters
  include(__DIR__.'/config.php');

  // default time zone
  date_default_timezone_set(DEFAULT_TIMEZONE);

  // new error handling
  if (!defined('STORE_PARSE_DATE_TIME_FORMAT')) {
    define('STORE_PARSE_DATE_TIME_FORMAT', 'Y-m-d H:i:s');
  }
  if (is_file(DIR_FS_CATALOG.'includes/error_reporting.php')) {
    require_once (DIR_FS_CATALOG.'includes/error_reporting.php');

    $LogLevel = 'WARNING';
    $LoggingManager = new LoggingManager(DIR_FS_LOG.'mod_dbhelper_%s_%s.log', 'modified', strtolower($LogLevel));
  }

  // include the list of project filenames
  require_once (DIR_WS_INCLUDES.'filenames.php');

  // Base/PHP_SELF/SSL-PROXY
  require_once (DIR_FS_INC . 'set_php_self.inc.php');
  $PHP_SELF = set_php_self();

  // list of project database tables
  require_once (DIR_WS_INCLUDES.'database_tables.php');
  
  require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_hidden_field.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_input_field.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_pull_down_menu.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_checkbox_field.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_password_field.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_textarea_field.inc.php');
  require_once (DIR_FS_INC.'xtc_draw_radio_field.inc.php');
  require_once (DIR_FS_INC.'xtc_parse_input_field_data.inc.php');
  require_once (DIR_FS_INC.'xtc_image_button.inc.php');
  require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
  require_once (DIR_FS_INC.'xtc_image.inc.php');
  require_once (DIR_FS_INC.'get_database_version.inc.php');
  require_once (DIR_FS_INC.'xtc_set_time_limit.inc.php');
  require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');
  require_once (DIR_FS_INC.'xtc_rand.inc.php');
  require_once (DIR_FS_INC.'xtc_get_ip_address.inc.php');
  require_once (DIR_FS_INC.'xtc_get_top_level_domain.inc.php');
  
  require_once (DIR_FS_INC.'xtc_not_null.inc.php');
  require_once (DIR_FS_INC.'xtc_href_link.inc.php');
  require_once (DIR_FS_INC.'xtc_redirect.inc.php');
  require_once (DIR_FS_INC.'html_encoding.php');
  
  // delete dir
  clear_dir(DIR_FS_DOCUMENT_ROOT.'cache/');
  clear_dir(DIR_FS_DOCUMENT_ROOT.'templates_c/');

  // set the top level domains
  $http_domain_arr = xtc_get_top_level_domain(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '' ? $_SERVER['HTTP_HOST'] : '');
  $https_domain_arr = xtc_get_top_level_domain(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] != '' ? $_SERVER['HTTP_HOST'] : '');
  $http_domain = $http_domain_arr['domain'];
  $https_domain = $https_domain_arr['domain'];
  $current_domain = (($request_type == 'NONSSL') ? $http_domain : $https_domain);

  // set the top level domains to delete
  $current_domain_delete = (($request_type == 'NONSSL') ? $http_domain_arr['delete'] : $https_domain_arr['delete']);

  // define how the session functions will be used
  require_once (DIR_WS_FUNCTIONS.'sessions.php');

  // set the session name and save path
  // set the session cookie parameters
  // set the session ID if it exists
  // start the session
  // check for Cookie usage
  include_once (DIR_WS_MODULES.'set_session_and_cookie_parameters.php');
  
  require_once(DIR_FS_CATALOG.'includes/classes/message_stack.php');
  $messageStack = new messageStack();

  // smarty
  require_once(DIR_FS_EXTERNAL.'smarty/'.TEMPLATE_ENGINE.'/Smarty.class.php');
  class EvaledFileResource extends Smarty_Internal_Resource_File {
      public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template=null) {
          parent::populate($source, $_template);
          $source->recompiled = true;
      }
  } 

  defined('DIR_WS_BASE') or define('DIR_WS_BASE', xtc_href_link(DIR_WS_INSTALLER, '', $request_type, false, false));

  // auth
  if (file_exists(DIR_FS_CATALOG.'/includes/local/configure.php')) {
    include(DIR_FS_CATALOG.'/includes/local/configure.php');
  } else {
    include(DIR_FS_CATALOG.'/includes/configure.php');
  }

  $upgrade = false;

  $_SESSION['auth'] = true;
  
  if (!isset($_SESSION['language']) || isset($_GET['language'])) {
    $_SESSION['language_charset'] = 'utf-8';

    switch (isset($_GET['language']) ? $_GET['language'] : '') {
      case 'en':
        $_SESSION['language'] = 'english';
        $_SESSION['language_code'] = 'en';
        break;
        
      default:
        $_SESSION['language'] = 'german';
        $_SESSION['language_code'] = 'de';
        break;
    }
  }
?>