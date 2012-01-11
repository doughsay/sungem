<?php
useLib('mysql');

function getStrings() {
	$rows = fetchAll("SELECT * FROM some_strings");

	return array_map(function($row) {
		return $row['string'];
	}, $rows);
}
?>