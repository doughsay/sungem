<?php
define('ROOT', dirname(dirname(__FILE__)));

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

registerRoutes();
dispatch(url());
pr(debug());

// Checked all the routes. If it got this far, there was no route to handle
// the passed url
if(debug()) { noRoute(url()); }
else { error404(); }