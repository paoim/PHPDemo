<?php

session_start();

$_SESSION['user_id'] = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
		die('Invalid CSRF token!');
	}
}

$_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(16));
