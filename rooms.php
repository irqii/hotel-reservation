<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

require_once "config/koneksi.php";

$query = "SELECT * FROM rooms ORDER BY id DESC";
$result = mysqli_query($conn, $query);

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

            <a href="index.php">Home</a>

            <a href="rooms.php">Kamar</a>

            <a href="logout.php">Logout</a>

        </div>

    </div>

</nav>

<section class="section">

    <div class="container">

        <h2>Daftar Kamar</h2>

        <div class="room-grid">

            <?php if (mysqli_num_rows($result) > 0) : ?>

                <?php while ($room = mysqli_fetch_assoc($result)) : ?>

                    <div class="card">

                        <?php if (!empty($room['foto'])) : ?>

                            <img
                                src="uploads/<?= htmlspecialchars($room['foto']); ?>"
                                alt="<?= htmlspecialchars($room['nama']); ?>">

                        <?php else : ?>

                            <img
                                src="assets/images/no-image.png"
                                alt="No Image">

                        <?php endif; ?>

                        <div class="card-body">

                            <h3>

                                <?= htmlspecialchars($room['nama']); ?>

                            </h3>

                            <p>

                                Rp <?= number_format($room['harga'], 0, ',', '.'); ?> / malam

                            </p>

                            <p>

                                Kapasitas :
                                <?= $room['kapasitas']; ?> Orang

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

            <?php else : ?>

                <p>

                    Belum ada kamar tersedia.

                </p>

            <?php endif; ?>

        </div>

    </div>

</section>

</body>

</html>