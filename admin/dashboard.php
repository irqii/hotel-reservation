<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../config/koneksi.php";

$totalRooms = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM rooms"));

$totalBookings = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM bookings"));

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Dashboard Admin</title>

</head>

<body>

<h1>Dashboard Admin</h1>

<hr>

<p>

Selamat Datang,

<b><?= htmlspecialchars($_SESSION['nama']); ?></b>

</p>

<br>

<p>

Total Kamar :
<b><?= $totalRooms; ?></b>

</p>

<p>

Total Reservasi :
<b><?= $totalBookings; ?></b>

</p>

<br>

<a href="rooms/index.php">

Kelola Kamar

</a>

|

<a href="bookings/index.php">

Kelola Reservasi

</a>

|

<a href="../logout.php">

Logout

</a>

</body>

</html>