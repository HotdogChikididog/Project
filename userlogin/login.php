<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

require_once("../include/connection.php");

session_start();

if (isset($_POST["logIn"])) {

	date_default_timezone_set("asia/manila");
	$date = date("M-d-Y h:i A", strtotime("+0 HOURS"));

	$username = mysqli_real_escape_string($conn, $_POST["email_address"]);
	$password = mysqli_real_escape_string($conn, $_POST["user_password"]);

	if (!mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login_user WHERE email_address = '$username'"))) {
		echo "<script type='text/javascript'>alert('USER NOT FOUND');
		document.location='../login.html'</script>";
		exit;
	}

	$token = md5(rand());

	mysqli_query($conn, "UPDATE login_user SET verification_token = '$token' WHERE email_address = '$username'");

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
		//Server settings
		$mail->SMTPDebug = 0;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'generaojonas@gmail.com';                     //SMTP username
		$mail->Password   = 'dnkxeyyblczuqyja';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom('generaojonas@gmail.com');
		$mail->addAddress($username);

		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Login the site';
		$mail->Body    = 'http://localhost/filemanagement/verify.php?token=' . $token;

		$mail->send();
		echo "<script type='text/javascript'>alert('We have sent you a verification link to your email id');
		document.location='../login.html'</script>";
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}