<?php
include "config.php";
$q = $conn->query("SELECT photo FROM wedding_rsvp WHERE photo!='' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Guest Gallery</title>
<style>
body{background:#111;font-family:Arial}
.gallery{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;padding:20px}
.gallery img{width:100%;border-radius:12px;transition:.3s}
.gallery img:hover{transform:scale(1.05)}
</style>
</head>
<body>

<div class="gallery">
<?php while($p=$q->fetch_assoc()){ ?>
<img src="<?= $p['photo'] ?>">
<?php } ?>
</div>

</body>
</html>