<?php
$host = getenv('DB_HOST');        // e.g. sql7.freesqldatabase.com
$user = getenv('DB_USER');        // e.g. sql7792186
$pass = getenv('DB_PASSWORD');    // password kamu
$db   = getenv('DB_NAME');        // e.g. sql7792186

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
