<?php
function initDb() {
	require_once('../config/db.php');
	return new PDO(DSN, USERNAME, PASSWORD, array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	));
}
?>