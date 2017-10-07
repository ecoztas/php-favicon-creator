<!DOCTYPE html>
<html>
<head>
    <title>Favicon Creator</title>
    <meta charset="utf-8">

    <style type="text/css">
		.main {
			text-align: center;
		}
    </style>

</head>
<body>

	<div class="main">
		<h1>Favicon Creator</h1>
		
		<!-- form -->
		<form action="./test.php" method="POST" enctype="multipart/form-data">
			<strong>Dimensions:</strong>
			<br><br>
			<select name="dimension">
				<option value="16" selected>16px &nbsp;x&nbsp; 16px</option>
				<option value="32">32px &nbsp;x&nbsp; 32px</option>
				<option value="64">64px &nbsp;x&nbsp; 64px</option>
				<option value="128">128px &nbsp;x&nbsp; 128px</option>
			</select>
			<br><br>
			<strong>Image:</strong>
			<br><br>
			<input type="file" name="file" accept="image/*">
			<br><br>
			<input type="submit" name="submit" value="Convert">
		</form>
			
		<!-- page-refresh-button -->
		<br><br>
		<a href="./test.php">Refresh</a>
		<br><br>
		
		<!-- php-codes -->
		<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!empty($_FILES['file']['name'])) {
				include('./creator.php');
				$result = faviconCreator();
		?>
		
			<strong>Result:</strong>
			<br><br>
			<a href="<?=$result ?>" download="favicon.ico">Download your favicon...</a>
			<br><br>
			<strong>Using:</strong>
			<pre><code>&lt;!-- In head tag --><br>&lt;link rel="icon" href="favicon.ico" type="image/x-icon"></code></pre>
			
		<?php
				} else {
					echo('<strong>Error:</strong> Empty file!');
				}
			}
		?>
	</div>

</body>
</html>

