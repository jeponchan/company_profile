<?php
session_start();
include("../includes/db.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);

  $result = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");

  if ($result->num_rows > 0) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">
  <h2 class="mb-4">Login Admin</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Login</button>
    <div class="mt-3">
  <a href="../index.php" class="btn btn-secondary">
    Kembali ke Beranda
  </a>
  </form>
</body>
</html>
