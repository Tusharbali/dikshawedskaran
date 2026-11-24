<?php
include('../config.php');

if (!isset($_GET['id'])) die("No guest ID.");

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM guests WHERE id = $id");
$guest = $result->fetch_assoc();
if (!$guest) die("Guest not found.");

$qrData = "GuestID:".$guest['id']." Name:".$guest['name'];
$qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=".urlencode($qrData);
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Guest Badge</title></head>
<body>
<h2>Guest Badge</h2>
<p>Name: <?= htmlspecialchars($guest['name']) ?></p>
<p>Email: <?= htmlspecialchars($guest['email']) ?></p>
<img src="<?= $qrCodeUrl ?>" alt="QR Code">
</body>
</html>