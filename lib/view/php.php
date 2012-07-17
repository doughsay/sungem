<?php
namespace view;

function php($view) {
	if(!isset($GLOBALS['sungem']['views']['php'][$view])) {
		$viewFile = "../views/$view.php";

		if(!file_exists($viewFile)) { msgOr500("There is no such view file: $viewFile"); }

		$GLOBALS['sungem']['views']['php'][$view] = function($context) use ($viewFile) {
			extract($context);
			ob_start();
			require($viewFile);
			return ob_get_clean();
		};
	}
	return $GLOBALS['sungem']['views']['php'][$view];
}