<?php

require('../config/core.php');
require('../lib/core.php');

if(DEBUG) {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);
}

if(isset($_GET['url'])) {
	$args = explode('/', $_GET['url']);
	if($args[count($args)-1] == '') { array_pop($args); }
}
else {
	$args = array();
}

// default area is nothing
$area = '';

if(count($args) >= 1 && in_array($args[0], $areas)) {
	$area = array_shift($args);
	$areaPath = $area . '/';
}

// include area config, could override core config
if($area !== '') {
	require("../config/$area.php");
}

// some defaults
$controller = $defaultController;
$action = $defaultAction;
$layout = $defaultLayout;
$skipView = false;

if(count($args) >= 1) {
	$controller = array_shift($args);
}

if(count($args) >= 1) {
	$action = array_shift($args);
}

// default view is based on the action
$view = $action;

$controllerFile = "../controllers/$areaPath$controller.php";
if(!file_exists($controllerFile)) {
	if(DEBUG) { noSuchController($controllerFile); }
	else { error404(); }
}

// include the controller, this can overwrite variables defined so far
include($controllerFile);

if(!function_exists($action)) {
	if(DEBUG) { noSuchAction($action, $controllerFile); }
	else { error404(); }
}

// call the action, this can overwrite many of the variables defined so far
$vars = call_user_func_array($action, $args);
if(is_array($vars)) {
	extract($vars);
}

$viewFile = "../views/$areaPath$controller/$view.php";
$layoutFile = "../layouts/$layout.php";

if(!$skipView && !file_exists($viewFile)) {
	if(DEBUG) { noSuchView($viewFile); }
	else { error404(); }
}
if(!file_exists($layoutFile)) {
	if(DEBUG) { noSuchLayout($layoutFile); }
	else { error404(); }
}

ob_start();
if(!$skipView) {
	include($viewFile);
	$content = ob_get_clean();
}
include($layoutFile);

?>
