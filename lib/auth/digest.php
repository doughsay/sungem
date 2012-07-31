<?php
namespace auth\digest;

function loginHeaders($realm, $nonce, $cancel = 'You are not authorized.') {
	header(
		'WWW-Authenticate: Digest realm="'.$realm
		.'",qop="auth",nonce="'.$nonce
		.'",opaque="'.md5($realm).'"'
	);
	header('HTTP/1.0 401 Unauthorized');
	die($cancel);
}

function getDigest() {
	// mod_php
	if(isset($_SERVER['PHP_AUTH_DIGEST'])) {
		return $_SERVER['PHP_AUTH_DIGEST'];
	}
	// most other servers
	elseif(
		isset($_SERVER['HTTP_AUTHENTICATION']) &&
		strpos(strtolower($_SERVER['HTTP_AUTHENTICATION']), 'digest') === 0
	) {
		return substr($_SERVER['HTTP_AUTHORIZATION'], 7);
	}
	return null;
}

function parseDigest($txt) {

	// protect against missing data
	$needed_parts = [
		'nonce' => 1,
		'nc' => 1,
		'cnonce' => 1,
		'qop' => 1,
		'username' => 1,
		'uri' => 1,
		'response' => 1
	];

	$data = [];
	$keys = implode('|', array_keys($needed_parts));

	preg_match_all(
		'@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@',
		$txt,
		$matches,
		PREG_SET_ORDER
	);

	foreach ($matches as $m) {
		$data[$m[1]] = $m[3] ? $m[3] : $m[4];
		unset($needed_parts[$m[1]]);
	}

	return $needed_parts ? false : $data;
}

function getValidResponse($realm, $digest, $pass) {
	$A1 = md5($digest['username'].':'.$realm.':'.$pass);
	$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$digest['uri']);
	return md5(
		$A1.':'.$digest['nonce'].':'.$digest['nc'].':'.$digest['cnonce'].':'.
		$digest['qop'].':'.$A2
	);
}

function requireLogin($realm, $validUser, $passForUser) {
	$nonce = uniqid();

	$digestStr = getDigest();
	if(is_null($digestStr)) {
		loginHeaders($realm, $nonce);
	}

	$digest = parseDigest($digestStr);

	// quick check
	if(!$validUser($digest['username'])) {
		loginHeaders($realm, $nonce);
	}

	// secure check
	$pass = $passForUser($digest['username']);
	if($digest['response'] != getValidResponse($realm, $digest, $pass)) {
		loginHeaders($realm, $nonce);
	}
}