<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../../vendor/autoload.php';

// Recepient
var_dump($_SESSION);
$receiveAddress = $_SESSION['mail']['address'];
echo $receiveAddress;

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';

// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "tvojudzbenik@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "MileRonta123";

//Set who the message is to be sent from
$mail->setFrom('tvojudzbenik@gmail.com', 'Moj udzbenik');

//Set who the message is to be sent to
$mail->addAddress($receiveAddress);

//We want Č Ć Š Ž
$mail->CharSet = 'utf-8';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
if(isset($_SESSION['mail']['file'])){

	//Set the subject line
	$mail->Subject = 'Nova narudžba';

	//'file' variable will be set if we have to send notification about sold ad
	$mail->msgHTML(file_get_contents('emails/sold-ad.html'), __DIR__);
	unset($_SESSION['mail']);

}
else{

	//In this case we are sending registration email
	//Set the subject line
	$mail->Subject = 'Registracija uspješna';
	$mail->msgHTML(file_get_contents('emails/contents.html'), __DIR__);

}

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}

//exit();

//If you want to save emails in 'Sent Mail' folder, guess Gmail does this by default
//https://github.com/PHPMailer/PHPMailer/blob/master/examples/gmail.phps