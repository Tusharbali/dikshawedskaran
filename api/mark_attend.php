<?php
require '../db.php';
$id=intval($_GET['id']);
$conn->query("UPDATE wedding_rsvp SET checked_in=1 WHERE id=$id");
echo "Guest Checked In Successfully!";
?>