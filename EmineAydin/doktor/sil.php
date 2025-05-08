<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Önce doktorun randevularını kontrol et
$check_sql = "SELECT COUNT(*) as count FROM Randevu WHERE DoktorID = $id";
$result = mysqli_query($conn, $check_sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    header('Location: index.php?error=Bu doktorun randevuları bulunduğu için silinemez');
    exit;
}

// Doktoru sil
$sql = "DELETE FROM Doktor WHERE DoktorID = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
}
exit; 