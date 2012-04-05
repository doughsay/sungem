<?php
function regexRoutes() {
	return array(
		'#^pages/([a-z0-9]+)$#' => array('controller' => 'pages', 'action' => 'show')
	);
}
?>