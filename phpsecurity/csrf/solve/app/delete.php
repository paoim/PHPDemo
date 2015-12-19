<?php


require_once 'bootstrap.php';
require_once '../../../../util/pdo/Database.php';


$db = new Database('ci_demo', 'root', '');

$user = $db->update('membership', array('active' => 1), array('id' => $_SESSION['user_id']))->getCurrentData();
echo "<pre>"; print_r($user); echo "</pre>";

//$user = $db->get('membership', array('id' => $_SESSION['user_id']));
//echo "<pre>"; print_r($user); echo "</pre>";

//$users = $db->getAll('membership');
//echo "<pre>"; print_r($users); echo "</pre>";
