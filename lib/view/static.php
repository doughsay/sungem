<?php
namespace view;

function static_($view, $type = 'html') {
	if(!isset($GLOBALS['views']['static'][$view])) {
		$viewFile = "../views/$view.$type";

		if(!file_exists($viewFile)) {
			if(debug()) { noSuchView($viewFile); }
			else { error500(); }
		}

		ob_start();
		require($viewFile);
		$c = trim(ob_get_clean());

		$GLOBALS['views']['static'][$view] = $c;
	}
	return $GLOBALS['views']['static'][$view];
}