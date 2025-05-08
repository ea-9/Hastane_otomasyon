<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = (int)$_GET['id'];

// Sekreterin randevuları var mı kontrol et
$sql = "SELECT COUNT(*) as count FROM Randevu WHERE SekreterID = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    header('Location: index.php?error=Bu sekreterin randevuları olduğu için silinemez');
    exit;
}

// Sekreteri sil
$sql = "DELETE FROM Sekreter WHERE SekreterID = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
}
exit; 