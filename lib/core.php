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

function noRoute($url) {
	die("There is no route defined for the url: $url");
}

function noSuchView($viewFile) {
	die("There is no such view file: $viewFile");
}

function noSuchViewFunction($viewFile, $viewName) {
	die("There is no closure \"$$viewName\" defined in the view: $viewFile.");
}

function noSuchModel($modelFile) {
	die("There is no such model file: $modelFile");
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

function getConfig($conf) {
	if(!isset($GLOBALS['configMemo'][$conf])) {
		$confFile = "../config/$conf.php";
		if(!file_exists($confFile)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { noSuchConf($confFile); }
			else { error500(); }
		}
		require_once("../config/$conf.php");
		if(!function_exists($conf)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { confError($conf, $confFile); }
			else { error500(); }
		}
		$config = $conf();
		$GLOBALS['configMemo'][$conf] = $config;
	}
	return $GLOBALS['configMemo'][$conf];
}

function getMaybeConfig($conf) {
	if(!isset($GLOBALS['configMemo'][$conf])) {
		$confFile = "../config/$conf.php";
		if(!file_exists($confFile)) {
			return array();
		}
		require_once("../config/$conf.php");
		if(!function_exists($conf)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { confError($conf, $confFile); }
			else { error500(); }
		}
		$config = $conf();
		$GLOBALS['configMemo'][$conf] = $config;
	}
	return $GLOBALS['configMemo'][$conf];
}

function getConfigVar($conf, $k, $fallback = null) {
	$a = getMaybeConfig($conf);
	return assocFallback($a, $k, $fallback);
}

function useLib($lib) {
	if(!isset($GLOBALS['libMemo'][$lib])) {
		$libFile = "../lib/$lib.php";
		if(!file_exists($libFile)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { noSuchLib($libFile); }
			else { error500(); }
		}
		require_once("../lib/$lib.php");
		$GLOBALS['libMemo'][$lib] = true;
	}
}

function useModel($model) {
	if(!isset($GLOBALS['modelMemo'][$model])) {
		$modelFile = "../models/$model.php";
		if(!file_exists($modelFile)) {
			$debug = getConfigVar('core', 'debug', true);
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
function postVar($k, $f = null) { return assocFallback($_POST, $k, $f); }
function getVar($k, $f = null) { return assocFallback($_GET, $k, $f); }
function filesVar($k, $f = array()) { return assocFallback($_FILES, $k, $f); }

function method() {
	if(isGet()) {
		return 'get';
	}
	else if(isPost()) {
		return 'post';
	}
	else {
		$debug = getConfigVar('core', 'debug', true);
		if($debug) { die('un-handled http request method'); }
		else { error500(); }
	}
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

function slug($phrase, $maxLength = 50) {
	$result = strtolower($phrase);
	$result = preg_replace("/[^a-z0-9\s-]/", "", $result);
	$result = trim(preg_replace("/[\s-]+/", " ", $result));
	$result = trim(substr($result, 0, $maxLength));
	$result = preg_replace("/\s/", "-", $result);
	return $result;
}

function ls($dir, $recursive = false, $extension = null, $prepend = '') {
	if($extension !== null) {
		$extension = strtolower($extension);
	}
	$contents = array();
	if($handle = opendir($dir)) {
		while(false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {

				if($recursive && is_dir($dir . '/' . $entry)) {
					$recursedContents = ls($dir . '/' . $entry, true, $extension, $entry . '/');
					$contents = array_merge($contents, $recursedContents);
				}
				else {

					if($extension !== null) {
						$pathinfo = pathinfo($dir . '/' . $entry);
						if(isset($pathinfo['extension']) && strtolower($pathinfo['extension']) == $extension) {
							$contents[] = $prepend . $entry;
						}
					}
					else {
						$contents[] = $prepend . $entry;
					}

				}
			}
		}
		closedir($handle);
	}
	return $contents;
}

function register($method, $route, $f) {
	$regexify = function($route) {
		$pieces = explode('/', $route);
		foreach($pieces as &$piece) {
			if(substr($piece, 0, 1) === ':') {
				$piece = '([-_A-Za-z0-9]+)';
			}
			if($piece === '*') {
				$piece = '(.+?)';
			}
		}
		return '#^' . implode('/', $pieces) . '/?$#';
	};

	if(substr($route, 0, 1) == '/') {
		$route = ($route === '/')
			? ''
			: substr($route, 1);
	}
	$regex = $regexify($route);
	$GLOBALS['routes'][$method][$regex] = $f;
}

function get($route, $f) {
	register('get', $route, $f);
};

function post($route, $f) {
	register('post', $route, $f);
};

function phpView($view) {
	if(!isset($GLOBALS['views']['php'][$view])) {
		$viewFile = "../views/$view.php";

		$debug = getConfigVar('core', 'debug', true);

		if(!file_exists($viewFile)) {
			if($debug) { noSuchView($viewFile); }
			else { error500(); }
		}

		require_once($viewFile);

		$pieces = explode('/', $view);
		$viewName = array_pop($pieces);

		if(!isset(${$viewName})) {
			if($debug) { noSuchViewFunction($viewFile, $viewName); }
			else { error500(); }
		}
		else {
			$func = ${$viewName};
			$GLOBALS['views']['php'][$view] = function() use ($func) {
				ob_start();
				call_user_func_array($func, func_get_args());
				return ob_get_clean();
			};
		}
	}
	return $GLOBALS['views']['php'][$view];
}

function htmlView($view) {
	if(!isset($GLOBALS['views']['html'][$view])) {
		$viewFile = "../views/$view.html";

		if(!file_exists($viewFile)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { noSuchView($viewFile); }
			else { error500(); }
		}

		ob_start();
		require_once($viewFile);
		$c = trim(ob_get_clean());

		$GLOBALS['views']['html'][$view] = function() use ($c) {
			return $c;
		};
	}
	return $GLOBALS['views']['html'][$view];
}