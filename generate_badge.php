<?php
require __DIR__ . '/vendor/autoload.php';
use Endroid\QrCode\Builder\Builder;

include('config.php');

$guestId = 1; // Change to the guest ID you want to test
$result = $conn->query("SELECT * FROM guests WHERE id = $guestId");
$guest = $result->fetch_assoc();

if (!$guest) die("Guest not found!");

// Generate QR code with guest ID
$qr = Builder::create()
    ->data("guest_id:{$guest['id']}")
    ->size(200)
    ->build();

$qrFile = 'uploads/qr_'.$guest['id'].'.png';
$qr->saveToFile($qrFile);

// Simple HTML badge for testing
echo "<h2>Guest Badge</h2>";
echo "Name: {$guest['name']}<br>";
echo "RSVP: {$guest['rsvp_status']}<br>";
echo "<img src='$qrFile' alt='QR Code'>";