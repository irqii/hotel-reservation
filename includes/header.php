<header>

<nav class="navbar">

<div class="container">

<a href="index.php" class="logo">

<img src="assets/images/logo.png" alt="BlueWave Hotel">

<span>

BlueWave Hotel

</span>

</a>

<div class="menu">

<a href="index.php">

Beranda

</a>

<a href="rooms.php">

Kamar

</a>

<a href="index.php#about">

Tentang

</a>

<?php if(isset($_SESSION['id'])): ?>

<a href="logout.php">

Logout

</a>

<?php else: ?>

<a href="login.php">

Login

</a>

<a href="register.php">

Register

</a>

<?php endif; ?>

</div>

</div>

</nav>

</header>