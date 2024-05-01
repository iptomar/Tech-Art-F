<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../../vendor/autoload.php';

$mail = new PHPMailer(true);

//Configure an SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'teamfgestaodeprojetos@gmail.com';  
$mail->Password = 'rjdd hfty xmon pgzu';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

// Sender information
$mail->setFrom('teamfgestaodeprojetos@gmail.com', 'Team F');

// Multiple recipient email addresses and names
// Primary recipients
$mail->addAddress('test-a3kc8vim5@srv1.mail-tester.com', 'Ruben');  

$mail->isHTML(false);

$mail->Subject = 'PHPMailer SMTP test';

$mail->Body    = "PHPMailer the awesome Package\nPHPMailer is working fine for sending mail\nThis is a tutorial to guide you on PHPMailer integration";

// Attempt to send the email
if (!$mail->send()) {
    echo 'Email not sent. An error was encountered: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent.';
}

$mail->smtpClose();