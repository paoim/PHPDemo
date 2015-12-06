<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Multiple Files Upload</title>
	<link rel="stylesheet" type="text/css" href="../public/css/" />
</head>
<body>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="file" name="files[]" multiple="multiple">
		<input type="submit" value="Upload">
	</form>
	<script type="text/javascript">
		(function() {
			var ClusureDemo = function() {
				//privare variables
				var localVa1, localVa2;

				//private functions
				var setVaOne = function(newVa) {
					localVa1 = newVa;
				},
				setVaTwo = function(newVa) {
					localVa2 = newVa;
				},
				getVaOne = function() {
					return localVa1;
				},
				getVaTwo = function() {
					return localVa2;
				};

				return {
					//public variables and functions
					outVaOne : localVa1,
					outVaTwo : localVa2,
					setVaOne : setVaOne,
					setVaTwo : setVaTwo,
					getVaOne : getVaOne,
					getVaTwo : getVaTwo
				};
			};

			//Test Demo
			var app = new ClusureDemo();
			app.outVaOne = 'Hello Variable One';
			app.outVaTwo = 'Hello Variable Two';
			app.setVaOne(app.outVaOne);
			app.setVaTwo(app.outVaTwo);
			
			//alert(app.getVaOne());
			//alert(app.getVaTwo());
		})();
	</script>
</body>
</html>
