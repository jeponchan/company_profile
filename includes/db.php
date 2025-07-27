<?php
$host = "localhost";
$user = "root";
$pass = ""; // jika kamu tidak pakai password di phpMyAdmin
$dbname = "karyalestari_db"; // atau sesuaikan dengan nama databasenya

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>
