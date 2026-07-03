<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != "admin") {

    header("Location: ../../login.php");
    exit;

}

require_once "../../config/koneksi.php";

if(
    !isset($_GET['id']) ||
    !is_numeric($_GET['id']) ||
    !isset($_GET['status'])
){

    header("Location:index.php");
    exit;

}

$id=(int)$_GET['id'];

$status=$_GET['status'];

$statusValid=[

    "Pending",
    "Diterima",
    "Ditolak"

];

if(!in_array($status,$statusValid)){

    header("Location:index.php");
    exit;

}

$stmt=mysqli_prepare(

    $conn,

    "UPDATE bookings
    SET status=?
    WHERE id=?"

);

mysqli_stmt_bind_param(

    $stmt,

    "si",

    $status,

    $id

);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header("Location:index.php");
exit;