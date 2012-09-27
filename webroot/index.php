<?php
define('ROOT', dirname(dirname($_SERVER["SCRIPT_FILENAME"])));

require('../lib/core.php');
if(file_exists('../config/core.php')) {
	getConfig('core');
}

if(debug()) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
}
else {
	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . '/logs/error.log');
}

autoloadLibs();

registerRoutes();

dispatch(url()) || noRoute(url());