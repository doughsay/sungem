<?php
function initDb() {
	if(!isset($GLOBALS['mysql'])) {
		extract(getConfig('db_mysql'));
		$GLOBALS['mysql'] =  new PDO($dsn, $username, $password, array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		));
	}

	return $GLOBALS['mysql'];
}
?>