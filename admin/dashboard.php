<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once "../config/koneksi.php";

$totalRooms = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM rooms")
);

$totalBookings = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM bookings")
);

$totalPending = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM bookings WHERE status='Pending'")
);

$totalAccepted = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM bookings WHERE status='Diterima'")
);

$totalRejected = mysqli_num_rows(
    mysqli_query($conn, "SELECT id FROM bookings WHERE status='Ditolak'")
);

$latestBookings = mysqli_query(
    $conn,
    "SELECT
        bookings.*,
        rooms.nama AS room_name
    FROM bookings
    INNER JOIN rooms
        ON bookings.room_id = rooms.id
    ORDER BY bookings.id DESC
    LIMIT 5"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../assets/css/admin.css">

</head>

<body>

<div class="wrapper">

    <div class="sidebar">

        <h2>Hotel Admin</h2>

        <ul>

            <li>

                <a href="dashboard.php">

                    Dashboard

                </a>

            </li>

            <li>

                <a href="rooms/index.php">

                    Kelola Kamar

                </a>

            </li>

            <li>

                <a href="bookings/index.php">

                    Kelola Reservasi

                </a>

            </li>

            <li>

                <a href="../logout.php">

                    Logout

                </a>

            </li>

        </ul>

    </div>

    <div class="content">

        <h1 class="page-title">

            Dashboard

        </h1>

        <div class="stats">

            <div class="card">

                <h4>Total Kamar</h4>

                <h2><?= $totalRooms; ?></h2>

            </div>

            <div class="card">

                <h4>Total Reservasi</h4>

                <h2><?= $totalBookings; ?></h2>

            </div>

            <div class="card">

                <h4>Pending</h4>

                <h2><?= $totalPending; ?></h2>

            </div>

            <div class="card">

                <h4>Diterima</h4>

                <h2><?= $totalAccepted; ?></h2>

            </div>

            <div class="card">

                <h4>Ditolak</h4>

                <h2><?= $totalRejected; ?></h2>

            </div>

        </div>

        <div class="card">

            <div class="header-action">

                <h3>Reservasi Terbaru</h3>

                <a
                    href="bookings/index.php"
                    class="btn">

                    Lihat Semua

                </a>

            </div>

            <table>

                <tr>

                    <th>Nama</th>

                    <th>Kamar</th>

                    <th>Check In</th>

                    <th>Check Out</th>

                    <th>Status</th>

                </tr>

                <?php if (mysqli_num_rows($latestBookings) > 0): ?>

                    <?php while ($booking = mysqli_fetch_assoc($latestBookings)): ?>

                        <tr>

                            <td>

                                <?= htmlspecialchars($booking['nama']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($booking['room_name']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($booking['check_in']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($booking['check_out']); ?>

                            </td>

                            <td>

                                <?php

                                $class = "";

                                if ($booking['status'] == "Pending") {
                                    $class = "pending";
                                } elseif ($booking['status'] == "Diterima") {
                                    $class = "accept";
                                } else {
                                    $class = "reject";
                                }

                                ?>

                                <span class="badge <?= $class; ?>">

                                    <?= htmlspecialchars($booking['status']); ?>

                                </span>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5">

                            Belum ada reservasi.

                        </td>

                    </tr>

                <?php endif; ?>

            </table>

        </div>

    </div>

</div>

</body>

</html>