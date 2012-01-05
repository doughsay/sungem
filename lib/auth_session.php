<?php
session_start();

function requireLogin($redirectUrl) {
	if(!checkSession()) {
		redirect($redirectUrl);
	}
}

function checkSession() {
	return isset($_SESSION['admin_user']);
}

function createSession($username) {
	$_SESSION['admin_user'] = $username;
}

function destroySession() {
	$_SESSION = array();
	session_destroy();
}
?>