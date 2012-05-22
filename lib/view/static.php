<?php
namespace view;

function static_($view, $type = 'html') {
	if(!isset($GLOBALS['views']['static'][$view])) {
		$viewFile = "../views/$view.$type";

		if(!file_exists($viewFile)) { msgOr500("There is no such view file: $viewFile"); }

		ob_start();
		require($viewFile);
		$c = trim(ob_get_clean());

		$GLOBALS['views']['static'][$view] = $c;
	}
	return $GLOBALS['views']['static'][$view];
}