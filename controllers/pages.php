<?php

$html = layout('html');

get('/pages/:page', function($page) use ($html) {
	$titles = array(
		'page1' => 'Simple Page 1',
		'page2' => 'Simple Page 2'
	);

	if(!file_exists('../views/pages/'.$page.'.php')) {
		$debug = getConfigVar('core', 'debug', true);
		if($debug) { noSuchView('../views/pages/'.$page); }
		else { error404(); }
	}

	$title = $titles[$page];
	$page = view('pages/'.$page);
	return $html($title, $page());
});