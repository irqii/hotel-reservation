<?php

session_start();

require_once "config/koneksi.php";

$query = mysqli_query(
    $conn,
    "SELECT * FROM rooms ORDER BY id DESC LIMIT 3"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Hotel Reservation</title>

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

<section class="hero">

<div class="container">

<h1>

Temukan Kamar Hotel Impian Anda

</h1>

<p>

Nikmati pengalaman menginap yang nyaman dengan pilihan kamar terbaik,
harga terjangkau, dan proses reservasi yang mudah.

</p>

<a
href="rooms.php"
class="btn">

Lihat Kamar

</a>

</div>

</section>

<section class="section">

<div class="container">

<h2 class="section-title">

Kamar Unggulan

</h2>

<div class="room-grid">

<?php while($room = mysqli_fetch_assoc($query)): ?>

<div class="card">

<img
src="uploads/<?= htmlspecialchars($room['foto']); ?>"
alt="<?= htmlspecialchars($room['nama']); ?>">

<div class="card-body">

<h3>

<?= htmlspecialchars($room['nama']); ?>

</h3>

<p>

Rp <?= number_format($room['harga'],0,",","."); ?>

/ malam

</p>

<p>

Kapasitas

<?= $room['kapasitas']; ?>

Orang

</p>

<a
href="room-detail.php?id=<?= $room['id']; ?>"
class="btn">

Lihat Detail

</a>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</section>

<section class="section">

<div class="container">

<div class="detail-content">

<h2>

Tentang Hotel

</h2>

<br>

<p>

Hotel Reservation merupakan sistem reservasi hotel sederhana yang
memudahkan pelanggan melihat informasi kamar dan melakukan reservasi
secara online tanpa proses yang rumit.

</p>

<br>

<p>

Kami menyediakan berbagai pilihan kamar dengan fasilitas terbaik untuk
memberikan pengalaman menginap yang nyaman bagi setiap tamu.

</p>

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