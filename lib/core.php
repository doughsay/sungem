<?php
function pr($x) {
	print('<pre>');
	print_r($x);
	print('</pre>');
}

function assocFallback($a, $k, $f) {
	return isset($a[$k])
		? $a[$k]
		: $f;
}

function error404() {
	header('HTTP/1.0 404 Not Found');
	if(!file_exists('../errors/404.php')) {
		die('404 File not found');
	}
	$page = $_SERVER['REQUEST_URI'];
	require_once('../errors/404.php');
	die();
}

function error500() {
	header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
	if(!file_exists('../errors/500.php')) {
		die('500 Internal server error');
	}
	require_once('../errors/500.php');
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

function noSuchSnippet($snippetFile) {
	die("There is no such snippet file: $snippetFile");
}

function noSuchLib($libFile) {
	die("There is no such library file: $libFile");
}

function noSuchConf($confFile) {
	die("There is no such config file: $confFile");
}

function confError($f, $confFile) {
	die("Config Error: there is no function $f() defined in $confFile");
}

function snippet($name, $args = array()) {
	$snippetFile = "../snippets/$name.php";
	if(!file_exists($snippetFile)) {
		$debug = getConfigVar('core', 'debug');
		if($debug) { noSuchSnippet($snippetFile); }
		else { error500(); }
	}
	extract(getConfig('core'));
	extract($args);
	ob_start();
	require($snippetFile);
	return ob_get_clean();
}

function getConfig($conf) {
	if(!isset($GLOBALS['configMemo'][$conf])) {
		$confFile = "../config/$conf.php";
		if(!file_exists($confFile)) {
			$debug = getConfigVar('core', 'debug');
			if($debug) { noSuchConf($confFile); }
			else { error500(); }
		}
		require_once("../config/$conf.php");
		if(!function_exists($conf)) {
			$debug = getConfigVar('core', 'debug');
			if($debug) { confError($conf, $confFile); }
			else { error500(); }
		}
		$config = $conf();
		$GLOBALS['configMemo'][$conf] = $config;
	}
	return $GLOBALS['configMemo'][$conf];
}

function getConfigVar($conf, $k) {
	$a = getConfig($conf);
	return assocFallback($a, $k, null);
}

function useLib($lib) {
	if(!$GLOBALS['libMemo'][$lib]) {
		$libFile = "../lib/$lib.php";
		if(!file_exists($libFile)) {
			$debug = getConfigVar('core', 'debug');
			if($debug) { noSuchLib($libFile); }
			else { error500(); }
		}
		require_once("../lib/$lib.php");
		$GLOBALS['libMemo'][$lib] = true;
	}
}

function useModel($model) {
	if(!$GLOBALS['modelMemo'][$model]) {
		$modelFile = "../models/$model.php";
		if(!file_exists($modelFile)) {
			$debug = getConfigVar('core', 'debug');
			if($debug) { noSuchModel($modelFile); }
			else { error500(); }
		}
		require_once($modelFile);
		$GLOBALS['modelMemo'][$model] = true;
	}
}

function redirect($url) { header("Location: $url"); }
function isPost() { return $_SERVER['REQUEST_METHOD'] === 'POST'; }
function isGet() { return $_SERVER['REQUEST_METHOD'] === 'GET'; }
function post($k, $f = null) { return assocFallback($_POST, $k, $f); }
function get($k, $f = null) { return assocFallback($_GET, $k, $f); }
function files($k, $f = array()) { return assocFallback($_FILES, $k, $f); }

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