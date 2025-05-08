<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hastane_otomasyon');

// Veritabanına bağlanma
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

// Bağlantıyı kontrol etme
if (!$conn) {
    die("Bağlantı hatası: " . mysqli_connect_error());
}

// Veritabanını oluşturma
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, DB_NAME);
} else {
    die("Veritabanı oluşturma hatası: " . mysqli_error($conn));
}
?> 