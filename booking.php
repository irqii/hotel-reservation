<?php

session_start();

if(!isset($_SESSION['id'])){

header("Location: login.php");
exit;

}

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

$success="";
$error="";

if(isset($_POST['booking'])){

$nama=trim($_POST['nama']);
$hp=trim($_POST['no_hp']);
$checkIn=$_POST['check_in'];
$checkOut=$_POST['check_out'];

if($checkOut<=$checkIn){

$error="Tanggal check out harus setelah check in.";

}else{

$status="Pending";

$stmt=mysqli_prepare(
$conn,
"INSERT INTO bookings
(user_id,room_id,nama,no_hp,check_in,check_out,status)
VALUES(?,?,?,?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt,
"iisssss",
$_SESSION['id'],
$id,
$nama,
$hp,
$checkIn,
$checkOut,
$status
);

if(mysqli_stmt_execute($stmt)){

$success="Reservasi berhasil dikirim. Silakan tunggu konfirmasi dari admin.";

}else{

$error="Reservasi gagal.";

}

mysqli_stmt_close($stmt);

}

}

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/booking.css">

<?php include "includes/header.php"; ?>

<section class="section">

<div class="container">

<div class="booking-wrapper">

<div class="booking-card">

<img
src="uploads/<?= htmlspecialchars($room['foto']) ?>">

<div class="booking-card-body">

<h2>

<?= htmlspecialchars($room['nama']) ?>

</h2>

<div class="booking-price">

Rp <?= number_format($room['harga'],0,",",".") ?>

</div>

<div class="booking-info">

<span>

<i class="fa-solid fa-user-group"></i>

<?= $room['kapasitas'] ?> Orang

</span>

<span>

★★★★★

</span>

</div>

</div>

</div>

<div class="booking-form">

<h1>

Form Reservasi

</h1>

<?php if($success): ?>

<div class="alert-success">

<?= htmlspecialchars($success) ?>

</div>

<?php endif; ?>

<?php if($error): ?>

<div class="alert-error">

<?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>

<form method="POST">

<label>

Nama Lengkap

</label>

<input
type="text"
name="nama"
required>

<label>

Nomor HP

</label>

<input
type="text"
name="no_hp"
required>

<label>

Check In

</label>

<input
type="date"
name="check_in"
required>

<label>

Check Out

</label>

<input
type="date"
name="check_out"
required>

<div class="form-action">

<button
type="submit"
name="booking"
class="btn">

Reservasi

</button>

<a
href="room-detail.php?id=<?= $id ?>"
class="btn btn-danger">

Batal

</a>

</div>

</form>

</div>

</div>

</div>

</section>

<?php include "includes/footer.php"; ?>