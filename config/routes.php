<?php
// a simple routing system
// the array key is the URL to listen for, the value is an array representing the path to take
function routes() {
	return array(
		'json' => array('controller' => 'home', 'action' => 'some_json'),
		'page' => array('controller' => 'pages', 'action' => 'show', 'args' => array('page1'))
	);
}
?>