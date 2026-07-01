<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";
require_once "../../helpers/upload.php";

$error = "";

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $harga = trim($_POST['harga']);
    $kapasitas = trim($_POST['kapasitas']);
    $deskripsi = trim($_POST['deskripsi']);

    $upload = uploadImage("foto");

    if (!$upload["status"]) {

        $error = $upload["message"];

    } else {

        $foto = $upload["file_name"];

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO rooms
            (nama, harga, kapasitas, foto, deskripsi)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "siiss",
            $nama,
            $harga,
            $kapasitas,
            $foto,
            $deskripsi
        );

        if (mysqli_stmt_execute($stmt)) {

            header("Location: index.php");
            exit;

        } else {

            $error = "Gagal menambahkan kamar.";

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

<title>Tambah Kamar</title>

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

Tambah Kamar

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
required>

<label>

Harga

</label>

<input
type="number"
name="harga"
min="0"
required>

<label>

Kapasitas

</label>

<input
type="number"
name="kapasitas"
min="1"
required>

<label>

Foto

</label>

<input
type="file"
name="foto"
accept=".jpg,.jpeg,.png,.webp"
required>

<label>

Deskripsi

</label>

<textarea
name="deskripsi"
rows="6"
required></textarea>

<button
type="submit"
name="simpan"
class="btn">

Simpan

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