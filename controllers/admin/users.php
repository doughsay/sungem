<?php

function login() {

	$error = false;
	if(isPost()) {
		loadModel('users');
		$username = post('username');
		$password = post('password');
		if(validUser($username, $password)) {
			lib('auth_session');
			createSession($username);
			redirect('/admin/users/who_am_i/');
		}
		else {
			$error = true;
		}
	}

	return array(
		'title' => Login,
		'css' => array('admin'),
		'error' => $error
	);
}

function logout() {
	lib('auth_session');
	destroySession();
	redirect('/admin/users/login/');
}

function who_am_i() {
	lib('auth_session');

	requireLogin('/admin/users/login/');

	$username = $_SESSION['admin_user'];
	return array(
		'title' => 'Who You Are',
		'username' => $username
	);
}

?>