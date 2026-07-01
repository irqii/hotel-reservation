<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

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

<a href="">Home</a>
<a href="rooms.php">Kamar</a>

<a href="">
<?= $_SESSION['nama']; ?>
</a>

<a href="logout.php">

Logout

</a>

</div>

</div>

</nav>

<section class="hero">

<div>

<h1>Temukan Kamar Terbaik</h1>

<p>

Nikmati pengalaman menginap yang nyaman dengan harga terbaik.

</p>

<a href="rooms.php" class="btn">

Lihat Kamar

</a>

</div>

</section>

<section class="section">

<div class="container">

<h2>Kamar Unggulan</h2>

<div class="room-grid">

<div class="card">

<img src="https://media.dekoruma.com/article/2019/10/15154154/cnn.jpg?fit=300%2C195&ssl=1">

<div class="card-body">

<h3>Deluxe Room</h3>

<p>Rp800.000 / malam</p>

</div>

</div>

<div class="card">

<img src="https://asset.kompas.com/crops/sM6GZYSRLehMdD9kPvH5cPBoI24=/600x400:5400x3600/1200x800/data/photo/2021/10/07/615f210ee5920.jpg">

<div class="card-body">

<h3>Superior Room</h3>

<p>Rp450.000 / malam</p>

</div>

</div>

<div class="card">

<img src="https://www.trimcastlehotel.com/wp-content/uploads/2023/08/image-8-1.jpg">

<div class="card-body">

<h3>Family Room</h3>

<p>Rp550.000 / malam</p>

</div>

</div>

</div>

</div>

</section>

<section class="section">

<div class="container">

<h2>Tentang Hotel</h2>

<p style="text-align:center">

Hotel Reservation menyediakan berbagai pilihan kamar yang nyaman,
bersih, dan modern untuk kebutuhan perjalanan bisnis maupun liburan.

</p>

</div>

</section>

<footer class="footer">

<p>

© 2026 Hotel Reservation

</p>

</footer>

</body>

</html>