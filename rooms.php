<?php

session_start();

require_once "config/koneksi.php";

$query=mysqli_query(
$conn,
"SELECT * FROM rooms ORDER BY id DESC"
);

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/rooms.css">

<?php
include "includes/header.php";
?>

<section class="section">

<div class="container">

<div class="room-header">

<h1>

Pilihan Kamar

</h1>

<p>

Temukan kamar terbaik dengan fasilitas modern dan pelayanan terbaik dari BlueWave Hotel.

</p>

</div>

<div class="room-grid">

<?php while($room=mysqli_fetch_assoc($query)): ?>

<div class="room-card">

<div class="room-image">

<img
src="uploads/<?= htmlspecialchars($room['foto'])?>">

<div class="room-badge">

Best Choice

</div>

</div>

<div class="room-content">

<h2 class="room-title">

<?= htmlspecialchars($room['nama'])?>

</h2>

<div class="room-price">

Rp <?= number_format($room['harga'],0,",",".")?>

<span style="font-size:15px;color:#64748b;">

/ malam

</span>

</div>

<div class="room-info">

<div>

<i class="fa-solid fa-user-group"></i>

<?= $room['kapasitas']?> Orang

</div>

<div class="rating">

★★★★★

</div>

</div>

<div class="room-feature">

<div>

<i class="fa-solid fa-wifi"></i>

WiFi

</div>

<div>

<i class="fa-solid fa-tv"></i>

Smart TV

</div>

<div>

<i class="fa-solid fa-snowflake"></i>

AC

</div>

<div>

<i class="fa-solid fa-mug-hot"></i>

Breakfast

</div>

</div>

<div class="room-action">

<a
href="room-detail.php?id=<?= $room['id']?>"
class="btn">

Lihat Detail

</a>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</section>

<?php
include "includes/footer.php";
?>