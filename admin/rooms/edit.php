<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";
require_once "../../helpers/upload.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM rooms WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$room = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$room) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['update'])) {

    $nama = trim($_POST['nama']);
    $harga = trim($_POST['harga']);
    $kapasitas = trim($_POST['kapasitas']);
    $deskripsi = trim($_POST['deskripsi']);

    $foto = $room['foto'];

    if (!empty($_FILES['foto']['name'])) {

        $upload = uploadImage("foto");

        if (!$upload["status"]) {

            $error = $upload["message"];

        } else {

            if (
                !empty($room['foto']) &&
                file_exists("../../uploads/" . $room['foto'])
            ) {
                unlink("../../uploads/" . $room['foto']);
            }

            $foto = $upload["file_name"];

        }

    }

    if (empty($error)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE rooms
             SET nama = ?, harga = ?, kapasitas = ?, foto = ?, deskripsi = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "siissi",
            $nama,
            $harga,
            $kapasitas,
            $foto,
            $deskripsi,
            $id
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php");
        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Edit Kamar</title>

</head>

<body>

<h1>Edit Kamar</h1>

<?php if (!empty($error)) : ?>

<p style="color:red;">
    <?= $error; ?>
</p>

<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

<label>Nama Kamar</label>

<br>

<input
type="text"
name="nama"
value="<?= htmlspecialchars($room['nama']); ?>"
required>

<br><br>

<label>Harga</label>

<br>

<input
type="number"
name="harga"
value="<?= $room['harga']; ?>"
required>

<br><br>

<label>Kapasitas</label>

<br>

<input
type="number"
name="kapasitas"
value="<?= $room['kapasitas']; ?>"
required>

<br><br>

<label>Foto Saat Ini</label>

<br><br>

<img
src="../../uploads/<?= $room['foto']; ?>"
width="180">

<br><br>

<label>Ganti Foto</label>

<br>

<input
type="file"
name="foto"
accept=".jpg,.jpeg,.png,.webp">

<br><br>

<label>Deskripsi</label>

<br>

<textarea
name="deskripsi"
rows="6"
cols="60"
required><?= htmlspecialchars($room['deskripsi']); ?></textarea>

<br><br>

<button
type="submit"
name="update">

Update

</button>

<a href="index.php">

Kembali

</a>

</form>

</body>

</html>