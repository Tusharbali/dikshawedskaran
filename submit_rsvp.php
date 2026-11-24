<?php
// submit_rsvp.php

// Load Composer dependencies (Twilio + PHPMailer)
require __DIR__ . '/vendor/autoload.php';

// Include database config
include('config.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check DB connection
if (!$conn) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get form data
$name   = $_POST['name'] ?? '';
$email  = $_POST['email'] ?? '';
$phone  = $_POST['phone'] ?? '';
$attend = $_POST['attend'] ?? 'Pending';

// Validate required fields
if (!$name || !$phone || !$attend) {
    die("Name, Phone, and Attendance are required.");
}

// Handle photo upload
$photoPath = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true); // create uploads folder if not exists
    }
    $photoPath = 'uploads/' . time() . '_' . basename($_FILES['photo']['name']);
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
        die("Failed to upload photo.");
    }
}

// Save guest to database
$stmt = $conn->prepare("INSERT INTO guests (name, email, phone, rsvp_status, photo) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $attend, $photoPath);
$stmt->execute();
$guestId = $stmt->insert_id;
$stmt->close();

// Initialize result trackers
$whatsappSent = false;
$emailSent    = false;
$errors       = [];

// --- SEND WHATSAPP ---
// $whatsappScript = __DIR__ . '/automation/send_whatsapp.php';
// if (file_exists($whatsappScript)) {
//     $whatsapp_name  = $name;
//     $whatsapp_phone = $phone;

//     try {
//         include($whatsappScript); // Must throw exception on failure
//         $whatsappSent = true;
//     } catch (Exception $e) {
//         $errors[] = "WhatsApp not sent: " . $e->getMessage();
//     }
// } else {
//     $errors[] = "WhatsApp script not found.";
// }

$whatsappScript = __DIR__ . '/automation/send_whatsapp.php';

if (file_exists($whatsappScript)) {
    $whatsapp_name  = $name;
    $whatsapp_phone = $phone;

    try {
        include $whatsappScript;
        $whatsappSent = true;
    } catch (Exception $e) {
        $errors[] = "WhatsApp Error: " . $e->getMessage();
    }
} else {
    $errors[] = "WhatsApp script not found.";
}

// --- SEND EMAIL ---
// $emailScript = __DIR__ . '/automation/send_email.php';
// if ($email && file_exists($emailScript)) {
//     $email_name  = $name;
//     $email_email = $email;

//     try {
//         include($emailScript); // Must throw exception on failure
//         $emailSent = true;
//     } catch (Exception $e) {
//         $errors[] = "Email not sent: " . $e->getMessage();
//     }
// } else {
//     if (!$email) $errors[] = "No email provided.";
//     else $errors[] = "Email script not found.";
// }

$emailScript = __DIR__ . '/automation/send_email.php';

if (file_exists($emailScript)) {
    $email_email = $email;
    $email_name  = $name;

    try {
        include $emailScript;
        $emailSent = true;
    } catch (Exception $e) {
        $errors[] = "Email Error: " . $e->getMessage();
    }
} else {
    $errors[] = "Email script not found.";
}

// Build response message
$response = "RSVP submitted successfully!";
if ($whatsappSent && $emailSent) {
    $response .= " Confirmation sent via WhatsApp & Email.";
} else {
    $response .= " But some confirmations failed:";
    foreach ($errors as $err) {
        $response .= " " . $err . ";";
    }
}

// Output the response
echo $response;