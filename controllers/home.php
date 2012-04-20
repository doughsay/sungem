<?php
useModel('strings');

$html = layout('html');

get('/', function() use ($html) {

	$strings = strings\getStrings();

	$index = view('home/index');

	return $html(
		'Home',
		$index('This is foo!', 'And bar!', $strings)
	);
});

get('/get_example/:foo/:bar', function($foo, $bar) use ($html) {

	$page = view('home/get_example');

	return $html(
		'GET example',
		$page($foo, $bar)
	);
});

get('/post_example', function() use ($html) {

	$page = view('home/post_example');

	return $html(
		'POST example',
		$page()
	);
});

post('/post_example', function() use ($html) {

	$page = view('home/post_example_post');
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

	$json = layout('json');

	return $json($data);
});

get('/readme', function() use ($html) {

	useLib('markdown/markdown');
	return $html('Readme', Markdown(file_get_contents('../data/README.md')));

});