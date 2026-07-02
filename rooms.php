<?php

session_start();

require_once "config/koneksi.php";

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

<title>Daftar Kamar</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<nav>

<div class="container">

<div class="logo">

Hotel Reservation

</div>

<div class="menu">

<a href="index.php">

Home

</a>

<a href="rooms.php">

Kamar

</a>

<?php if(isset($_SESSION['id'])): ?>

<a href="logout.php">

Logout

</a>

<?php else: ?>

<a href="login.php">

Login

</a>

<a href="register.php">

Register

</a>

<?php endif; ?>

</div>

</div>

</nav>

<section class="section">

<div class="container">

<h2 class="section-title">

Daftar Kamar

</h2>

<div class="room-grid">

<?php if(mysqli_num_rows($query) > 0): ?>

<?php while($room = mysqli_fetch_assoc($query)): ?>

<div class="card">

<?php if(!empty($room['foto'])): ?>

<img
src="uploads/<?= htmlspecialchars($room['foto']); ?>"
alt="<?= htmlspecialchars($room['nama']); ?>">

<?php else: ?>

<img
src="assets/images/no-image.png"
alt="No Image">

<?php endif; ?>

<div class="card-body">

<h3>

<?= htmlspecialchars($room['nama']); ?>

</h3>

<p>

<strong>Harga</strong>

</p>

<p>

Rp <?= number_format($room['harga'],0,",","."); ?>

/ malam

</p>

<p>

<strong>Kapasitas</strong>

</p>

<p>

<?= $room['kapasitas']; ?>

Orang

</p>

<br>

<a
href="room-detail.php?id=<?= $room['id']; ?>"
class="btn">

Lihat Detail

</a>

</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>

Belum ada kamar tersedia.

</p>

<?php endif; ?>

</div>

</div>

</section>

<footer class="footer">

<div class="container">

<p>

&copy; <?= date("Y"); ?>

Hotel Reservation.
All Rights Reserved.

</p>

</div>

</footer>

</body>

</html>