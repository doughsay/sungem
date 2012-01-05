<?php
useLib('mysql');

function validUser($username, $password) {
	$saltedPassword = sha1(SALT . $password);

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