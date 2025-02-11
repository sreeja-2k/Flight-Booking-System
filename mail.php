<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$baseURL = 'http://localhost/FlightBooking/';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kakularapusreejareddy@gmail.com';
$mail->Password = 'tfjhnbtyreinuqib';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('kakularapusreejareddy@gmail.com');

$mail->isHTML(true);

?>