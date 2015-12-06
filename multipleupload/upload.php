<?php

require_once '../util/upload/UploadUtil.php';

$destination = '/opt/lampp/temp/testupload';
$files = (!empty($_FILES['files']['name'][0])) ? $_FILES['files'] : array();
$config = array(
		'Files'			=> $files,
		'Destination'	=> $destination
);

define('UPLOAD_DIR', __DIR__);
//define('SITE_ROOT', realpath(dirname(__FILE__)));
//$dirpath = realpath(dirname(getcwd()));

$upload = new UploadUtil($config);
$upload->run();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Multiple Files Upload</title>
</head>
<body>
	<div>
		<fieldset>
			<legend>Files uploaded</legend>
			<ul>
				<?php
					foreach ($upload->getUploads() as $file) {
						echo "<li><a href='$file'>$file</a></li>";
					}
				?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>Files failed</legend>
			<ul>
				<?php
					foreach ($upload->getFails() as $file) {
						echo "<li><a href='$file'>$file</a></li>";
					}
				?>
			</ul>
		</fieldset>
	</div>
	<div>
		<a href="index.html">Try to upload Again</a>
	</div>
</body>
</html>
