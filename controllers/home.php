<?php
useModel('strings');
useLib('markdown_view');

$html = phpView('layouts/html');

get('/', function() use ($html) {

	$strings = strings\getStrings();

	$index = phpView('home/index');

	return $html(
		'Home',
		$index('This is foo!', 'And bar!', $strings)
	);
});

get('/get_example/:foo/:bar', function($foo, $bar) use ($html) {

	$page = phpView('home/get_example');

	return $html(
		'GET example',
		$page($foo, $bar)
	);
});

get('/post_example', function() use ($html) {

	$page = phpView('home/post_example');

	return $html(
		'POST example',
		$page()
	);
});

post('/post_example', function() use ($html) {

	$page = phpView('home/post_example_post');
	$foo = postVar('foo');
	$bar = postVar('bar');

	return $html(
		'POST example',
		$page($foo, $bar)
	);
});

get('/json', function() {

	$data = array(
		'folder1' => array(
			'file1',
			'file2',
			'file3'
		),
		'folder2' => array(
			'folder3' => array(
				'file4',
				'file5'
			)
		)
	);

	$json = phpView('layouts/json');

	return $json($data);
});

get('/readme', function() use ($html) {

	$readme = mdView('home/README');
	return $html('Readme', $readme());

});