<?php

require_once '../../../util/pdo/Database.php';

function es($value) {
	return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$db = new Database('ci_demo', 'root', '');

// Just for testing
$users = $db->getAll('membership');
