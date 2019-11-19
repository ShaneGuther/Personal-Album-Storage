<!DOCTYPE HTML>
<html>
	<head>
		<!--
		This page will filter selection of music based on the parameters set by the user
		-->
		<meta charset="UTF-8">
		<title>Musical Storage</title>
		<link rel="stylesheet" href="AlbumDB.css">
	</head>
	<body id="container">
		<h1>Musical Database</h1>
		<form method="POST" action="addition.php" id="forms">
			<input type="submit" name="submit" value="Add New Value" id="newBtn">
		</form>
		<br>
		<form method="POST" action="#" id="form1">
			<input type="text" name="tbd" id="deleteTf">
			<input type="submit" name="Delete" value="Delete Value">
		</form>

		<form method="POST" action="#" id="form2">
			<ul>
			<li><input type="checkbox" name="genres[]" value="HipHop" class="genChk1"><label for="genres[1]">Hip-Hop</label></li>
			<li><input type="checkbox" name="genres[]" value="Rock" class="genChk2"><label for="genres[2]">Rock</label></li>
			<br>
			<li><input type="checkbox" name="genres[]" value="SingerSongwriter" class="genChk1"><label for="genres[3]">Singer/Songwriter</label></li>
			<li><input type="checkbox" name="genres[]" value="Alternative" class="genChk2">	<label for="genres[4]">Alternative</label></li>
			<br>
			<li><input type="checkbox" name="genres[]" value="Jazz" class="genChk1"><label>Jazz</label for="genres[5]"></li>
			<li><input type="checkbox" name="genres[]" value="Pop" class="genChk2"><label>Pop</label for="genres[6]"></li>
			<br>
			<li><input type="checkbox" name="genres[]" value="Country" class="genChk2"><label for="genres[7]">Country</label></li>
			</ul>
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
			$value = $_POST['value'];
			$album = $_POST['album'];	
			$artist = $_POST['artist'];

			//Array of checkbox inputs for filtering
			$genre = $_POST['genres'];
			//to be delected - value that will be removed from table/database
			$tbd = $_POST['tbd'];
			
			
			//Takes the parameters from the array of checkboxes.  Can take 1 or many values, if none are selected full table is shown
			$sqlGenres = " (";
			foreach($genre as $index => $genres){
					$sqlGenres .= "'".$genres."'".",";
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

		//if any checkboxes are selected, this will select only the selected genres
		if($sqlGenres != " ("){
			$comm = "SELECT Value, Album, Artist, Genre FROM album WHERE Genre IN" . $sqlGenres;
			$stmnt = $dbConn->query($comm);
			$execOk = $stmnt->execute();
				echo '<table>';
				echo '<tr><td>Value</td><td>Album</td><td>Artist</td><td>Genre</td></tr>';
			while($row = $stmnt->fetch()){
				echo '<tr><td>' . $row[Value] . '</td><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
				}
				echo '</table>';
			
		//If no checkboxes are selected, select all entries in database
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
		
				?>
		</form>
	</body>
</html>

