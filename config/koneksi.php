<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "hotel_reservation";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal!");
}