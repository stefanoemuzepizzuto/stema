<?php 
	
	include("connection.php");
	include("logerror.php");
	session_start();
	$userID = $_SESSION["session"];

	// Controllo i dati e li pulisco
	$oldpass = trim($_POST["oldpass"]);
	
	// Controllo che i campi non siano vuoti
	if (empty($oldpass) || empty($newpass) || empty($confpass)) {
		header("Refresh: 0, url = ../update_password.php");
	}

	// Preparo la query di SELECT cercando la password corrispondente nel database
	$query = "SELECT * FROM users WHERE userID = ?";
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later\n");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi, 's' sta per string
	$stmt->bind_param('i',$userID);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later\n");
	}
	// Ottengo il risultato
	$result = $stmt->get_result();
	
	if ($result->num_rows === 0) {	
		echo "$result->num_rows affected\n";
	}
	else {
		$row = $result->fetch_array();
	}

	// Controllo che l'hash della password coincida con la password del form tramite password_verify()
	if(!password_verify($oldpass, $row["password"])) {
		echo "<h1>Incorrect old password, try again</h1>\n";
		header("Refresh: 1, url = ../update_password.php");
		exit;
	}
	else {
		
		$newpass = trim($_POST["newpass"]);
		if(empty($_POST["newpass"])) {
			echo "Missing \"Password\" field\n";
			header("Refresh: 1, url = ../registration.php");
			exit();
		}
	
	
    	$confpass = trim($_POST["confpass"]);
		if(empty($confpass)) {
			echo "Missing \"Confirm password\" field\n";
			header("Refresh: 1, url = ../registration.php");
			exit();
    }

		// Controllo che le password combacino
		if($newpass != $confpass) {
			echo "Password do not match!\n";
			header("Refresh: 1, url = ../registration.php");
			exit();
		}
	
		$hash = password_hash($newpass, PASSWORD_DEFAULT);
		
		// Preparo la query di Update dei dati dell'utente
		$query = "UPDATE users SET password = ? WHERE userID = ?";
		if(!$stmt = $con->prepare($query)) {
			error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
			exit("Something went wrong, visit us later");
		}

		// Lego lo statement ai tipi di parametri che deve aspettarsi
		$stmt->bind_param('si', $hash, $userID);

		// Eseguo lo statement
		if (!$stmt->execute()) {
			error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			exit("Something went wrong, visit us later");
		}
		header("Refresh: 0, url = logout.php");
		
		
	}

	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();
	
?>