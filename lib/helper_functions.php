<?php
function pr($x) {
	print('<pre>');
	print_r($x);
	print('</pre>');
}

function error404() {
	$page = $_SERVER['REQUEST_URI'];
	header('HTTP/1.0 404 Not Found');
	//TODO exist check
	include('../errors/404.php');
	die();
}

function error500() {
	header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
	//TODO exist check
	include('../errors/500.php');
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

function noSuchModel($modelFile) {
	die("There is no such model file: $modelFile");
}

function snippet($name, $args = array()) {
	extract($args);

	ob_start();
	//TODO exist check
	include("../snippets/$name.php");
	return ob_get_clean();
}

function lib($lib) {
	//TODO exist check
	require_once("../lib/$lib.php");
}

function initDb() {
	require_once('../config/db.php');
	return new PDO(DSN, USERNAME, PASSWORD, array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	));
}

function loadModel($model) {
	$modelFile = "../models/$model.php";
	if(!file_exists($modelFile)) {
		if(DEBUG) { noSuchModel($modelFile); }
		else { error500(); }
	}
	require_once($modelFile);
}
?>