<?php
define('ROOT', dirname(dirname(__FILE__)));

require('../lib/core.php');
extract(getConfig('core'));

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

list($area, $controller, $action, $layout, $args) = parseRequest();

// no area by default
$areaPath = '';

// include area config, could override core config
if($area !== '') {
	extract(getConfig($area));
	$areaPath = $area . '/';
}

// by default, we don't skip views
$skipView = false;

// default view is based on the action
$view = $action;

$controllerFile = "../controllers/$areaPath$controller.php";
if(!file_exists($controllerFile)) {
	if($debug) { noSuchController($controllerFile); }
	else { error404(); }
}

// include the controller, this can overwrite variables defined so far
require_once($controllerFile);

// check if the requested action has a corresponding function
if(!function_exists($action)) {
	if(function_exists('_default')) {
		// function did not exist, but a catch all was defined
		array_unshift($args, $action);
		$action = '_default';
	}
	else {
		// no function to call was found
		if($debug) { noSuchAction($action, $controllerFile); }
		else { error404(); }
	}
}

// call the action, this can overwrite many of the variables defined so far
$vars = call_user_func_array($action, $args);
if(is_array($vars)) {
	extract($vars);
}

$viewFile = "../views/$areaPath$controller/$view.php";
$layoutFile = "../layouts/$layout.php";

if(!$skipView && !file_exists($viewFile)) {
	if($debug) { noSuchView($viewFile); }
	else { error404(); }
}
if(!file_exists($layoutFile)) {
	if($debug) { noSuchLayout($layoutFile); }
	else { error404(); }
}

ob_start();
if(!$skipView) {
	require_once($viewFile);
	$content = ob_get_clean();
}
require_once($layoutFile);

?>
