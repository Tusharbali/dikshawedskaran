<?php
$servername = "127.0.0.1"; // use IP instead of localhost
$username = "root";
$password = "";
$dbname = "wedding_card";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>