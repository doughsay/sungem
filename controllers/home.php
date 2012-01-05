<?php
// you can specify a global layout here but it defaults to 'html'
$layout = 'html';

function index() {
	// do stuff here

	// get some stuff from a database
	loadModel('strings');
	$strings = getStrings();

	// return variables to the view
	return array(
		'title' => 'Home!',
		'foo' => 'This is foo!',
		'bar' => 'And bar!',
		'strings' => $strings,
		'view' => 'index', // you can specify the view, but it defaults to the
		                   // name of the action
		'layout' => 'html' // you can also specify the layout here
	);
}

function some_json() {
	return array(
		'layout' => 'json',
		'skipView' => true, // you can also skip the view entirely, useful for
		'content' => array( // json sometimes, but a complex json object should
			'foo' => 'bar', // probably be built from raw data in a view.
			'baz' => 3.14159
		)
	);
}
?>
