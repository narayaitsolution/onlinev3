<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendmail($email, $nama, $subject, $pesan)
{
	require_once "PHPMailer.php";
	require_once "Exception.php";
	require_once "SMTP.php";

	$mail = new PHPMailer;

	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = "tls://smtp.gmail.com"; //host mail server
	$mail->SMTPAuth = true;
	$mail->Username = "saintekonline@gmail.com";   //nama-email smtp          
	$mail->Password = "ermbdqpchtdiluws";           //password email smtp
	$mail->SMTPSecure = "tls";
	$mail->Port = 587;
	$mail->From = "saintekonline@gmail.com"; //email pengirim
	$mail->FromName = "SAINTEK e-Office"; //nama pengirim
	$mail->addAddress($email, $nama); //email penerima				 
	$mail->isHTML(true);

	$mail->Subject = $subject; //subject
	$mail->Body 	= $pesan; //isi email
	$mail->AltBody = "PHP mailer"; //body email (optional)

	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message has been sent successfully";
	}
}
