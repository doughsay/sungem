<?php
// a simple file downloader in which you can add extra layers,
// for example, authentication requirements or tracking.

function download() {
	$args = func_get_args();
	$file = '../data/'.implode('/', $args);

	// check to see if user is logged in here, or add some download tracking
	// info to the db.

	if(!file_exists($file)) {
		if(DEBUG) {
			die('There is no such file');
		}
		else {
			error404();
		}
	}

	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $file);
	finfo_close($finfo);

	header("content-type: $mime");
	die(readfile($file));
}
?>
