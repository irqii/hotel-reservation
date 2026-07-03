<?php

session_start();

require_once "config/koneksi.php";

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){

header("Location: rooms.php");
exit;

}

$id=(int)$_GET['id'];

$stmt=mysqli_prepare(
$conn,
"SELECT * FROM rooms WHERE id=?"
);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$room=mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if(!$room){

header("Location: rooms.php");
exit;

}

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/detail.css">

<?php
include "includes/header.php";
?>

<section class="section">

<div class="container">

<div class="detail-wrapper">

<div class="detail-gallery">

<img
src="uploads/<?= htmlspecialchars($room['foto']) ?>"
alt="<?= htmlspecialchars($room['nama']) ?>">

</div>

<div class="detail-content">

<h1 class="detail-title">

<?= htmlspecialchars($room['nama']) ?>

</h1>

<div class="detail-rating">

★★★★★ 4.9

</div>

<div class="detail-price">

Rp <?= number_format($room['harga'],0,",",".") ?>

<span>

/ malam

</span>

</div>

<div class="detail-info">

<div class="info-box">

<i class="fa-solid fa-user-group"></i>

<?= $room['kapasitas'] ?> Orang

</div>

<div class="info-box">

<i class="fa-solid fa-bed"></i>

Premium Room

</div>

</div>

<div class="detail-description">

<?= nl2br(htmlspecialchars($room['deskripsi'])) ?>

</div>

<div class="detail-feature">

<div>

<i class="fa-solid fa-wifi"></i>

Free WiFi

</div>

<div>

<i class="fa-solid fa-tv"></i>

Smart TV

</div>

<div>

<i class="fa-solid fa-snowflake"></i>

Air Conditioner

</div>

<div>

<i class="fa-solid fa-mug-hot"></i>

Breakfast Included

</div>

<div>

<i class="fa-solid fa-bath"></i>

Private Bathroom

</div>

<div>

<i class="fa-solid fa-square-parking"></i>

Free Parking

</div>

</div>

<div class="detail-action">

<?php if(isset($_SESSION['id'])): ?>

<a
href="booking.php?id=<?= $room['id'] ?>"
class="btn">

Reservasi Sekarang

</a>

<?php else: ?>

<a
href="login.php"
class="btn">

Login Untuk Reservasi

</a>

<?php endif; ?>

<a
href="rooms.php"
class="btn btn-danger">

Kembali

</a>

</div>

</div>

</div>

</div>

</section>

<?php
include "includes/footer.php";
?>