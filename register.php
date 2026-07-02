<?php

session_start();

require_once "config/koneksi.php";

if (isset($_SESSION['id'])) {

    if ($_SESSION['role'] == "admin") {

        header("Location: admin/dashboard.php");

    } else {

        header("Location: index.php");

    }

    exit;

}

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $cek = mysqli_prepare(
        $conn,
        "SELECT id FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $cek,
        "s",
        $email
    );

    mysqli_stmt_execute($cek);

    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {

        $error = "Email sudah digunakan.";

    } else {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO users
            (nama, email, password, role)
            VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $nama,
            $email,
            $passwordHash,
            $role
        );

        if (mysqli_stmt_execute($stmt)) {

            header("Location: login.php");
            exit;

        } else {

            $error = "Registrasi gagal.";

        }

        mysqli_stmt_close($stmt);

    }

    mysqli_stmt_close($cek);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<nav>

<div class="container">

<div class="logo">

Hotel Reservation

</div>

<div class="menu">

<a href="index.php">

Home

</a>

<a href="rooms.php">

Kamar

</a>

<a href="login.php">

Login

</a>

</div>

</div>

</nav>

<section class="section">

<div class="container">

<div class="form-box">

<h2
style="text-align:center;margin-bottom:30px;">

Register

</h2>

<?php if (!empty($error)): ?>

<p
style="color:red;margin-bottom:20px;">

<?= htmlspecialchars($error); ?>

</p>

<?php endif; ?>

<form method="POST">

<label>

Nama

</label>

<input
type="text"
name="nama"
required>

<label>

Email

</label>

<input
type="email"
name="email"
required>

<label>

Password

</label>

<input
type="password"
name="password"
required>

<button
type="submit"
name="register"
class="btn">

Daftar

</button>

</form>

<br>

<p style="text-align:center;">

Sudah punya akun?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</section>

<footer class="footer">

<div class="container">

&copy; <?= date("Y"); ?>

Hotel Reservation

</div>

</footer>

</body>

</html>