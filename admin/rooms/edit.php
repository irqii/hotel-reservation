<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){

    header("Location:index.php");
    exit;

}

$id=(int)$_GET['id'];

$stmt=mysqli_prepare(
    $conn,
    "SELECT * FROM rooms WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$room=mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if(!$room){

    header("Location:index.php");
    exit;

}

if(isset($_POST['submit'])){

    $nama=trim($_POST['nama']);
    $harga=(int)$_POST['harga'];
    $kapasitas=(int)$_POST['kapasitas'];
    $deskripsi=trim($_POST['deskripsi']);

    $foto=$room['foto'];

    if(!empty($_FILES['foto']['name'])){

        if(file_exists("../../uploads/".$foto)){

            unlink("../../uploads/".$foto);

        }

        $foto=time()."-".$_FILES['foto']['name'];

        move_uploaded_file(

            $_FILES['foto']['tmp_name'],

            "../../uploads/".$foto

        );

    }

    $stmt=mysqli_prepare(

        $conn,

        "UPDATE rooms
        SET
        nama=?,
        harga=?,
        kapasitas=?,
        foto=?,
        deskripsi=?
        WHERE id=?"

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

    header("Location:index.php");
    exit;

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Kamar</title>

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

Edit Kamar

</h1>

<p>

Perbarui informasi kamar BlueWave Hotel.

</p>

</div>

</div>

<div class="table-wrapper">

<form
method="POST"
enctype="multipart/form-data">

<label>Nama Kamar</label>

<input
type="text"
name="nama"
value="<?= htmlspecialchars($room['nama']) ?>"
required>

<label>Harga per Malam</label>

<input
type="number"
name="harga"
value="<?= $room['harga'] ?>"
required>

<label>Kapasitas</label>

<input
type="number"
name="kapasitas"
value="<?= $room['kapasitas'] ?>"
required>

<label>Foto Saat Ini</label>

<p style="margin-bottom:20px;">

<img
src="../../uploads/<?= htmlspecialchars($room['foto']) ?>"
alt="<?= htmlspecialchars($room['nama']) ?>"
style="width:220px;border-radius:12px;">

</p>

<label>Ganti Foto (Opsional)</label>

<input
type="file"
name="foto"
accept="image/*">

<label>Deskripsi</label>

<textarea
name="deskripsi"
required><?= htmlspecialchars($room['deskripsi']) ?></textarea>

<button
type="submit"
name="submit"
class="btn">

<i class="fa-solid fa-floppy-disk"></i>

Update

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