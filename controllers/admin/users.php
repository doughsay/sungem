<?php
useLib('auth_session');
useModel('users');

$html = phpView('layouts/html');

get('/admin', function() use ($html) {
	auth_session\requireLogin('/admin/users/login/');

	$username = $_SESSION['admin_user'];
	$page = phpView('admin/users/index');

	return $html('Admin Section', $page($username));
});

get('/admin/users/login', function() use ($html) {

	$login = phpView('admin/users/login');
	$error = getVar('error', '0') === '1' ? true : false;

	return $html('Login', $login($error));
});

post('/admin/users/login', function() {
	$username = postVar('username');
	$password = postVar('password');
	if(users\validUser($username, $password)) {
		auth_session\createSession($username);
		redirect('/admin');
	}
	else {
		redirect('/admin/users/login?error=1');
	}
});

get('/admin/users/logout', function() {
	auth_session\destroySession();
	redirect('/admin/users/login/');
	die();
});