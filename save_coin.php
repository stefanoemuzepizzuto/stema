<?php 

	include("database/connection.php");
	include("database/logerror.php");
	session_start();
	$userID = $_SESSION["session"];

	// Controllo i dati e li pulisco
	$coin = trim($_POST["coin"]);
	
	// Preparo la query di SELECT cercando l'email corrispondente nel database
	$query = "UPDATE users SET amount = amount + ? WHERE userID = ?";
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later\n");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi, 'i' sta per int
	$stmt->bind_param('ii',$coin, $userID);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later\n");
	}
    
	header("Refresh: 1, url = ../profile.php");
	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();	
?>