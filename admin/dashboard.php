<?php
include('../config.php');

// Fetch guests
$stmt = $conn->prepare("SELECT id, name, email, mobile, attend, photo, created_at FROM guests ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$guests = $result->fetch_all(MYSQLI_ASSOC);

// Analytics
$totalGuests = count($guests);
$attending = count(array_filter($guests, fn($g) => $g['attend'] == 1));
$notAttending = count(array_filter($guests, fn($g) => $g['attend'] == 0));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Wedding Dashboard</title>
<style>
body { font-family: Arial, sans-serif; margin: 20px; background: #f9f9f9; }
h1 { color: #333; }
.summary-cards { display: flex; gap: 20px; margin-bottom: 30px; }
.card { background: #fff; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 6px rgba(0,0,0,0.1); text-align: center; }
.card h3 { margin: 0; font-size: 14px; color: #666; }
.card p { margin: 5px 0 0; font-size: 24px; font-weight: bold; color: #333; }
table { border-collapse: collapse; width: 100%; background: #fff; border-radius: 8px; overflow: hidden; }
th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
th { background-color: #f4f4f4; }
a { color: #3498db; text-decoration: none; }
a:hover { text-decoration: underline; }
img { max-width: 50px; height: auto; border-radius: 4px; }
</style>
</head>
<body>
<h1>Wedding Dashboard</h1>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="card">
        <h3>Total Guests</h3>
        <p><?= $totalGuests ?></p>
    </div>
    <div class="card">
        <h3>Attending</h3>
        <p><?= $attending ?></p>
    </div>
    <div class="card">
        <h3>Not Attending</h3>
        <p><?= $notAttending ?></p>
    </div>
</div>

<!-- Guests Table -->
<h2>Guest List</h2>
<table>
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Attend</th>
    <th>Photo</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($guests as $g): ?>
<tr>
    <td><?= htmlspecialchars($g['id']) ?></td>
    <td><?= htmlspecialchars($g['name']) ?></td>
    <td><?= htmlspecialchars($g['email']) ?></td>
    <td><?= htmlspecialchars($g['mobile']) ?></td>
    <td><?= $g['attend'] == 1 ? '✔' : '✘' ?></td>
    <td>
        <?php if($g['photo']): ?>
            <img src="<?= htmlspecialchars($g['photo']) ?>" alt="Photo">
        <?php endif; ?>
    </td>
    <td>
        <a href="checkin.php?id=<?= $g['id'] ?>">Check-In</a> |
        <a href="badge.php?id=<?= $g['id'] ?>" target="_blank">Badge</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>