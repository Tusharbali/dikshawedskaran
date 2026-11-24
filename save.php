<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$attending = $_POST['attending'];

$photoName="";
if(!empty($_FILES['photo']['name'])){
  $photoName=time()."_".$_FILES['photo']['name'];
  move_uploaded_file($_FILES['photo']['tmp_name'],"uploads/".$photoName);
}

$stmt=$conn->prepare("INSERT INTO wedding_guests(name,email,mobile,attending,photo) VALUES(?,?,?,?,?)");
$stmt->bind_param("sssss",$name,$email,$mobile,$attending,$photoName);
$stmt->execute();

$msg="🌸 Royal Wedding Invitation 🌸%0A%0A".
     "Dear $name,%0A".
     "Thank you for your lovely response 💖%0A%0A".
     "🎬 Wedding Video:%0A".
     "https://yourdomain.com/videos/invite.mp4%0A%0A".
     "🔗 Digital Invite:%0A".
     "https://yourdomain.com/%0A%0A".
     "📍 Venue Location:%0A".
     "https://maps.google.com/?q=Udaipur%0A%0A".
     "With Love 💕%0A".
     "Aarav ❤️ Diya";

header("Location:https://wa.me/91$mobile?text=$msg");
exit;
?>