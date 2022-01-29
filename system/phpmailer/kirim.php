<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer.php";
require_once "Exception.php";
require_once "OAuth.php";
require_once "POP3.php";
require_once "SMTP.php";
 
	$mail = new PHPMailer;

	//Enable SMTP debugging. 
	$mail->SMTPDebug = 2;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "tls://smtp.gmail.com"; //host mail server
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "saintekonline@gmail.com";   //nama-email smtp          
	$mail->Password = "tanyaADM1N@)@)";           //password email smtp
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   
 
	$mail->From = "saintekonline@gmail.com"; //email pengirim
	$mail->FromName = "SAINTEK Online"; //nama pengirim
 
	$mail->addAddress($_POST['email'], $_POST['nama']); //email penerima
 
	$mail->isHTML(true);
 
	$mail->Subject = $_POST['subjek']; //subject
    $mail->Body    = $_POST['pesan']; //isi email
        $mail->AltBody = "PHP mailer"; //body email (optional)
 
	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    echo "Message has been sent successfully";
	}

?>
