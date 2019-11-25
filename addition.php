<!DOCTYPE HTML>
<html>
<?php
			// require("connect.php");
			// $dbConn = new PDO("mysql:host=$hostname;dbname=guthers_albums", $user, $passwd);
			// // $command = "DELETE FROM album WHERE Value=3";
			// // $deletion = $dbConn->prepare($command);
			// // $execOk = $deletion->execute();
			// $command = "SELECT SUM(Value + 1) FROM album ORDER BY DESC LIMIT 1"
			// $statement = $dbConn->query($command);
			// $execOk = $statement->execute();
		?>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="AlbumDB.css">
		<title>Musical Storage</title>
	</head>
	<body class="container">
		
			<h1>Musical Storage</h1>
		<h3>Add new record</h3>

		<form method="POST" action="index.php" id="addForm">
  			<div class="form-group">
    			<label for="albumField">Album</label>
    			<input type="text" name="album" class="form-control" id="albumField" placeholder="Name of album" required>
  			</div>
  			<div class="form-group">
    			<label for="exampleInputPassword1">Artist</label>
    			<input type="text" name="artist" class="form-control" id="albumField" placeholder="Name of Artist" required>
  			</div>
  			Genres<select name="genres">
				<option value="HipHop">Hip-Hop/Rap</option>
				<option value="Rock">Rock</option>
				<option value="Singer/Songwriter">Singer/Songwriter</option>
				<option value="Alternative" placeholder>Alternative</option>
				<option value="Jazz">Jazz</option>
				<option value="Pop">Pop</option>
				<option value="Country">Country</option>
			</select>
  	
 			 <button type="submit" class="btn btn-dark">Submit</button>
		</form>
	</body>
</html>