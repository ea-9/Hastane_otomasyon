<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = (int)$_GET['id'];

// Önce bu branşa ait doktor var mı kontrol et
$checkSql = "SELECT COUNT(*) as count FROM Doktor WHERE BransID = $id";
$checkResult = mysqli_query($conn, $checkSql);
$row = mysqli_fetch_assoc($checkResult);

if ($row['count'] > 0) {
    header('Location: index.php?error=Bu branşa ait doktorlar olduğu için silinemez');
    exit;
}

// Branşı sil
$sql = "DELETE FROM Brans WHERE BransID = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
}
exit; 