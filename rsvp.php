<?php
include "config.php";

$name   = $_POST['name'] ?? '';
$email  = $_POST['email'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$attend = $_POST['attend'] ?? '';

if(!$name || !$mobile || !$attend){
  echo "INVALID";
  exit;
}

/* PHOTO UPLOAD */
$photoPath = '';
if(!empty($_FILES['photo']['name'])){
  $dir = "uploads/";
  if(!is_dir($dir)) mkdir($dir,0777,true);
  $photoPath = $dir.time()."_".basename($_FILES['photo']['name']);
  move_uploaded_file($_FILES['photo']['tmp_name'],$photoPath);
}

/* DB SAVE */
$stmt = $conn->prepare("INSERT INTO wedding_rsvp (name,email,mobile,attend,photo) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss",$name,$email,$mobile,$attend,$photoPath);
$stmt->execute();

/* ================= ADMIN WHATSAPP ================= */

$adminMobile = "917082071949"; // ← apna admin number

$msg = "💍 New Wedding RSVP 💍%0A
Name: $name%0A
Mobile: $mobile%0A
Status: $attend";

file_get_contents("https://wa.me/$adminMobile?text=$msg");

/* ================= EMAIL CONFIRMATION ================= */

if($email){

$subject = "Wedding RSVP Confirmation";
$message = "
Hi $name,

Thank you for confirming your presence.

Your Status: $attend

Looking forward to celebrating together 💖

— Wedding Team
";

$headers = "From: Wedding <noreply@yourdomain.com>";

@mail($email,$subject,$message,$headers);
}

echo "SUCCESS";