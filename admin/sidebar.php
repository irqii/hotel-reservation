<?php

$folder = basename(dirname($_SERVER['PHP_SELF']));

if ($folder == "admin") {

    $dashboard = "dashboard.php";
    $rooms = "rooms/index.php";
    $bookings = "bookings/index.php";
    $website = "../index.php";
    $logout = "../logout.php";

} else {

    $dashboard = "../dashboard.php";
    $rooms = "../rooms/index.php";
    $bookings = "../bookings/index.php";
    $website = "../../index.php";
    $logout = "../../logout.php";

}

?>

<div class="sidebar">

    <h2>

        <i class="fa-solid fa-hotel"></i>

         Admin

    </h2>

    <a href="<?= $dashboard ?>">

        <i class="fa-solid fa-gauge-high"></i>

        Dashboard

    </a>

    <a href="<?= $rooms ?>">

        <i class="fa-solid fa-bed"></i>

        Kelola Kamar

    </a>

    <a href="<?= $bookings ?>">

        <i class="fa-solid fa-calendar-check"></i>

        Reservasi

    </a>

    <a href="<?= $website ?>" target="_blank">

        <i class="fa-solid fa-globe"></i>

        Lihat Website

    </a>

    <a href="<?= $logout ?>">

        <i class="fa-solid fa-right-from-bracket"></i>

        Logout

    </a>

</div>