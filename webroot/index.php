<?php
	$ROOT = '/';

	function error404() {
		$page = $_SERVER['REQUEST_URI'];
		header('HTTP/1.0 404 Not Found');
		include('../errors/404.php');
		die();
	}

	function snippet($name, $args = array()) {
		global $ROOT;
		extract($args);

		ob_start();
		include("../snippets/$name.php");
		return ob_get_clean();
	}

	if(isset($_GET['url'])) {
		$args = explode('/', $_GET['url']);
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
		error404();
	}
	$viewFile = "../views/$controller/$action.php";
	$layoutFile = '../layouts/default.php';

	include($controllerFile);

	if(!function_exists($action)) {
		error404();
	}

	extract($action($args));

	if(!file_exists($viewFile)) {
		error404();
	}
	if(!file_exists($layoutFile)) {
		error404();
	}

	ob_start();
	include($viewFile);
	$content = ob_get_clean();
	include($layoutFile);
?>
