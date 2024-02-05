<?php

	$userID = $_SESSION["session"];
	include("connection.php");
	include ("logerror.php");

	// Query di SELECT
	$placeholder = "SELECT * FROM users WHERE userID = ?";

	// Preparo la query di SELECT
	if(!$stmt = $con->prepare($placeholder)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi
	$stmt->bind_param('i',$userID);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later");
	}

	// Ottengo il risultato
	$result = $stmt->get_result();
	if ($result->num_rows === 0) {
		echo "$result->num_rows affected";
	}
	else {
		$row = $result->fetch_array();
	}

	$first = $row["firstname"];
	$last = $row["lastname"];
	$email = $row["email"];
	$amount = $row["amount"];
	$bio = $row["bio"];	
	$admin = $row["admin"];
	$newsletter = $row["newsletter"];


	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();

?>