<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once "config/koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: rooms.php");
    exit;
}

$roomId = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM rooms WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $roomId
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$room = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$room) {
    header("Location: rooms.php");
    exit;
}

$success = "";
$error = "";

if (isset($_POST['booking'])) {

    $nama = trim($_POST['nama']);
    $noHp = trim($_POST['no_hp']);
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];

    if ($checkOut <= $checkIn) {

        $error = "Tanggal check out harus setelah check in.";

    } else {

        $status = "Pending";

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO bookings
            (
                user_id,
                room_id,
                nama,
                no_hp,
                check_in,
                check_out,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iisssss",
            $_SESSION['id'],
            $roomId,
            $nama,
            $noHp,
            $checkIn,
            $checkOut,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {

            $success = "Reservasi berhasil dikirim. Silakan tunggu konfirmasi dari admin.";

        } else {

            $error = "Reservasi gagal dikirim.";

        }

        mysqli_stmt_close($stmt);

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reservasi</title>

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

<a href="logout.php">

Logout

</a>

</div>

</div>

</nav>

<section class="section">

<div class="container">

<div class="form-box">

<h2
style="text-align:center;margin-bottom:30px;">

Reservasi Kamar

</h2>

<p
style="margin-bottom:25px;">

<strong>Kamar :</strong>

<?= htmlspecialchars($room['nama']); ?>

</p>

<?php if(!empty($success)): ?>

<p
style="color:green;margin-bottom:20px;">

<?= htmlspecialchars($success); ?>

</p>

<?php endif; ?>

<?php if(!empty($error)): ?>

<p
style="color:red;margin-bottom:20px;">

<?= htmlspecialchars($error); ?>

</p>

<?php endif; ?>

<form method="POST">

<label>

Nama

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

<button
type="submit"
name="booking"
class="btn">

Reservasi Sekarang

</button>

<a
href="room-detail.php?id=<?= $roomId; ?>"
class="btn btn-danger">

Kembali

</a>

</form>

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