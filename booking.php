<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once "config/koneksi.php";

if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
    header("Location: rooms.php");
    exit;
}

$roomId = (int) $_GET['room_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM rooms WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $roomId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$room = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$room) {
    header("Location: rooms.php");
    exit;
}

$error = "";

if (isset($_POST['booking'])) {

    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];

    if ($checkIn >= $checkOut) {

        $error = "Tanggal check-out harus setelah check-in.";

    } else {

        $status = "Pending";

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO bookings (user_id, room_id, check_in, check_out, status)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iisss",
            $_SESSION['id'],
            $roomId,
            $checkIn,
            $checkOut,
            $status
        );

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        header("Location: booking-success.php");
        exit;

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

<a href="index.php">Home</a>

<a href="rooms.php">Kamar</a>

<a href="logout.php">Logout</a>

</div>

</div>

</nav>

<section class="section">

<div class="container">

<h2>Reservasi Kamar</h2>

<br>

<h3><?= htmlspecialchars($room['nama']); ?></h3>

<p>

Rp <?= number_format($room['harga'],0,",","."); ?> / malam

</p>

<br>

<?php if(!empty($error)): ?>

<p style="color:red;">

<?= $error; ?>

</p>

<br>

<?php endif; ?>

<form method="POST">

<label>Check In</label>

<br>

<input
type="date"
name="check_in"
required>

<br><br>

<label>Check Out</label>

<br>

<input
type="date"
name="check_out"
required>

<br><br>

<button
type="submit"
name="booking"
class="btn">

Reservasi Sekarang

</button>

</form>

</div>

</section>

</body>

</html>