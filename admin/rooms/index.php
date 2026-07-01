<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

$query = "SELECT * FROM rooms ORDER BY id DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Kamar</title>

    <link rel="stylesheet" href="../../assets/css/admin.css">

</head>

<body>

<div class="wrapper">

    <div class="sidebar">

        <h2>Hotel Admin</h2>

        <ul>

            <li>

                <a href="../dashboard.php">

                    Dashboard

                </a>

            </li>

            <li>

                <a href="index.php">

                    Kelola Kamar

                </a>

            </li>

            <li>

                <a href="../bookings/index.php">

                    Kelola Reservasi

                </a>

            </li>

            <li>

                <a href="../../logout.php">

                    Logout

                </a>

            </li>

        </ul>

    </div>

    <div class="content">

        <div class="header-action">

            <h1>Kelola Kamar</h1>

            <a
                href="create.php"
                class="btn">

                + Tambah Kamar

            </a>

        </div>

        <table>

            <thead>

                <tr>

                    <th>No</th>

                    <th>Foto</th>

                    <th>Nama</th>

                    <th>Harga</th>

                    <th>Kapasitas</th>

                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php $no = 1; ?>

                    <?php while ($room = mysqli_fetch_assoc($result)): ?>

                        <tr>

                            <td>

                                <?= $no++; ?>

                            </td>

                            <td>

                                <?php if (!empty($room['foto'])): ?>

                                    <img
                                        src="../../uploads/<?= htmlspecialchars($room['foto']); ?>"
                                        alt="<?= htmlspecialchars($room['nama']); ?>"
                                        class="room-image">

                                <?php else: ?>

                                    -

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($room['nama']); ?>

                            </td>

                            <td>

                                Rp <?= number_format($room['harga'], 0, ",", "."); ?>

                            </td>

                            <td>

                                <?= $room['kapasitas']; ?> Orang

                            </td>

                            <td>

                                <a
                                    href="edit.php?id=<?= $room['id']; ?>"
                                    class="btn">

                                    Edit

                                </a>

                                <a
                                    href="delete.php?id=<?= $room['id']; ?>"
                                    class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus kamar ini?')">

                                    Hapus

                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6">

                            Belum ada data kamar.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>