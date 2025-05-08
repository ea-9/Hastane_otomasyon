<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Önce hastanın randevularını kontrol et
$check_sql = "SELECT COUNT(*) as count FROM Randevu WHERE HastaID = $id";
$result = mysqli_query($conn, $check_sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    header('Location: index.php?error=Bu hastanın randevuları bulunduğu için silinemez');
    exit;
}

// Hastayı sil
$sql = "DELETE FROM Hasta WHERE HastaID = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
}
exit; 