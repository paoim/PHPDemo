<?php

require_once 'app/bootstrap.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Form with SQL Injection Solve Demo</title>
</head>
<body>
	<form action="app/sqlinjection.php" method="post" autocomplete="off">
		<input type="text" name="email_address" placeholder="Enter your email" required>
		<input type="submit" value="Search">
	</form>
</body>
</html>
