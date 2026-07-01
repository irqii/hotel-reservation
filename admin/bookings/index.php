<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if (isset($_POST['update_status'])) {

    $bookingId = (int) $_POST['booking_id'];
    $status = $_POST['status'];

    $allowedStatus = ["Pending", "Diterima", "Ditolak"];

    if (in_array($status, $allowedStatus)) {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE bookings
             SET status = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $status,
            $bookingId
        );

        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

    }

    header("Location: index.php");
    exit;

}

$query = "
SELECT
    bookings.*,
    rooms.nama AS room_name
FROM bookings
INNER JOIN rooms
ON bookings.room_id = rooms.id
ORDER BY bookings.id DESC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Reservasi</title>

<link rel="stylesheet" href="../../assets/css/admin.css">

</head>

<body>

<div class="wrapper">

<div class="sidebar">

<h2>Hotel Admin</h2>

<ul>

<li>

<a href="../dashboard.php">

Dashboard

</a>

</li>

<li>

<a href="../rooms/index.php">

Kelola Kamar

</a>

</li>

<li>

<a href="index.php">

Kelola Reservasi

</a>

</li>

<li>

<a href="../../logout.php">

Logout

</a>

</li>

</ul>

</div>

<div class="content">

<div class="header-action">

<h1>Kelola Reservasi</h1>

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>No HP</th>

<th>Kamar</th>

<th>Check In</th>

<th>Check Out</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php if (mysqli_num_rows($result) > 0): ?>

<?php $no = 1; ?>

<?php while ($booking = mysqli_fetch_assoc($result)): ?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<?= htmlspecialchars($booking['nama']); ?>

</td>

<td>

<?= htmlspecialchars($booking['no_hp']); ?>

</td>

<td>

<?= htmlspecialchars($booking['room_name']); ?>

</td>

<td>

<?= htmlspecialchars($booking['check_in']); ?>

</td>

<td>

<?= htmlspecialchars($booking['check_out']); ?>

</td>

<td>

<?php

$class = "";

if ($booking['status'] == "Pending") {

    $class = "pending";

} elseif ($booking['status'] == "Diterima") {

    $class = "accept";

} else {

    $class = "reject";

}

?>

<span class="badge <?= $class; ?>">

<?= htmlspecialchars($booking['status']); ?>

</span>

</td>

<td>

<form method="POST">

<input
type="hidden"
name="booking_id"
value="<?= $booking['id']; ?>">

<select name="status">

<option
value="Pending"
<?= $booking['status'] == "Pending" ? "selected" : ""; ?>>

Pending

</option>

<option
value="Diterima"
<?= $booking['status'] == "Diterima" ? "selected" : ""; ?>>

Diterima

</option>

<option
value="Ditolak"
<?= $booking['status'] == "Ditolak" ? "selected" : ""; ?>>

Ditolak

</option>

</select>

<button
type="submit"
name="update_status"
class="btn">

Update

</button>

</form>

</td>

</tr>

<?php endwhile; ?>

<?php else: ?>

<tr>

<td colspan="8">

Belum ada reservasi.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</body>

</html>