<?php
	include("connection.php");
	include("logerror.php");
	session_start();
	$userID = $_SESSION["session"];

	// Controlli i dati e li pulisco
	$search = trim($_GET["search"]);

	/*if (empty($search)) {
		header("Refresh: 0, url = search.php");
		exit;
	}*/

	// Per potere usare l'operatore LIKE con i prepared statements
	$search = "%" . $search . "%";
	
	$query = "SELECT * FROM search WHERE keywords or name LIKE ?";

	// Preparo la query di SELECT
	if(!$stmt = $con->prepare($query)) {
		error_log("Prepare failed: (" . $con->errno . ") " . $con->error);
		exit("Something went wrong, visit us ");
	}

	// Lego lo statement ai tipi di parametri che deve aspettarsi
	$stmt->bind_param('s', $search);

	// Eseguo lo statement
	if (!$stmt->execute()) {
		error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		exit("Something went wrong, visit us later");
	}

	// Ottengo il risultato
	$result = $stmt->get_result();
	
	if ($result->num_rows === 0) {
		echo htmlspecialchars("We were unable to find a page with a search term of $search");
		header("Refresh: 2, url = ../home_log.php");
		exit();
	}
	else {
		$row = $result->fetch_array();
	}
	header("Refresh: 0, url = $row[keywords]");
		
	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();
?>