<?php
namespace strings;
useLib('db/mysql');
use db\mysql;

function getStrings() {
	$rows = mysql\fetchAll("SELECT * FROM some_strings");

	return array_map(function($row) {
		return $row['string'];
	}, $rows);
}