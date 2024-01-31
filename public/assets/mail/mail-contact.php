<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

date_default_timezone_set('Etc/UTC');

$name = trim($_POST["your-name"]);
$email = trim($_POST["your-email"]);
$phone = trim($_POST["your-phone"]);
$website = trim($_POST["your-website"]);
$message = trim($_POST["your-message"]);

if(empty($website)){
  $mail = new PHPMailer(true);
  $mail->setFrom('server@adisscaffolding.com', 'Express Merchants Server');
  $mail->addAddress('neil@cornellstudios.com');
  $mail->Subject = 'Express Merchants Form Submission';
  $mail->Body    = 'Name: '. $name .',
  Email: '. $email .',
  Phone: '. $phone .',
  Message: '. $message;

  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message sent!";
  }
}


?>