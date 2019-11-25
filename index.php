<!DOCTYPE HTML>
<html>
	<head>
		<!--
		This page will filter selection of music based on the parameters set by the user
		-->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="AlbumDB.css">
		<title>Musical Storage</title>
	</head>
	<script type="text/javascript">
		function popup(){
			var dltPop = document.getElementById("dltForm");
			dltPop.style.display = "block";
			var dltBtn = document.getElementById("dltBtn");
			dltBtn.style.display = "none";
		}
	</script>
	<body class="container">		
			<h1>Musical Database</h1>
			<form method="POST" action="addition.php" id="addForm">
				<button class="btn btn-dark" type="submit">Add New Value</button>
			</form>
			<div>
			<button class="btn btn-dark" id="dltBtn" name="Delete" onclick="popup()">Delete Value</button>
		</div>
			<form method="POST" action="#" id="dltForm">
				<input type="text" name="tbd" id="deleteTf" placeholder="Enter value to delete">
				<br>
				<button class="btn btn-dark" type="submit" name="submitDlt">Delete Value</button>
			</form>
			<br>

			<form method="POST" action="#" id="form2">
	
		<div class="form-check form-check-inline">
  			<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="genres[]"  value="HipHop">
  			<label class="form-check-label" for="inlineCheckbox1">Hip-Hop</label>
		</div>
		<div class="form-check form-check-inline">
 			<input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="genres[]" value="Rock">
  			<label class="form-check-label" for="inlineCheckbox2">Rock</label>
		</div>
		<div class="form-check form-check-inline">
  			<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="genres[]" value="Singer/Songwriter">
  			<label class="form-check-label" for="inlineCheckbox3">Singer/Songwriter</label>
		</div>
		<br>
		<div class="form-check form-check-inline">
 			<input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="genres[]" value="Alternative">
  			<label class="form-check-label" for="inlineCheckbox1">Alternative</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="genres[]" value="Jazz">
  			<label class="form-check-label" for="inlineCheckbox2">Jazz</label>
		</div>
		<div class="form-check form-check-inline">
  			<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="genres[]" value="Pop">
  			<label class="form-check-label" for="inlineCheckbox3">Pop</label>
		</div>
		<div class="form-check form-check-inline">
  			<input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="genres[]" value="Country">
  			<label class="form-check-label" for="inlineCheckbox3">Country</label>
		</div>
		<br>
			<button type="submit" class="btn btn-dark">Update Table</button>

		<?php
		//Connect to the database using info in connect.php page
		require("connect.php");

		try{
		$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
		}catch(PDOException $e){
		echo 'Connection error: ' . $e->getMessage();
		}
			$value = $_POST['value'];
			$album = $_POST['album'];	
			$artist = $_POST['artist'];

			//Array of checkbox inputs for filtering
			$genre = $_POST['genres'];
			//to be deleted - value that will be removed from table/database
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
			echo "<script>console.log('".$sqlGenres."'); </script>";


		//Will delete data from the table according to entry into the text field, if nothing is entered query will not execute
		if(isset($tbd)){
			$command = "DELETE FROM album WHERE Value='$tbd'";
			$deletion = $dbConn->prepare($command);
			$deletion->execute();
			/*Set auto increment to the current highest value, so the next entry will be +1
			Still working on updating table as it goes	*/
			$altercmd = "ALTER TABLE album AUTO_INCREMENT = 0";
			$dbConn->exec($altercmd);
			
		
		}
		
		//Will add a new entry to the database when executed from addition.php -- only runs if value is set
		if(isset($album)){
			try{
			$dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
			}catch(PDOException $e){
				echo 'Connection unsuccessful' . $e->getMessage();
			}
			$cmd = "INSERT INTO album(Album, Artist, Genre) VALUES ('$album','$artist','$genre')";
			$dbConn->exec($cmd);
		}

		//if any checkboxes are selected, this will select only the selected genres
		if($sqlGenres != " ("){
			$comm = "SELECT Value, Album, Artist, Genre FROM album WHERE Genre IN" . $sqlGenres . "ORDER BY Value";
			$stmnt = $dbConn->query($comm);
			$execOk = $stmnt->execute();
				echo '<table class="table table-striped">';
				echo '<thead><tr><th scope="col">Value</th><th scope="col">Album</th><th scope="col">Artist</th><th scope="col">Genre</th></tr></thead><tbody>';
			while($row = $stmnt->fetch()){
				echo '<tr><th scope="row">' . $row[Value] . '</th><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
				}
				echo '</tbody></table>';
			
		//If no checkboxes are selected, select all entries in database
		}else{
		$command2= "SELECT Value, Album, Artist, Genre FROM album ORDER BY Value";
		$statement = $dbConn->query($command2);
		$execOk = $statement->execute();
		if($execOk){
			echo '<table class="table table-striped">';
			echo '<thead><tr><th scope="col">Value</th><th scope="col">Album</th><th scope="col">Artist</th><th scope="col">Genre</th></tr></thead><tbody>';
		while($row = $statement->fetch()){
			echo '<tr><th scope="row">' . $row[Value] . '</th><td>' . $row[Album] . '</td><td>' . $row[Artist] . '</td><td>' . $row[Genre] . '</td></tr>';
			}
			echo '</tbody></table>';
		}
		}
	
				?>
			</form>
		
	</body>
</html>
