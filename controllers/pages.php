<?php

get('/pages/:page', function($page) {
	useLib('view/static');
	useLib('view/php');

	$titles = array(
		'page1' => 'Simple Page 1',
		'page2' => 'Simple Page 2'
	);

	if(!file_exists('../views/pages/'.$page.'.html')) {
		if(debug()) { noSuchView('../views/pages/'.$page); }
		else { error404(); }
	}

	$pageTitle = $titles[$page];
	$html = view\php('layouts/html');
	$content = view\static_('pages/'.$page);
	return $html(compact('pageTitle', 'content'));
});