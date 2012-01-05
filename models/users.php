<?php
useLib('mysql');

function validUser($username, $password) {
	$conf = getConfig('core');
	$salt = $conf['salt'];
	$saltedPassword = sha1($salt . $password);

	$db = initDb();
	$st = $db->prepare("
		SELECT COUNT(*) AS valid
		FROM users
		WHERE username = :username
			AND password = :password
	");
	$st->execute(array(
		':username' => $username,
		':password' => $saltedPassword
	));
	$user = $st->fetch();
	return $user['valid'] == '1';
}

?>