<?php

require_once 'app/bootstrap.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>XSS Issue Demo</title>
</head>
<body>
	<?php
	foreach ($users as $user) {
		echo "<h1>{$user->first_name} {$user->last_name}</h1>";
		echo "<p>{$user->email_address}</p>";
		echo "<p>{$user->memo}</p>";
	}
	?>
</body>
</html>
