<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Musical Storage</title>
		<link rel="stylesheet" href="AlbumDB.css">
	</head>
	<body id="container">
		<form method="POST" action="index.php" id="forms">
			<input type="number" name="value" required>
			<br>
			<input type="text" name="album" required>
			<br>
			<input type="text" name="artist" required>
			<br>
			<select name="genres">
				<option value="HipHop">Hip-Hop/Rap</option>
				<option value="Rock">Rock</option>
				<option value="Singer/Songwriter">Singer/Songwriter</option>
				<option value="Alternative" placeholder>Alternative</option>
				<option value="Jazz">Jazz</option>
				<option value="Pop">Pop</option>
				<option value="Country">Country</option>
			</select>
			<input type="submit" name="submit" value="Add New Value" id="newBtn">
			</form>
			<?php
			?>
	</body>
</html>
