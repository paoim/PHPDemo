<?php

require_once 'app/bootstrap.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Form without CSRF Issue Demo</title>
</head>
<body>
	<form action="app/delete.php" method="post">
		<input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
		<input type="submit" value="Delete my account">
	</form>
</body>
</html>
