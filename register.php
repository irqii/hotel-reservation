<?php

include "config/koneksi.php";

$pesan = "";

if (isset($_POST['register'])) {

    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Cek email
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {

        $pesan = "Email sudah digunakan!";

    } else {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_query($conn, "
            INSERT INTO users (nama,email,password)
            VALUES ('$nama','$email','$passwordHash')
        ");

        if ($query) {

            $pesan = "Registrasi berhasil!";

        } else {

            $pesan = "Registrasi gagal!";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Register</title>

</head>

<body>

<h1>Register</h1>

<?php

if ($pesan != "") {

    echo "<p>$pesan</p>";

}

?>

<form method="POST">

    <label>Nama</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">

        Daftar

    </button>

</form>

</body>

</html>
