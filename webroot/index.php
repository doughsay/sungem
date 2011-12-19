<?php

$ROOT = '/';
$DEBUG = true;

require('../lib/helper_functions.php');

if(isset($_GET['url'])) {
	$args = explode('/', $_GET['url']);
	if($args[count($args)-1] == '') { array_pop($args); }
}
else {
	$args = array();
}

$controller = 'home';
$action = 'index';

if(count($args) >= 1) {
	$controller = array_shift($args);
}

if(count($args) >= 1) {
	$action = array_shift($args);
}

$controllerFile = "../controllers/$controller.php";
if(!file_exists($controllerFile)) {
	if($DEBUG) { noSuchController($controllerFile); }
	else { error404(); }
}
$viewFile = "../views/$controller/$action.php";
$layoutFile = '../layouts/default.php';

include($controllerFile);
if(!function_exists($action)) {
	if($DEBUG) { noSuchAction($action, $controllerFile); }
	else { error404(); }
}

extract(call_user_func_array($action, $args));

if(!file_exists($viewFile)) {
	if($DEBUG) { noSuchView($controllerFile); }
	else { error404(); }
}
if(!file_exists($layoutFile)) {
	if($DEBUG) { noSuchLayout($controllerFile); }
	else { error404(); }
}

ob_start();
include($viewFile);
$content = ob_get_clean();
include($layoutFile);

?>
