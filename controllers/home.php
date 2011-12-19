<?php
// you can specify a global layout here but it defaults to 'default'
$layout = 'default';

function index() {
	//do stuff here

	// return variables to the view
	return array(
		'title' => 'Home!',
		'foo' => 'This is foo!',
		'bar' => 'And bar!',
		'view' => 'index', // you can specify the view, but it defaults to the
		                   // name of the action
		'layout' => 'default' // you can also specify the layout here
	);
}
?>
