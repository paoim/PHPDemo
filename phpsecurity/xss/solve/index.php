<?php

require_once 'app/bootstrap.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>XSS Solve Demo</title>
</head>
<body>
	<?php
	foreach ($users as $user) {
		$demo = es($user->memo);
		$email = es($user->email_address);
		$name = es($user->first_name) . ' ' . es($user->first_name);
		echo "<h1>{$name}</h1>";
		echo "<p>{$email}</p>";
		echo "<p>{$demo}</p>";
	}
	?>
</body>
</html>
