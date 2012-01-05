<?php
lib('auth_digest');

function download() {
	$args = func_get_args();
	$file = '../data/'.implode('/', $args);

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
