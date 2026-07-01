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

    <title>Kelola Kamar</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f5f5f5;
            padding:40px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        h1{
            margin-bottom:25px;
        }

        .btn{
            display:inline-block;
            text-decoration:none;
            padding:10px 18px;
            background:#2563eb;
            color:white;
            border-radius:6px;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
        }

        th,
        td{
            border:1px solid #ddd;
            padding:12px;
            text-align:center;
        }

        th{
            background:#2563eb;
            color:white;
        }

        img{
            width:120px;
            height:80px;
            object-fit:cover;
            border-radius:6px;
        }

        .edit{
            color:#2563eb;
            text-decoration:none;
            font-weight:bold;
        }

        .delete{
            color:red;
            text-decoration:none;
            font-weight:bold;
        }

        .empty{
            text-align:center;
            padding:30px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Kelola Kamar</h1>

    <a
        href="create.php"
        class="btn">

        + Tambah Kamar

    </a>

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

        <?php if(mysqli_num_rows($result) > 0): ?>

            <?php $no = 1; ?>

            <?php while($room = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td><?= $no++; ?></td>

                    <td>

                        <?php if(!empty($room['foto'])): ?>

                            <img
                                src="../../uploads/<?= htmlspecialchars($room['foto']); ?>"
                                alt="<?= htmlspecialchars($room['nama']); ?>">

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($room['nama']); ?>

                    </td>

                    <td>

                        Rp <?= number_format($room['harga'],0,',','.'); ?>

                    </td>

                    <td>

                        <?= $room['kapasitas']; ?> Orang

                    </td>

                    <td>

                        <a
                            href="edit.php?id=<?= $room['id']; ?>"
                            class="edit">

                            Edit

                        </a>

                        |

                        <a
                            href="delete.php?id=<?= $room['id']; ?>"
                            class="delete"
                            onclick="return confirm('Yakin ingin menghapus kamar ini?')">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>

                <td
                    colspan="6"
                    class="empty">

                    Belum ada data kamar.

                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>