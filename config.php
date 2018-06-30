<?php
	
	
	define('DIR',  pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_DIRNAME) . '/');
	define('SCHEME', (is_null($_SERVER['REQUEST_SCHEME']) ? 'http' : $_SERVER['REQUEST_SCHEME']) . '://');
	define('DOMAIN', $_SERVER['SERVER_NAME'] . '/');
	//define('SUBDOMAIN', pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME) . '/');
	define('SUBDOMAIN', str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) != '' ? str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']) . '/' : '');
	define('MAIN',  SCHEME . str_replace('//', '/', DOMAIN . SUBDOMAIN));
	

	define('MODEL',      DIR  . 'model/');
	define('CONTROLLER', DIR  . 'controller/');
	define('VIEW',       DIR  . 'view/');
	define('CSS',        MAIN . 'css/');
	define('JS',         MAIN . 'js/');
	define('IMG',        MAIN . 'img/');
	define('HELPERS',    MAIN . 'helpers/');
	define('FONTS',      MAIN . 'webfonts/');
	
?>