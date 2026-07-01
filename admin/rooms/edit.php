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
            SET
                nama = ?,
                harga = ?,
                kapasitas = ?,
                foto = ?,
                deskripsi = ?
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

        if (mysqli_stmt_execute($stmt)) {

            header("Location: index.php");
            exit;

        } else {

            $error = "Gagal memperbarui data.";

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

<title>Edit Kamar</title>

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

<h1 class="page-title">

Edit Kamar

</h1>

<div class="form-card">

<?php if (!empty($error)): ?>

<p style="color:red;margin-bottom:20px;">

<?= htmlspecialchars($error); ?>

</p>

<?php endif; ?>

<form
method="POST"
enctype="multipart/form-data">

<label>

Nama Kamar

</label>

<input
type="text"
name="nama"
value="<?= htmlspecialchars($room['nama']); ?>"
required>

<label>

Harga

</label>

<input
type="number"
name="harga"
value="<?= $room['harga']; ?>"
min="0"
required>

<label>

Kapasitas

</label>

<input
type="number"
name="kapasitas"
value="<?= $room['kapasitas']; ?>"
min="1"
required>

<label>

Foto Saat Ini

</label>

<br><br>

<img
src="../../uploads/<?= htmlspecialchars($room['foto']); ?>"
class="room-image"
alt="<?= htmlspecialchars($room['nama']); ?>">

<br><br>

<label>

Ganti Foto

</label>

<input
type="file"
name="foto"
accept=".jpg,.jpeg,.png,.webp">

<label>

Deskripsi

</label>

<textarea
name="deskripsi"
rows="6"
required><?= htmlspecialchars($room['deskripsi']); ?></textarea>

<button
type="submit"
name="update"
class="btn">

Update

</button>

<a
href="index.php"
class="btn btn-danger">

Batal

</a>

</form>

</div>

</div>

</div>

</body>

</html>