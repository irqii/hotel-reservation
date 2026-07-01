<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| Ambil data kamar
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT foto FROM rooms WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$room = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$room) {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Hapus file foto
|--------------------------------------------------------------------------
*/

if (
    !empty($room['foto']) &&
    file_exists("../../uploads/" . $room['foto'])
) {
    unlink("../../uploads/" . $room['foto']);
}

/*
|--------------------------------------------------------------------------
| Hapus data kamar
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM rooms WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("Location: index.php");
exit;