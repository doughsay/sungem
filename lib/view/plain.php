<?php
namespace view;

function plain($view, $type = 'html') {
	if(!isset($GLOBALS['views']['plain'][$view])) {
		$viewFile = "../views/$view.$type";

		if(!file_exists($viewFile)) { msgOr500("There is no such view file: $viewFile"); }

		$c = file_get_contents($viewFile);

		$GLOBALS['views']['plain'][$view] = $c;
	}
	return $GLOBALS['views']['plain'][$view];
}