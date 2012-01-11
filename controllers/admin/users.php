<?php
useLib('auth_session');
useModel('users');

function index() {
	requireLogin('/admin/users/login/');

	$username = $_SESSION['admin_user'];
	return array(
		'pageTitle' => 'Admin Section',
		'username' => $username
	);
}

function login() {

	$error = false;
	if(isPost()) {
		$username = post('username');
		$password = post('password');
		if(validUser($username, $password)) {
			createSession($username);
			redirect('/admin/');
		}
		else {
			$error = true;
		}
	}

	return array(
		'pageTitle' => 'Login',
		'css' => array('admin'),
		'error' => $error
	);
}

function logout() {
	destroySession();
	redirect('/admin/users/login/');
	die();
}

?>
