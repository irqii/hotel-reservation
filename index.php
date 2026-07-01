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

<title>Hotel Reservation</title>

</head>

<body>

<h1>Selamat Datang</h1>

<p>

Halo,

<b><?= $_SESSION['nama']; ?></b>

</p>

<p>Role : <?= $_SESSION['role']; ?></p>

<a href="logout.php">

Logout

</a>

</body>

</html>