<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../login.php");
    exit;

}

require_once "../config/koneksi.php";

$totalUser = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM users WHERE role='user'"
    )
);

$totalRoom = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM rooms"
    )
);

$totalBooking = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM bookings"
    )
);

$bookingTerbaru = mysqli_query(
    $conn,
    "SELECT
        bookings.*,
        rooms.nama AS kamar
    FROM bookings
    JOIN rooms
    ON bookings.room_id=rooms.id
    ORDER BY bookings.id DESC
    LIMIT 5"
);

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="main">

<div class="topbar">

<div>

<h1 class="page-title">

Dashboard

</h1>

<p>

Selamat datang,

<b><?= htmlspecialchars($_SESSION['nama']) ?></b>

</p>

</div>

<div class="admin-profile">

<i class="fa-solid fa-user-shield"></i>

Administrator

</div>

</div>

<div class="cards">

<div class="card">

<h3>

<i class="fa-solid fa-users"></i>

Total User

</h3>

<p>

<?= $totalUser['total']; ?>

</p>

</div>

<div class="card">

<h3>

<i class="fa-solid fa-bed"></i>

Total Kamar

</h3>

<p>

<?= $totalRoom['total']; ?>

</p>

</div>

<div class="card">

<h3>

<i class="fa-solid fa-calendar-check"></i>

Total Reservasi

</h3>

<p>

<?= $totalBooking['total']; ?>

</p>

</div>

</div>

<div class="table-wrapper">

<h2 style="margin-bottom:20px;">

Reservasi Terbaru

</h2>

<table>

<tr>

<th>Nama</th>

<th>No HP</th>

<th>Kamar</th>

<th>Check In</th>

<th>Status</th>

</tr>

<?php while($booking=mysqli_fetch_assoc($bookingTerbaru)): ?>

<tr>

<td>

<?= htmlspecialchars($booking['nama']) ?>

</td>

<td>

<?= htmlspecialchars($booking['no_hp']) ?>

</td>

<td>

<?= htmlspecialchars($booking['kamar']) ?>

</td>

<td>

<?= htmlspecialchars($booking['check_in']) ?>

</td>

<td>

<?php if($booking['status']=="Pending"): ?>

<span class="badge pending">

Pending

</span>

<?php elseif($booking['status']=="Diterima"): ?>

<span class="badge success">

Diterima

</span>

<?php else: ?>

<span class="badge danger">

Ditolak

</span>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>

</html>