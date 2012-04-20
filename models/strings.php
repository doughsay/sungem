<?php
namespace strings;
useLib('mysql');

function getStrings() {
	$rows = \mysql\fetchAll("SELECT * FROM some_strings");

	return array_map(function($row) {
		return $row['string'];
	}, $rows);
}