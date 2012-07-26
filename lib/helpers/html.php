<?php
namespace helpers\html;

function js($x) {
	if(!is_array($x)) { $x = array($x); }
	$a = array();
	foreach($x as $src) {
		$a[] = "<script type='text/javascript' src='/js/$src.js'></script>";
	}
	return implode("\n", $a);
}

function css($x) {
	if(!is_array($x)) { $x = array($x); }
	$a = array();
	foreach($x as $href) {
		$a[] = "<link rel='stylesheet' type='text/css' href='/css/$href.css'>";
	}
	return implode("\n", $a);
}