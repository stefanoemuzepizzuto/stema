<?php
	
	include("connection.php");
	include("logerror.php");

    // Controllo che il campo corrispondente sia stato compilato
    $firstname = trim($_POST["firstname"]);
	if(empty($firstname)) {
        echo "Missing \"Firstname\" field\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }
    
	
    $lastname = trim($_POST["lastname"]);
    if(empty($lastname)) {
        echo "Missing \"Lastname\" field\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }
	
	
    $email = trim($_POST["email"]);
    if(empty($email)) {
        echo "Missing \"E-mail\" field\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }
	
	
    $pass = trim($_POST["pass"]);
    if(empty($_POST["pass"])) {
        echo "Missing \"Password\" field\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }
	
	
    $confpass = trim($_POST["confirm"]);
    if(empty($confpass)) {
        echo "Missing \"Confirm password\" field\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }

    // Controllo che le password combacino
    if($pass != $confpass) {
        echo "Password do not match!\n";
		header("Refresh: 1, url = ../registration.php");
		exit();
    }
	
	$hash = password_hash($pass, PASSWORD_DEFAULT);
	
	$query = "SELECT email FROM users WHERE email = ?";
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us later\n");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi, 's' sta per string
	$stmt->bind_param('s',$email);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later\n");
	}
	// Ottengo il risultato
	$result = $stmt->get_result();

	if ($result->num_rows === 1) {	
		echo "<h1>Email already exists</h1>";
		header("Refresh: 2, url = ../login.php");
	}
	else {
	
		// Preparo la query
		$query = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
		
		if(!$stmt = $con->prepare($query)) {
			error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
			exit("Something went wrong, visit us later\n");
		}

		// Lego lo statement ai tipi di parametri che deve aspettarsi
		$stmt->bind_param('ssss', $firstname, $lastname, $email, $hash);

		// Eseguo lo statement
		if(!$stmt->execute()) {
			error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
			exit("Something went wrong, visit us later\n");
		}

		// Controllo che siano state inserite più di una riga
		if($stmt->affected_rows === 0) {
			echo "No rows inserted\n";
			exit;
		}
		else {
			header("Refresh: 0, url = ../login.php");
		}
	}

	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();
	
?>