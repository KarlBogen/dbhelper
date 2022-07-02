<?php
/* -----------------------------------------------------------------------------------------
   $Id: configure.php 14514 2022-06-11 08:34:02Z GTB $

   modified eCommerce Shopsoftware
   http://www.modified-shop.org

   Copyright (c) 2009 - 2013 [www.modified-shop.org]
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // include functions
  require_once('includes/functions.php');

  // global defines
  defined('DIR_MODIFIED_INSTALLER') OR define('DIR_MODIFIED_INSTALLER', '_installer');
  defined('DIR_FS_DOCUMENT_ROOT') OR define('DIR_FS_DOCUMENT_ROOT', get_document_root());
  defined('DIR_FS_CATALOG') OR define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT);
  defined('DIR_WS_CATALOG') OR define('DIR_WS_CATALOG', rtrim(dirname(dirname($_SERVER['PHP_SELF'])), '/').'/');

  // server
  defined('HTTP_SERVER') OR define('HTTP_SERVER', 'http'.(($request_type == 'SSL') ? 's' : '').'://'.$_SERVER['HTTP_HOST']);
  defined('HTTPS_SERVER') OR define('HTTPS_SERVER', 'https://'.$_SERVER['HTTP_HOST']);

  defined('ENABLE_SSL') OR define('ENABLE_SSL', HTTP_SERVER === HTTPS_SERVER);
  
  // session handling
  defined('STORE_SESSIONS') OR define('STORE_SESSIONS', '');
  defined('SESSION_WRITE_DIRECTORY') OR define('SESSION_WRITE_DIRECTORY', sys_get_temp_dir());
  defined('SESSION_FORCE_COOKIE_USE') OR define('SESSION_FORCE_COOKIE_USE', 'False');
  defined('CHECK_CLIENT_AGENT') OR define('CHECK_CLIENT_AGENT', 'False');
  
  // cache
  defined('DB_CACHE_TYPE') OR define('DB_CACHE_TYPE', 'files');
  defined('DIR_FS_CACHE') OR define('DIR_FS_CACHE', 'cache/');

  // timezone
  defined('DEFAULT_TIMEZONE') OR define('DEFAULT_TIMEZONE', 'Europe/Berlin');

  // set admin directory DIR_ADMIN
  require_once(DIR_FS_CATALOG.'inc/set_admin_directory.inc.php');

  // include standard settings
  require_once(DIR_FS_CATALOG.'includes/paths.php');

  defined('DIR_WS_INSTALLER') OR define('DIR_WS_INSTALLER', basename(dirname($_SERVER['PHP_SELF'])).'/');
  defined('DIR_FS_INSTALLER') OR define('DIR_FS_INSTALLER', DIR_FS_CATALOG.DIR_WS_INSTALLER);
    
  if (basename($_SERVER['PHP_SELF']) == 'install_step1.php') {
    defined('DIR_FS_BACKUP') OR define('DIR_FS_BACKUP', DIR_FS_INSTALLER.'includes/sql/');
  } else {
    defined('DIR_FS_BACKUP') OR define('DIR_FS_BACKUP', DIR_FS_CATALOG.DIR_ADMIN.'backups/');
  }
  
  defined('DIR_FS_LANGUAGES') OR define('DIR_FS_LANGUAGES', DIR_FS_CATALOG.'lang/');
?>