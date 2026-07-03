<?php

session_start();

require_once "config/koneksi.php";

if(isset($_SESSION['id'])){

    if($_SESSION['role']=="admin"){

        header("Location: admin/dashboard.php");

    }else{

        header("Location: index.php");

    }

    exit;

}

$error="";

if(isset($_POST['login'])){

$email=trim($_POST['email']);
$password=$_POST['password'];

$stmt=mysqli_prepare(
$conn,
"SELECT * FROM users WHERE email=?"
);

mysqli_stmt_bind_param(
$stmt,
"s",
$email
);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==1){

$user=mysqli_fetch_assoc($result);

if(password_verify($password,$user['password'])){

$_SESSION['id']=$user['id'];
$_SESSION['nama']=$user['nama'];
$_SESSION['role']=$user['role'];

if($user['role']=="admin"){

header("Location: admin/dashboard.php");

}else{

header("Location: index.php");

}

exit;

}

}

$error="Email atau password salah.";

}

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/auth.css">

<section class="auth-section">

<div class="auth-container">

<div class="auth-banner">

<div class="brand">

<img
src="assets/images/logo.png"
alt="BlueWave Hotel">

<h1>

BlueWave Hotel

</h1>

</div>

<p>

Nikmati pengalaman menginap yang nyaman dengan proses reservasi online yang cepat, mudah, dan aman.

</p>

</div>

<div class="auth-form">

<h2>

Login

</h2>

<?php if($error): ?>

<div class="error-box">

<?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>

<form method="POST">

<label>Email</label>

<input
type="email"
name="email"
placeholder="Masukkan email"
required>

<label>Password</label>

<input
type="password"
name="password"
placeholder="Masukkan password"
required>

<button
type="submit"
name="login"
class="btn">

Login

</button>

</form>

<div class="auth-footer">

Belum punya akun?

<a href="register.php">

Daftar

</a>

</div>

</div>

</div>

</section>

</body>

</html>