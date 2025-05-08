<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Randevuyu sil
$sql = "DELETE FROM Randevu WHERE RandevuID = $id";

if (mysqli_query($conn, $sql)) {
    header('Location: index.php?success=1');
} else {
    header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
}
exit; 