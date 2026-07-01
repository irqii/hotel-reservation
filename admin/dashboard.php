<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$totalRooms = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM rooms"));
$totalBookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings"));

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>

<h1>Dashboard Admin</h1>

<p>Selamat datang, <b><?= $_SESSION['nama']; ?></b></p>

<hr>

<p>Total Kamar : <?= $totalRooms; ?></p>
<p>Total Reservasi : <?= $totalBookings; ?></p>

<hr>

<a href="rooms/index.php">Kelola Kamar</a> |
<a href="../logout.php">Logout</a>

</body>
</html>