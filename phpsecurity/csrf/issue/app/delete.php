<?php

require_once 'bootstrap.php';

/**
 * Using prepared statements will help protect you from SQL injection.
 */

$delete = $db->prepare("update membership set active = 0 where ID = :user_id");
$delete->execute([
		'user_id' => $_SESSION['user_id']
]);
//Update cannot return result
//$delete->setFetchMode(PDO::FETCH_ASSOC);
//echo "<pre>"; print_r($delete->fetch()); echo "</pre>";

$query = $db->prepare("select * from membership where ID = :user_id");
$query->execute([
		'user_id' => $_SESSION['user_id']
]);
$query->setFetchMode(PDO::FETCH_ASSOC);
echo "<pre>"; print_r($query->fetch()); echo "</pre>";

$query = $db->prepare("select * from membership");
$query->execute();

$query->setFetchMode(PDO::FETCH_ASSOC);
while($row = $query->fetch()) {
	echo "<pre>"; print_r($row); echo "</pre>";
}

$query = $db->prepare("select * from membership");
$query->execute();

$query->setFetchMode(PDO::FETCH_OBJ);
while($row = $query->fetch()) {
	echo "<pre>"; print_r($row); echo "</pre>";
}
