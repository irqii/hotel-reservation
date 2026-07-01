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

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM rooms WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

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

            <a href="index.php">Home</a>

            <a href="rooms.php">Kamar</a>

            <a href="logout.php">Logout</a>

        </div>

    </div>

</nav>

<section class="section">

    <div class="container">

        <img
            src="uploads/<?= htmlspecialchars($room['foto']); ?>"
            alt="<?= htmlspecialchars($room['nama']); ?>"
            style="width:100%;max-width:700px;border-radius:10px;">

        <br><br>

        <h2>

            <?= htmlspecialchars($room['nama']); ?>

        </h2>

        <br>

        <p>

            <strong>Harga :</strong>

            Rp <?= number_format($room['harga'], 0, ',', '.'); ?>

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

            <?= nl2br(htmlspecialchars($room['deskripsi'])); ?>

        </p>

        <br><br>

        <a
            href="booking.php?room_id=<?= $room['id']; ?>"
            class="btn">

            Reservasi Sekarang

        </a>

    </div>

</section>

</body>

</html>