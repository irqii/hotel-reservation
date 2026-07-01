<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reservasi Berhasil</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<section class="section">

<div class="container" style="text-align:center;">

<h2>

Reservasi Berhasil

</h2>

<br>

<p>

Reservasi berhasil dikirim.

</p>

<p>

Silakan tunggu konfirmasi dari admin.

</p>

<br>

<a
href="rooms.php"
class="btn">

Kembali ke Daftar Kamar

</a>

</div>

</section>

</body>

</html>