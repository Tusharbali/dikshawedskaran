<?php
// automation/send_email.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require_once dirname(__DIR__) . '/config/env.php';

if (!isset($email_email) || !isset($email_name)) {
    throw new Exception("Email variables missing!");
}

$mail = new PHPMailer(true);

$host = getenv('SMTP_HOST');
$port = getenv('SMTP_PORT');
$user = getenv('SMTP_USER');
$pass = getenv('SMTP_PASS');
$from = getenv('SMTP_FROM');
$fromName = getenv('SMTP_FROM_NAME');

$mail->isSMTP();
$mail->Host       = $host;
$mail->SMTPAuth   = true;
$mail->Username   = $user;
$mail->Password   = $pass;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = $port;

$mail->setFrom($from, $fromName);
$mail->addAddress($email_email, $email_name);

$mail->isHTML(true);
$mail->Subject = '💍 RSVP Confirmation – Royal Wedding Invitation';

$mail->Body = "
<h2>💍 Royal Wedding Invitation</h2>
<p>Dear <b>{$email_name}</b>,</p>
<p>Thank you for your lovely response ❤️</p>

<p>🎬 <b>Wedding Video:</b><br>
<a href='https://yourdomain.com/videos/invite.mp4'>Watch Video</a></p>

<p>💌 <b>Digital Invite:</b><br>
<a href='https://yourdomain.com/'>View Invitation</a></p>

<p>📍 <b>Venue:</b><br>
<a href='https://maps.google.com/?q=Udaipur'>Open Map</a></p>

<p>With Love ❤️<br><b>Aarav 💕 Diya</b></p>";

$mail->send();