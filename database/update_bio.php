<?php
	include("connection.php");
	include("logerror.php");
	session_start();
	$userID = $_SESSION["session"];

	// Controllo i dati e li pulisco
	$bio = trim($_POST["bio"]);
	
	/*if (empty($bio)) {
		header("Refresh: 0, url = ../profile.php");
		exit();
	}*/

	// Preparo la query di Update dei dati dell'utente
	$query = "UPDATE users SET bio = ? WHERE userID = ?";
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi
	$stmt->bind_param('si', $bio, $userID);

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