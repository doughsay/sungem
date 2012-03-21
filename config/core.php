<?php
function core() {
	return array(
		'debug' => true,
		'root' => '/',
		'httpRoot' => 'http://simplemvc.dev/',
		'title' => 'SimpleMVC',
		'titleSeparator' => ' - ',
		'defaultController' => 'home',
		'defaultAction' => 'index',
		'defaultLayout' => 'html',
		'areas' => array(
			'admin'
		)
	);
}
?>
