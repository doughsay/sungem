<?php

get('/pages/page1', function() use ($html) {
	$page = view('pages/page1');
	return $html('Simple Page 1', $page());
});

get('/pages/page2', function() use ($html) {
	$page = view('pages/page2');
	return $html('Simple Page 2', $page());
});