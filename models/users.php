<?php
namespace users;
useLib('db/mysql');
use db\mysql;

function validUser($username, $password) {
	$salt = getConfigVar('security', 'salt');
	$saltedPassword = sha1($salt . $password);

	$query = "
		SELECT COUNT(*) AS valid
		FROM users
		WHERE username = :username
			AND password = :password
	";

	$params = array(
		':username' => $username,
		':password' => $saltedPassword
	);

	$user = mysql\fetch($query, $params);
	return $user['valid'] == '1';
}