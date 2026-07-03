<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

$query = mysqli_query(
    $conn,
    "SELECT * FROM rooms ORDER BY id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Kamar</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>

<body>

<?php include "../sidebar.php"; ?>

<div class="main">

<div class="topbar">

<div>

<h1 class="page-title">

Kelola Kamar

</h1>

<p>

Manajemen seluruh data kamar BlueWave Hotel.

</p>

</div>

<a
href="create.php"
class="btn">

<i class="fa-solid fa-plus"></i>

Tambah Kamar

</a>

</div>

<div class="table-wrapper">

<table>

<tr>

<th>ID</th>

<th>Foto</th>

<th>Nama</th>

<th>Harga</th>

<th>Kapasitas</th>

<th>Aksi</th>

</tr>

<?php while($room = mysqli_fetch_assoc($query)): ?>

<tr>

<td><?= $room['id']; ?></td>

<td>

<img
src="../../uploads/<?= htmlspecialchars($room['foto']); ?>"
width="120"
style="border-radius:10px;">

</td>

<td><?= htmlspecialchars($room['nama']); ?></td>

<td>

Rp <?= number_format($room['harga'],0,",","."); ?>

</td>

<td>

<?= $room['kapasitas']; ?> Orang

</td>

<td>

<a
href="edit.php?id=<?= $room['id']; ?>"
class="btn btn-warning">

Edit

</a>

<a
href="delete.php?id=<?= $room['id']; ?>"
class="btn btn-danger"
onclick="return confirm('Yakin ingin menghapus kamar ini?')">

Hapus

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>

</html>