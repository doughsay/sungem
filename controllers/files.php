<?php
// a simple file downloader in which you can add extra layers,
// for example, authentication requirements or tracking.

get('/download/*', function($path) {
	$file = '../data/' . $path;

	// check to see if user is logged in here, or add some download tracking
	// info to the db.

	if(!file_exists($file)) { msgOr404('There is no such file'); }

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $file);
	finfo_close($finfo);

	header("content-type: $mime");
	return readfile($file);
});