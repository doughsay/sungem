<?php
	$ROOT = '/';
	$DEBUG = true;

	require('../lib/helper_functions.php');

	if(isset($_GET['url'])) {
		$args = explode('/', $_GET['url']);
		if($args[count($args)-1] == '') { array_pop($args); }
		$n = count($args);
	}
	else {
		$args = array();
		$n = 0;
	}

	$controller = 'home';
	$action = 'index';

	if($n >= 1) {
		$controller = $args[0];
	}

	if($n > 1) {
		$action = $args[1];
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

	extract($action($args));

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
