<?php
useLib('markdown/markdown');

function mdView($view) {
	if(!isset($GLOBALS['views']['md'][$view])) {
		$viewFile = "../views/$view.md";

		if(!file_exists($viewFile)) {
			$debug = getConfigVar('core', 'debug', true);
			if($debug) { noSuchView($viewFile); }
			else { error500(); }
		}

		$c = Markdown(file_get_contents($viewFile));

		$GLOBALS['views']['md'][$view] = function() use ($c) {
			return $c;
		};
	}
	return $GLOBALS['views']['md'][$view];
}
?>