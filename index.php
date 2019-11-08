<!DOCTYPE HTML>
<html>
	<head>
		<!--
		This page will filter selection of music based on the parameters set by the user
		-->
		<meta charset="UTF-8">
		<title>Album Database</title>
		<link rel="stylesheet" href="AlbumDB.css">
	</head>
	<body id="container">
		<form method="POST" action="addition.php" id="forms">
			<h1>Database</h1>
			<br>
			<input type="submit" name="submit" value="Add New Value" id="newBtn">
		</form>

		<form method="POST" action="#" id="form1">
			<input type="text" name="tbd" id="deleteTf">
			<input type="submit" name="Delete" value="Delete Value">
		</form>

		<form method="POST" action="#" id="form2">
			<input type="checkbox" name="genres[]" value="HipHop" class="genChk"><label>Hip-Hop</label>
			<input type="checkbox" name="genres[]" value="Rock" lass="genChk"><label>Rock</label>
			<br>
			<input type="checkbox" name="genres[]" value="SingerSongwriter" lass="genChk"><label>Singer/Songwriter</label>
			<input type="checkbox" name="genres[]" value="Alternative" lass="genChk"><label>Alternative</label>
			<br>
			<input type="checkbox" name="genres[]" value="Jazz" lass="genChk"><label>Jazz</label>
			<input type="checkbox" name="genres[]" value="Pop" lass="genChk"><label>Pop</label>
			<br>
			<input type="checkbox" name="genres[]" value="Country" lass="genChk"><label>Country</label>
			<br>
			<input type="submit" name="submit" value="Update Table">
		<?php
		//Connect to the database using info in connect.php page
		require("connect.php");

		try{
		$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
		//echo 'Connection Successful';
		}catch(PDOException $e){
		echo 'Connection error: ' . $e->getMessage();
		}

			// $hh = $_POST['Hiphop'];
			// $rc = $_POST['Rock'];
			// $ss = $_POST['SingerSongwriter'];
			// $alt = $_POST['Alternative'];
			// $jz = $_POST['Jazz'];
			// $pop = $_POST['Pop'];
			// $ct = $_POST['Country'];

			$value = $_POST['value'];
			$album = $_POST['album'];	
			$artist = $_POST['artist'];
			$genre = $_POST['genres'];
			$tbd = $_POST['tbd'];
			
			
			$sqlGenres = " (";
			foreach($genre as $index => $genres){
					$sqlGenres .= "'".$genres."'".",";
				// }elseif($sqlGenres != ""){
				// }
				}
			
			if($sqlGenres != " ("){
			$sqlGenres = rtrim($sqlGenres, ",");
			$sqlGenres .= ")";
		}
		//Will delete data from the table according to entry into the text field, if nothing is entered query will not execute
		if(isset($tbd)){
		$command = "DELETE FROM album WHERE Value='$tbd'";
			$deletion = $dbConn->prepare($command);
			$execOk = $deletion->execute();
		}
		//Will add a new entry to the database when executed from addition.php -- only runs if value is set
		if(isset($value)){
			try{
			$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
			echo 'Connection Successful';
			}catch(PDOException $e){
				echo 'Connection unsuccessful' . $e->getMessage();
			}
			$cmd = "INSERT INTO album(Value, Album, Artist, Genre) VALUES ('$value','$album','$artist','$genre')";
			$dbConn->exec($cmd);

		}

		if($sqlGenres != " ("){
			$comm = "SELECT Value, Album, Artist, Genre FROM album WHERE Genre IN" . $sqlGenres;
			$stmnt = $dbConn->query($comm);
			$execOk = $stmnt->execute();
			//if($execOk){
				echo '<table>';
				echo '<tr><td>Value</td><td>Album</td><td>Artist</td><td>Genre</td></tr>';
			while($row = $stmnt->fetch()){
				echo '<tr><td>' . $row[Value] . '</td><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
				}
				echo '</table>';
			//}

		}else{
		$command = "SELECT Value, Album, Artist, Genre FROM album ORDER BY Value";
		$statement = $dbConn->query($command);
		$execOk = $statement->execute();
		if($execOk){
			echo '<table>';
			echo '<tr><td>Value</td><td>Album</td><td>Artist</td><td>Genre</td></tr>';
		while($row = $statement->fetch()){
			echo '<tr><td>' . $row[Value] . '</td><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
			}
			echo '</table>';
		}
		}
		
		//$command = "SELECT Value, Album, Artist, Genre FROM album ORDER BY Value";
		//$statement = $dbConn->query($command);
		//$execOk = $statement->execute();

		
		// if($execOk){
		// 	echo '<table>';
		// 	echo '<tr><td>Value</td><td>Album</td><td>Artist</td><td>Genre</td></tr>';
		// 	while($row = $statement->fetch()){
		// 		echo '<tr><td>' . $row[Value] . '</td><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
		// 	}
		// 	echo '</table>';
		// }
				?>
		</form>
	</body>
</html>
