<?php

session_start();

require_once "config/koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: rooms.php");
    exit;

}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM rooms WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$room = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$room) {

    header("Location: rooms.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($room['nama']); ?></title>

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

<div class="detail-content">

<img
src="uploads/<?= htmlspecialchars($room['foto']); ?>"
class="detail-image"
alt="<?= htmlspecialchars($room['nama']); ?>">

<h2>

<?= htmlspecialchars($room['nama']); ?>

</h2>

<br>

<p>

<strong>Harga :</strong>

Rp <?= number_format($room['harga'],0,",","."); ?>

/ malam

</p>

<br>

<p>

<strong>Kapasitas :</strong>

<?= $room['kapasitas']; ?>

Orang

</p>

<br>

<p>

<strong>Deskripsi</strong>

</p>

<br>

<p>

<?= nl2br(htmlspecialchars($room['deskripsi'])); ?>

</p>

<br><br>

<?php if(isset($_SESSION['id'])): ?>

<a
href="booking.php?id=<?= $room['id']; ?>"
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