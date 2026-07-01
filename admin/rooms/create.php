<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login.php");
    exit;
}

include "../../config/koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kapasitas = $_POST['kapasitas'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn, "
        INSERT INTO rooms(nama,harga,kapasitas,deskripsi)
        VALUES('$nama','$harga','$kapasitas','$deskripsi')
    ");

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Tambah Kamar</title>
</head>
<body>

<h1>Tambah Kamar</h1>

<form method="POST">

Nama<br>
<input type="text" name="nama" required><br><br>

Harga<br>
<input type="number" name="harga" required><br><br>

Kapasitas<br>
<input type="number" name="kapasitas" required><br><br>

Deskripsi<br>
<textarea name="deskripsi"></textarea><br><br>

<button name="simpan">

Simpan

</button>

</form>

</body>
</html>