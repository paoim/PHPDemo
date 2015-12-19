<?php

require_once 'bootstrap.php';

/**
 * Using prepared statements will help protect you from SQL injection.
 */

if (isset($_POST['email_address'])) {
	$email = $_POST['email_address'];

	$query = $db->prepare("select * from membership where email_address = :email_address");
	$query->execute([
			'email_address' => $email
	]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	echo "<pre>"; print_r($query->fetch()); echo "</pre>";
}

// Just for Testing
$query = $db->prepare("select * from membership");
$query->execute();
$query->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $query->fetch()) {
	echo "<pre>"; print_r($row); echo "</pre>";
}
