<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}

include('../includes/db.php');

// Autentikasi sederhana
$allowed_access = true; // ganti jadi false jika ingin proteksi dengan login nanti

if (!$allowed_access) {
  die("Akses ditolak.");
}

// Tambah data
if (isset($_POST['tambah'])) {
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);
  $conn->query("INSERT INTO news (title, content) VALUES ('$title', '$content')");
}

// Hapus data
if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  $conn->query("DELETE FROM news WHERE id=$id");
}

// Ambil data untuk edit
$editData = null;
if (isset($_GET['edit'])) {
  $id = intval($_GET['edit']);
  $res = $conn->query("SELECT * FROM news WHERE id=$id");
  $editData = $res->fetch_assoc();
}

// Simpan perubahan edit
if (isset($_POST['simpan'])) {
  $id = intval($_POST['id']);
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);
  $conn->query("UPDATE news SET title='$title', content='$content' WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - Kelola Berita</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Kelola Berita - Admin</h2>
  <a href="logout.php" class="btn btn-sm btn-outline-danger">Logout</a>
</div>

  <!-- Form Tambah/Edit -->
  <form method="POST" class="mb-4">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" class="form-control" required value="<?= $editData['title'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Isi Berita</label>
      <textarea name="content" class="form-control" rows="4" required><?= $editData['content'] ?? '' ?></textarea>
    </div>
    <?php if ($editData): ?>
      <button name="simpan" class="btn btn-warning">Simpan Perubahan</button>
      <a href="admin.php" class="btn btn-secondary">Batal</a>
    <?php else: ?>
      <button name="tambah" class="btn btn-primary">Tambah Berita</button>
    <?php endif; ?>
  </form>

  <!-- Tabel Berita -->
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Judul</th>
        <th>Tanggal</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['title'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
          <a href="admin.php?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="admin.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</body>
</html>
