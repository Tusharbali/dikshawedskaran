<?php
// automation/send_whatsapp.php

use Twilio\Rest\Client;

require __DIR__ . '/../vendor/autoload.php';
require_once dirname(__DIR__) . '/config/env.php';

if (!isset($whatsapp_name) || !isset($whatsapp_phone)) {
    throw new Exception("WhatsApp variables missing!");
}

$sid   = getenv('TWILIO_SID');
$token = getenv('TWILIO_TOKEN');
$from  = getenv('TWILIO_WHATSAPP_FROM');
$ccode = getenv('TWILIO_COUNTRY_CODE') ?: '91';

if (!$sid || !$token || !$from) {
    throw new Exception("Twilio credentials missing in .env");
}

$twilio = new Client($sid, $token);

$whatsapp_phone = preg_replace('/\D/', '', $whatsapp_phone);
if (strlen($whatsapp_phone) == 10) {
    $whatsapp_phone = '+' . $ccode . $whatsapp_phone;
}

$messageText =
"💍 *Royal Wedding Invitation* 💍\n\n".
"Dear *{$whatsapp_name}*,\n".
"Thank you for your lovely response ❤️\n\n".
"🎬 *Wedding Video:*\n".
"https://yourdomain.com/videos/invite.mp4\n\n".
"💌 *Digital Invite:*\n".
"https://yourdomain.com/\n\n".
"📍 *Venue Location:*\n".
"https://maps.google.com/?q=Udaipur\n\n".
"With Love ❤️\n".
"*Aarav 💕 Diya*";

$twilio->messages->create(
    "whatsapp:$whatsapp_phone",
    [
        'from' => $from,
        'body' => $messageText
    ]
);