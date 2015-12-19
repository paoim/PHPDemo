<?php

require_once 'bootstrap.php';


/**
 * If user input with sql drop or delete then it will delete or drop from database
 * For example: '; drop table test_table; --
 * Then it will drop test_table from database.
 * Becareful with that, to solve it by using PDO prepare statement
 */
if (isset($_POST['email_address'])) {
	$email = $_POST['email_address'];
	
	$query = $db->query("select * from membership where email_address = '{$email}'");
	$query->setFetchMode(PDO::FETCH_ASSOC);
	echo "<pre>"; print_r($query->fetch()); echo "</pre>";
}

// Just for testing
$query = $db->query("select * from membership");
$query->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $query->fetch()) {
	echo "<pre>"; print_r($row); echo "</pre>";
}
