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

function redirect($url) {
	header("Location: $url");
}

function isPost() {
	return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function isGet() {
	return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function post($x, $fallback = null) {
	return isset($_POST[$x])
		? $_POST[$x]
		: $fallback;
}

function get($x, $fallback = null) {
	return isset($_GET[$x])
		? $_GET[$x]
		: $fallback;
}

function files($x, $fallback = array()) {
	return isset($_FILES[$x])
		? $_FILES[$x]
		: $fallback;
}

function checkUploadedFile($file) {
	switch($file['error']) {
		case UPLOAD_ERR_OK:
			//Value: 0; There is no error, the file uploaded with success.
			return array(true, $file['error'], null);
		case UPLOAD_ERR_INI_SIZE:
			//Value: 1; The uploaded file exceeds the upload_max_filesize
			//directive in php.ini.
			return array(
				false,
				$file['error'],
				'The uploaded file exceeds the upload_max_filesize directive'.
					' in php.ini.'
			);
		case UPLOAD_ERR_FORM_SIZE:
			//Value: 2; The uploaded file exceeds the MAX_FILE_SIZE
			//directive that was specified in the HTML form.
			return array(
				false,
				$file['error'],
				'The uploaded file exceeds the MAX_FILE_SIZE directive that'.
					' was specified in the HTML form.'
			);
		case UPLOAD_ERR_PARTIAL:
			//Value: 3; The uploaded file was only partially uploaded.
			return array(
				false,
				$file['error'],
				'The uploaded file was only partially uploaded.'
			);
		case UPLOAD_ERR_NO_FILE:
			//Value: 4; No file was uploaded.
			return array(
				false,
				$file['error'],
				'No file was uploaded.'
			);
		case UPLOAD_ERR_NO_TMP_DIR:
			//Value: 6; Missing a temporary folder.
			return array(
				false,
				$file['error'],
				'Missing a temporary folder.'
			);
		case UPLOAD_ERR_CANT_WRITE:
			//Value: 7; Failed to write file to disk.
			return array(
				false,
				$file['error'],
				'Failed to write file to disk.'
			);
		case UPLOAD_ERR_EXTENSION:
			//Value: 8; A PHP extension stopped the file upload.
			return array(
				false,
				$file['error'],
				'A PHP extension stopped the file upload.'
			);
	}
}
?>