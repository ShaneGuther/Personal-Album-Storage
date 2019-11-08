<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Albums of the Year</title>
		<link rel="stylesheet" href="AlbumDB.css">
	</head>
	<body id="container">
		<h1>Album List</h1>
		<form method="POST" action="addition.php" class="forms">
			<input type="submit" name="submit" value="Add New Value" id="newBtn">
		</form>
		<form class="forms">
			<?php
			require("connect.php");
			$value = $_POST['value'];
			$album = $_POST['album'];
			$artist = $_POST['artist'];
			$genre = $_POST['genre'];

			try{
			$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
			echo 'Connection Successful';
			}catch(PDOException $e){
				echo 'Connection unsuccessful' . $e->getMessage();
			}
			$command = "INSERT INTO album(Value, Album, Artist, Genre) VALUES ('$value','$album','$artist','$genre')";

			$dbConn->exec($command);
			$cmd= "SELECT Value, Album, Artist, Genre FROM album ORDER BY Value";
			$statement = $dbConn->query($cmd);
			$execOk = $statement->execute();
		if($execOk){
			echo '<table>';
			echo '<tr><td>Value</td><td>Album</td><td>Artist</td><td>Genre</td></tr>';
		while($row = $statement->fetch()){
			echo '<tr><td>' . $row[Value] . '</td><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
		}
			echo '</table>';
		}
	?>
	</form>
	</body>
</html>