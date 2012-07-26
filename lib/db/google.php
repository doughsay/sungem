<?php
/* Return the contents of a google doc spreadsheet as a 2d array with google query api */
namespace db\google;

function get($key, $query) {
	$q = urlencode($query);
	$url = "https://spreadsheets.google.com/tq?tqx=out:csv&tq=$q&key=$key";
	$str = file_get_contents($url);
	$lines = explode("\n", trim($str));
	$data = array_map('str_getcsv', $lines);
	return $data;
}