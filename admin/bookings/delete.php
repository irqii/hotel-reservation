<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

if (
    !isset($_GET['id']) ||
    !is_numeric($_GET['id'])
) {

    header("Location: index.php");
    exit;

}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM bookings WHERE id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: index.php");
exit;