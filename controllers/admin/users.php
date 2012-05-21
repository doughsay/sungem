<?php

get('/admin', function() {
	useLib('auth/session');
	useLib('view/php');

	auth\session\requireLogin('/admin/users/login/');

	$username = sessionVar('admin_user');
	$html = view\php('layouts/html');
	$page = view\php('admin/users/index');

	return $html(array(
		'pageTitle' => 'Admin Section',
		'content' => $page(compact('username'))
	));
});

get('/admin/users/login', function() {
	useLib('view/php');

	$html = view\php('layouts/html');
	$login = view\php('admin/users/login');
	$error = getVar('error', '0') === '1' ? true : false;

	return $html(array(
		'pageTitle' => 'Login',
		'content' => $login(compact('error'))
	));
});

post('/admin/users/login', function() {
	useModel('users');
	useLib('auth/session');

	$username = postVar('username');
	$password = postVar('password');
	if(users\validUser($username, $password)) {
		auth\session\createSession($username);
		redirect('/admin');
	}
	else {
		redirect('/admin/users/login?error=1');
	}
});

get('/admin/users/logout', function() {
	useLib('auth/session');

	auth\session\destroySession();
	redirect('/admin/users/login/');
	die();
});