<?php

$html = phpView('layouts/html');

get('/pages/:page', function($page) use ($html) {
	$titles = array(
		'page1' => 'Simple Page 1',
		'page2' => 'Simple Page 2'
	);

	if(!file_exists('../views/pages/'.$page.'.html')) {
		$debug = getConfigVar('core', 'debug', true);
		if($debug) { noSuchView('../views/pages/'.$page); }
		else { error404(); }
	}

	$title = $titles[$page];
	$page = htmlView('pages/'.$page);
	return $html($title, $page());
});