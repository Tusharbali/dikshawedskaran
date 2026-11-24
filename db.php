<?php
$conn = new mysqli("localhost", "root", "", "wedding_card", 3307);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}
?>