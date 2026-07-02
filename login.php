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

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE email = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == "admin") {

                header("Location: admin/dashboard.php");

            } else {

                header("Location: index.php");

            }

            exit;

        }

    }

    $error = "Email atau password salah.";

    mysqli_stmt_close($stmt);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

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

<a href="register.php">

Register

</a>

</div>

</div>

</nav>

<section class="section">

<div class="container">

<div class="form-box">

<h2 style="text-align:center;margin-bottom:30px;">

Login

</h2>

<?php if(!empty($error)): ?>

<p style="color:red;margin-bottom:20px;">

<?= htmlspecialchars($error); ?>

</p>

<?php endif; ?>

<form method="POST">

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
name="login"
class="btn">

Login

</button>

</form>

<br>

<p style="text-align:center;">

Belum punya akun?

<a href="register.php">

Daftar

</a>

</p>

</div>

</div>

</section>

<footer class="footer">

<div class="container">

&copy; <?= date("Y"); ?> Hotel Reservation

</div>

</footer>

</body>

</html>