<?php

require_once '../../../util/pdo/Database.php';

$db = new Database('ci_demo', 'root', '');

// Just for testing
$users = $db->getAll('membership');
