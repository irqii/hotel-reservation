<?php

session_start();
include "config/koneksi.php";

$pesan = "";

if (isset($_POST['login'])) {

    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit;

        } else {

            $pesan = "Password salah!";

        }

    } else {

        $pesan = "Email tidak ditemukan!";

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Login</title>

</head>

<body>

<h1>Login</h1>

<?php

if($pesan != ""){
    echo "<p>$pesan</p>";
}

?>

<form method="POST">

<label>Email</label><br>
<input type="email" name="email" required><br><br>

<label>Password</label><br>
<input type="password" name="password" required><br><br>

<button type="submit" name="login">
Masuk
</button>

</form>

<p>Belum punya akun?</p>

<a href="register.php">Daftar</a>

</body>

</html>