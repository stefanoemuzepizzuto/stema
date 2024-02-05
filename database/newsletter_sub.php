<?php
	include("connection.php");
	include("logerror.php");
	session_start();
	$userID = $_SESSION["session"];
	
	$query = "UPDATE users SET newsletter = 1 WHERE userID = ?";
	
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi
	$stmt->bind_param('i', $userID);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later");
	}
	header("Refresh: 0, url = ../profile.php");

	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();
?>