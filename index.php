<?php

session_start();

require_once "config/koneksi.php";

$query = mysqli_query(
    $conn,
    "SELECT * FROM rooms ORDER BY id DESC LIMIT 3"
);

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/home.css">

<?php
include "includes/header.php";
?>

<section class="hero">

    <div class="container">

        <div class="hero-content">

            <p class="hero-subtitle">

                WELCOME TO BLUEWAVE HOTEL

            </p>

            <h1>

                Rasakan Pengalaman Menginap yang Berbeda

            </h1>

            <p>

                Nikmati kamar modern, pelayanan terbaik, dan proses reservasi online
                yang cepat serta mudah untuk menemani setiap perjalanan Anda.

            </p>

            <div class="hero-buttons">

                <a href="rooms.php" class="btn">

                    Lihat Kamar

                </a>

                <a href="#about" class="btn-outline">

                    Tentang Kami

                </a>

            </div>

        </div>

    </div>

</section>

<section class="section featured">

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

                        <div class="room-price">

                            Rp <?= number_format($room['harga'],0,",","."); ?>

                            <span style="font-size:15px;color:#64748b;">

                                / malam

                            </span>

                        </div>

                        <div class="room-info">

                            <span>

                                <i class="fa-solid fa-user-group"></i>

                                <?= $room['kapasitas']; ?> Orang

                            </span>

                            <span>

                                ★★★★★

                            </span>

                        </div>

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

<section
class="section"
id="about">

    <div class="container">

        <div class="about">

            <div>

                <img
                    src="assets/images/hotel.png"
                    alt="BlueWave Hotel">

            </div>

            <div>

                <h2>

                    Tentang BlueWave Hotel

                </h2>

                <p>

                    BlueWave Hotel menghadirkan pengalaman menginap yang nyaman dengan
                    desain modern, fasilitas lengkap, dan pelayanan profesional untuk
                    setiap tamu.

                </p>

                <p>

                    Mulai dari perjalanan bisnis hingga liburan bersama keluarga,
                    kami menyediakan berbagai pilihan kamar yang siap memenuhi
                    kebutuhan Anda.

                </p>

                <a
                    href="rooms.php"
                    class="btn">

                    Lihat Semua Kamar

                </a>

            </div>

        </div>

    </div>

</section>

<section class="section">

    <div class="container">

        <div class="cta">

            <h2>

                Siap Menginap Bersama Kami?

            </h2>

            <p>

                Temukan kamar favorit Anda sekarang dan lakukan reservasi hanya
                dalam beberapa langkah.

            </p>

            <a
                href="rooms.php"
                class="btn">

                Reservasi Sekarang

            </a>

        </div>

    </div>

</section>

<?php
include "includes/footer.php";
?>