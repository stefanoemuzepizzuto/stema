<?php

include("connection.php");
include("logerror.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'stemacripto@gmail.com';                //Gmail account
    $mail->Password   = 'Stemacripto00.';                       //Gmail password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('stemacripto@gmail.com');

	$query = "SELECT email FROM users WHERE newsletter = 1";
	
	// Preparo la query di SELECT cercando l'email corrispondente nel database
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
	
	if ($result->num_rows === 0) {	
		echo "$result->num_rows affected\n";
	}
	else {
		$row = $result->fetch_array();
	}

	while($row = $result->fetch_array())
	{	
		$mail->AddBCC($row[0]);
	}

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $_POST["subject"];
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->Body    = $_POST["newsletter"];
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
	header("Refresh: 0, url = ../profile.php");
}
catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	header("Refresh: 0, url = ../newsletter.php");
	exit();
}

	// Chiudo lo statement e la connessione (opzionale)
	$stmt->close();
	$con->close();
?>