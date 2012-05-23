<?php
namespace view;

function static_($view, $type = 'html') {
	if(!isset($GLOBALS['views']['static'][$view])) {
		$viewFile = "../views/$view.$type";

		if(!file_exists($viewFile)) { msgOr500("There is no such view file: $viewFile"); }

		$c = file_get_contents($viewFile);

		$GLOBALS['views']['static'][$view] = $c;
	}
	return $GLOBALS['views']['static'][$view];
}