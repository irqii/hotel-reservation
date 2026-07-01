<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Daftar Kamar</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="container">

<h1 style="margin:40px 0;">

Daftar Kamar

</h1>

<p>

Halaman ini akan menampilkan seluruh kamar dari database.

</p>

</div>

</body>

</html>