<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

$query = mysqli_query(
    $conn,
    "SELECT
        bookings.*,
        rooms.nama AS kamar
    FROM bookings
    JOIN rooms
    ON bookings.room_id = rooms.id
    ORDER BY bookings.id DESC"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Reservasi</title>

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

Kelola Reservasi

</h1>

<p>

Seluruh data reservasi pelanggan BlueWave Hotel.

</p>

</div>

</div>

<div class="table-wrapper">

<table>

<tr>

<th>ID</th>

<th>Nama</th>

<th>No HP</th>

<th>Kamar</th>

<th>Check In</th>

<th>Check Out</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php while($booking = mysqli_fetch_assoc($query)): ?>

<tr>

<td><?= $booking['id']; ?></td>

<td><?= htmlspecialchars($booking['nama']); ?></td>

<td><?= htmlspecialchars($booking['no_hp']); ?></td>

<td><?= htmlspecialchars($booking['kamar']); ?></td>

<td><?= htmlspecialchars($booking['check_in']); ?></td>

<td><?= htmlspecialchars($booking['check_out']); ?></td>

<td>

<?php if($booking['status']=="Pending"): ?>

<span class="badge pending">Pending</span>

<?php elseif($booking['status']=="Diterima"): ?>

<span class="badge success">Diterima</span>

<?php else: ?>

<span class="badge danger">Ditolak</span>

<?php endif; ?>

</td>

<td>

<a
href="./status.php?id=<?= $booking['id']; ?>&status=Diterima"
class="btn btn-success">

Terima

</a>

<a
href="./status.php?id=<?= $booking['id']; ?>&status=Pending"
class="btn btn-warning">

Pending

</a>

<a
href="./status.php?id=<?= $booking['id']; ?>&status=Ditolak"
class="btn btn-danger">

Tolak

</a>

<a
href="./delete.php?id=<?= $booking['id']; ?>"
class="btn btn-danger"
onclick="return confirm('Hapus reservasi ini?')">

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