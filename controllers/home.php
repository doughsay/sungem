<?php
// you can specify a global layout here but it defaults to 'default'
$layout = 'default';

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
		'layout' => 'default' // you can also specify the layout here
	);
}
?>
