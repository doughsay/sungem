<?php
useLib('mysql');

function getStrings() {
	$db = initDb();
	$st = $db->prepare("SELECT * FROM some_strings");
	$st->execute();

	return array_map(function($s) {
		return $s['string'];
	}, $st->fetchAll());
}

?>