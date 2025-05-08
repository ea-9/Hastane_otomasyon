<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sekreterAdi = mysqli_real_escape_string($conn, $_POST['sekreterAdi']);
    $sekreterSoyadi = mysqli_real_escape_string($conn, $_POST['sekreterSoyadi']);

    $sql = "INSERT INTO Sekreter (SekreterAdi, SekreterSoyadi) VALUES ('$sekreterAdi', '$sekreterSoyadi')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php?success=1');
        exit;
    } else {
        header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Sekreter Ekle - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Ana Sayfa</a></li>
                <li><a href="../hasta/index.php">Hasta İşlemleri</a></li>
                <li><a href="../doktor/index.php">Doktor İşlemleri</a></li>
                <li><a href="../randevu/index.php">Randevu İşlemleri</a></li>
                <li><a href="index.php">Sekreter İşlemleri</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Yeni Sekreter Ekle</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="sekreterAdi">Ad:</label>
                <input type="text" id="sekreterAdi" name="sekreterAdi" required>
            </div>

            <div class="form-group">
                <label for="sekreterSoyadi">Soyad:</label>
                <input type="text" id="sekreterSoyadi" name="sekreterSoyadi" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="button">Kaydet</button>
                <a href="index.php" class="button">İptal</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Hastane Otomasyon Sistemi</p>
    </footer>
</body>
</html> 