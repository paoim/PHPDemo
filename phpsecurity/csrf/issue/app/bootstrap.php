<?php

session_start();

$_SESSION['user_id'] = 1;

try {
	$db = new PDO('mysql:host=localhost;dbname=ci_demo', 'root', '');
} catch (PDOException $e) {
	echo "<pre>"; print_r($e->getMessage()); echo "</pre>";
}
