<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}

include "../../config/koneksi.php";

$rooms = mysqli_query($conn, "SELECT * FROM rooms");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kamar</title>
</head>
<body>

<h1>Kelola Kamar</h1>

<a href="create.php">+ Tambah Kamar</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Harga</th>
    <th>Kapasitas</th>
    <th>Aksi</th>
</tr>

<?php

$no = 1;

while ($room = mysqli_fetch_assoc($rooms)) :

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $room['nama']; ?></td>

<td>Rp <?= number_format($room['harga']); ?></td>

<td><?= $room['kapasitas']; ?> Orang</td>

<td>

<a href="edit.php?id=<?= $room['id']; ?>">Edit</a>

|

<a href="delete.php?id=<?= $room['id']; ?>" onclick="return confirm('Hapus kamar?')">

Hapus

</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</body>

</html>