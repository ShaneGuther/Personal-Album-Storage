<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Top Albums of 2019</title>
		<link rel="stylesheet" href="AlbumDB.css">
	</head>
	<body id="container">
		<h1>Albums of the year</h1>
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
			require("connect.php");
			$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
			$command = "DELETE FROM album WHERE Value=3";
			$deletion = $dbConn->prepare($command);
			$execOk = $deletion->execute();
			?>
	</body>
</html>