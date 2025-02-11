<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$baseURL = 'http://localhost:8012/FlightBooking/';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'saiharshavardhan468@gmail.com';
$mail->Password = 'mllyurhevgwhvnne';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('saiharshavardhan468@gmail.com');

$mail->isHTML(true);

?>