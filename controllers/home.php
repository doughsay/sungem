<?php

get('/', function() {
	useLib('view/php');
	useModel('strings');

	$strings = strings\getStrings();

	$html = view\php('layouts/html');
	$index = view\php('home/index');

	return $html(array(
		'pageTitle' => 'Home',
		'content' => $index(array(
			'foo' => 'This is foo!',
			'bar' => 'And bar!',
			'strings' => $strings
		))
	));
});

get('/get_example/:foo/:bar', function($foo, $bar) {
	useLib('view/php');

	$html = view\php('layouts/html');
	$page = view\php('home/get_example');

	return $html(array(
		'pageTitle' => 'GET example',
		'content' => $page(compact('foo', 'bar'))
	));
});

get('/post_example', function() {
	useLib('view/php');
	useLib('view/static');

	$html = view\php('layouts/html');

	return $html(array(
		'pageTitle' => 'POST example',
		'content' => view\static_('home/post_example')
	));
});

post('/post_example', function() {
	useLib('view/php');

	$html = view\php('layouts/html');
	$page = view\php('home/post_example');
	$foo = postVar('foo');
	$bar = postVar('bar');

	return $html(array(
		'pageTitle' => 'POST example',
		'content' => $page(compact('foo', 'bar'))
	));
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

	return json($data);
});