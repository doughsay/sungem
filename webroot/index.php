<?php
define('ROOT', dirname(dirname(__FILE__)));

require('../lib/core.php');
extract(getMaybeConfig('core'));
if(!isset($debug)) { $debug = true; }

if($debug) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
}
else {
	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . '/logs/error.log');
}

//include all handlers
$controllers = ls('../controllers', true, 'php');
foreach($controllers as $controller) {
	require_once("../controllers/$controller");
}

$routes = $GLOBALS['routes'];
$url = getVar('url', '');

foreach($routes[method()] as $pattern => $handler) {
	if(preg_match($pattern, $url, $matches) === 1) {
		array_shift($matches);
		$params = $matches;
		echo call_user_func_array($handler, $params);
		die();
	}
}

// Checked all the routes. If it got this far, there was no route to handle
// the passed url
if($debug) { noRoute($url); }
else { error404(); }