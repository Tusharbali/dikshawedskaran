<?php
include('../config.php');

if (!isset($_GET['id'])) {
    die("No guest ID provided.");
}

$id = intval($_GET['id']);
$conn->query("UPDATE guests SET checked_in = 1 WHERE id = $id");
header("Location: dashboard.php");
exit;