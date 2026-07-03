<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

if(isset($_POST['submit'])){

    $nama=trim($_POST['nama']);
    $harga=(int)$_POST['harga'];
    $kapasitas=(int)$_POST['kapasitas'];
    $deskripsi=trim($_POST['deskripsi']);

    $foto=$_FILES['foto']['name'];
    $tmp=$_FILES['foto']['tmp_name'];

    $namaFoto=time()."-".$foto;

    move_uploaded_file(
        $tmp,
        "../../uploads/".$namaFoto
    );

    $stmt=mysqli_prepare(
        $conn,
        "INSERT INTO rooms
        (nama,harga,kapasitas,foto,deskripsi)
        VALUES(?,?,?,?,?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "siiss",
        $nama,
        $harga,
        $kapasitas,
        $namaFoto,
        $deskripsi
    );

    mysqli_stmt_execute($stmt);

    header("Location:index.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Kamar</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>

<body>

<?php include "../sidebar.php"; ?>

<div class="main">

<div class="topbar">

<div>

<h1 class="page-title">

Tambah Kamar

</h1>

<p>

Tambahkan data kamar baru ke BlueWave Hotel.

</p>

</div>

</div>

<div class="table-wrapper">

<form method="POST" enctype="multipart/form-data">

<label>Nama Kamar</label>

<input
type="text"
name="nama"
required>

<label>Harga per Malam</label>

<input
type="number"
name="harga"
required>

<label>Kapasitas</label>

<input
type="number"
name="kapasitas"
required>

<label>Foto Kamar</label>

<input
type="file"
name="foto"
accept="image/*"
required>

<label>Deskripsi</label>

<textarea
name="deskripsi"
required></textarea>

<button
type="submit"
name="submit"
class="btn">

<i class="fa-solid fa-floppy-disk"></i>

Simpan

</button>

<a
href="index.php"
class="btn btn-danger">

<i class="fa-solid fa-arrow-left"></i>

Kembali

</a>

</form>

</div>

</div>

</body>

</html>