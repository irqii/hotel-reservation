<?php

session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/koneksi.php";

if (isset($_POST['update_status'])) {

    $id = (int) $_POST['booking_id'];
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
            $id
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

<title>Kelola Reservasi</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,Helvetica,sans-serif;
}

body{
    background:#f5f5f5;
    padding:40px;
}

.container{
    max-width:1300px;
    margin:auto;
}

h1{
    margin-bottom:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
}

th,
td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

th{
    background:#2563eb;
    color:white;
}

select{
    padding:6px;
}

button{
    padding:6px 14px;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

<h1>Kelola Reservasi</h1>

<table>

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

<?php if(mysqli_num_rows($result) > 0): ?>

<?php $no = 1; ?>

<?php while($booking = mysqli_fetch_assoc($result)): ?>

<tr>

<td><?= $no++; ?></td>

<td><?= htmlspecialchars($booking['nama']); ?></td>

<td><?= htmlspecialchars($booking['no_hp']); ?></td>

<td><?= htmlspecialchars($booking['room_name']); ?></td>

<td><?= $booking['check_in']; ?></td>

<td><?= $booking['check_out']; ?></td>

<td><?= $booking['status']; ?></td>

<td>

<form method="POST">

<input
type="hidden"
name="booking_id"
value="<?= $booking['id']; ?>">

<select name="status">

<option
value="Pending"
<?= $booking['status']=="Pending" ? "selected" : ""; ?>>

Pending

</option>

<option
value="Diterima"
<?= $booking['status']=="Diterima" ? "selected" : ""; ?>>

Diterima

</option>

<option
value="Ditolak"
<?= $booking['status']=="Ditolak" ? "selected" : ""; ?>>

Ditolak

</option>

</select>

<button
type="submit"
name="update_status">

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

</table>

</div>

</body>

</html>