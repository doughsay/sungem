<?php
function pr($x) {
	print('<pre>');
	print_r($x);
	print('</pre>');
}

function error404() {
	$page = $_SERVER['REQUEST_URI'];
	header('HTTP/1.0 404 Not Found');
	include('../errors/404.php');
	die();
}

function noSuchController($controllerFile) {
	die("There is no such controller file: $controllerFile");
}

function noSuchAction($action, $controllerFile) {
	die("There is no such action, $action, defined in $controllerFile");
}

function noSuchView($viewFile) {
	die("There is no such view file: $viewFile");
}

function noSuchLayout($layoutFile) {
	die("There is no such layout file: $layoutFile");
}

function snippet($name, $args = array()) {
	global $ROOT;
	extract($args);

	ob_start();
	include("../snippets/$name.php");
	return ob_get_clean();
}

function lib($lib) {
	require_once("../lib/$lib.php");
}

function initDb() {
	require_once('../config/db.php');
	return new PDO($dsn, $username, $password, array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	));
}

function loadModel($model) {
	require_once("../models/$model.php");
}
?>