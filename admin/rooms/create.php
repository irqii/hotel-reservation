<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";
require_once "../../helpers/upload.php";

$error = "";
$success = "";

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
            "INSERT INTO rooms (nama, harga, kapasitas, foto, deskripsi)
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

    <title>Tambah Kamar</title>

</head>

<body>

<h1>Tambah Kamar</h1>

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
        required
    >

    <br><br>

    <label>Harga</label>

    <br>

    <input
        type="number"
        name="harga"
        min="0"
        required
    >

    <br><br>

    <label>Kapasitas</label>

    <br>

    <input
        type="number"
        name="kapasitas"
        min="1"
        required
    >

    <br><br>

    <label>Foto</label>

    <br>

    <input
        type="file"
        name="foto"
        accept=".jpg,.jpeg,.png,.webp"
        required
    >

    <br><br>

    <label>Deskripsi</label>

    <br>

    <textarea
        name="deskripsi"
        rows="6"
        cols="60"
        required
    ></textarea>

    <br><br>

    <button type="submit" name="simpan">

        Simpan

    </button>

    <a href="index.php">

        Kembali

    </a>

</form>

</body>

</html>