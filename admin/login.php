<?php
session_start();
require '../db.php';

$error = "";

if(isset($_POST['login'])){
  $u = trim($_POST['user']);
  $p = md5($_POST['pass']);

  $stmt = $conn->prepare("SELECT id FROM admin_users WHERE username=? AND password=?");
  $stmt->bind_param("ss", $u, $p);
  $stmt->execute();
  $stmt->store_result();

  if($stmt->num_rows){
    $_SESSION['admin'] = 1;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<style>
*{
  box-sizing:border-box;
  font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

body{
  margin:0;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
  background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
}

.login-card{
  width:100%;
  max-width:380px;
  padding:32px 30px;
  border-radius:14px;
  background: rgba(255,255,255,.08);
  backdrop-filter: blur(12px);
  box-shadow: 0 15px 40px rgba(0,0,0,.35);
  border: 1px solid rgba(255,255,255,.15);
}

.login-card h2{
  text-align:center;
  color:#fff;
  margin-bottom:25px;
  letter-spacing:.5px;
}

.form-group{
  margin-bottom:16px;
}

.form-group input{
  width:100%;
  padding:12px 14px;
  border-radius:8px;
  border:1px solid rgba(255,255,255,.25);
  background: rgba(255,255,255,.12);
  color:#fff;
  font-size:15px;
  outline:none;
  transition:.25s;
}

.form-group input::placeholder{
  color: rgba(255,255,255,.7);
}

.form-group input:focus{
  border-color:#00c6ff;
  background: rgba(255,255,255,.18);
}

.login-btn{
  width:100%;
  padding:12px;
  border:none;
  border-radius:8px;
  background: linear-gradient(135deg,#00c6ff,#0072ff);
  color:#fff;
  font-size:15px;
  font-weight:600;
  cursor:pointer;
  transition:.25s;
}

.login-btn:hover{
  transform: translateY(-1px);
  box-shadow: 0 8px 18px rgba(0,114,255,.4);
}

.error{
  background: rgba(255,0,0,.15);
  color:#ffbaba;
  padding:10px 12px;
  border-radius:8px;
  margin-bottom:14px;
  font-size:14px;
  text-align:center;
  border:1px solid rgba(255,0,0,.35);
}

.footer-text{
  margin-top:15px;
  text-align:center;
  font-size:12px;
  color:rgba(255,255,255,.6);
}

</style>
</head>

<body>

<div class="login-card">

  <h2>Admin Login</h2>

  <?php if($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" autocomplete="off">

    <div class="form-group">
      <input name="user" required placeholder="Username">
    </div>

    <div class="form-group">
      <input name="pass" type="password" required placeholder="Password">
    </div>

    <button class="login-btn" name="login">Login</button>

  </form>

  <div class="footer-text">
    Secure Admin Panel Access
  </div>

</div>

</body>
</html>