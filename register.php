<?php

session_start();

require_once "config/koneksi.php";

if(isset($_SESSION['id'])){

header("Location: index.php");
exit;

}

$error="";

if(isset($_POST['register'])){

$nama=trim($_POST['nama']);
$email=trim($_POST['email']);
$password=password_hash($_POST['password'],PASSWORD_DEFAULT);

$cek=mysqli_prepare(
$conn,
"SELECT id FROM users WHERE email=?"
);

mysqli_stmt_bind_param(
$cek,
"s",
$email
);

mysqli_stmt_execute($cek);

mysqli_stmt_store_result($cek);

if(mysqli_stmt_num_rows($cek)>0){

$error="Email sudah digunakan.";

}else{

$role="user";

$stmt=mysqli_prepare(
$conn,
"INSERT INTO users(nama,email,password,role)
VALUES(?,?,?,?)"
);

mysqli_stmt_bind_param(
$stmt,
"ssss",
$nama,
$email,
$password,
$role
);

mysqli_stmt_execute($stmt);

header("Location: login.php");

exit;

}

}

include "includes/head.php";
?>

<link rel="stylesheet" href="assets/css/auth.css">

<section class="auth-section">

<div class="auth-container">

<div class="auth-banner">

<h1>

BlueWave Hotel

</h1>

<p>

Bergabunglah sekarang dan nikmati kemudahan reservasi kamar secara online.

</p>

</div>

<div class="auth-form">

<h2>

Register

</h2>

<?php if($error): ?>

<div class="error-box">

<?= htmlspecialchars($error) ?>

</div>

<?php endif; ?>

<form method="POST">

<label>Nama</label>

<input
type="text"
name="nama"
required>

<label>Email</label>

<input
type="email"
name="email"
required>

<label>Password</label>

<input
type="password"
name="password"
required>

<button
type="submit"
name="register"
class="btn">

Register

</button>

</form>

<div class="auth-footer">

Sudah punya akun?

<a href="login.php">

Login

</a>

</div>

</div>

</div>

</section>

</body>

</html>