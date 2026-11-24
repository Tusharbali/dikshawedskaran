<?php
session_start();
if(!isset($_SESSION['admin'])) die("Login first");
require '../db.php';

$res=$conn->query("SELECT * FROM wedding_rsvp ORDER BY id DESC");
?>

<h2>Guest List</h2>
<table border="1" cellpadding="8">
<tr><th>ID</th><th>Name</th><th>Mobile</th><th>Status</th></tr>
<?php while($r=$res->fetch_assoc()): ?>
<tr>
<td><?=$r['id']?></td>
<td><?=$r['name']?></td>
<td><?=$r['mobile']?></td>
<td><?=$r['checked_in']?'Checked In':'Pending'?></td>
</tr>
<?php endwhile; ?>
</table>