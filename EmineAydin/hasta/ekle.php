<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = mysqli_real_escape_string($conn, $_POST['ad']);
    $soyad = mysqli_real_escape_string($conn, $_POST['soyad']);
    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);
    $eposta = mysqli_real_escape_string($conn, $_POST['eposta']);
    $dogumTarihi = mysqli_real_escape_string($conn, $_POST['dogumTarihi']);
    $cinsiyet = mysqli_real_escape_string($conn, $_POST['cinsiyet']);

    $sql = "INSERT INTO Hasta (Ad, Soyad, TelefonNumarasi, EPosta, DogumTarihi, Cinsiyet) 
            VALUES ('$ad', '$soyad', '$telefon', '$eposta', '$dogumTarihi', '$cinsiyet')";

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
    <title>Yeni Hasta Ekle - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Ana Sayfa</a></li>
                <li><a href="index.php">Hasta İşlemleri</a></li>
                <li><a href="../doktor/index.php">Doktor İşlemleri</a></li>
                <li><a href="../randevu/index.php">Randevu İşlemleri</a></li>
                <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Yeni Hasta Ekle</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="ad">Ad:</label>
                <input type="text" id="ad" name="ad" required>
            </div>

            <div class="form-group">
                <label for="soyad">Soyad:</label>
                <input type="text" id="soyad" name="soyad" required>
            </div>

            <div class="form-group">
                <label for="telefon">Telefon Numarası:</label>
                <input type="tel" id="telefon" name="telefon" required>
            </div>

            <div class="form-group">
                <label for="eposta">E-posta:</label>
                <input type="email" id="eposta" name="eposta">
            </div>

            <div class="form-group">
                <label for="dogumTarihi">Doğum Tarihi:</label>
                <input type="date" id="dogumTarihi" name="dogumTarihi">
            </div>

            <div class="form-group">
                <label for="cinsiyet">Cinsiyet:</label>
                <select id="cinsiyet" name="cinsiyet" required>
                    <option value="">Seçiniz</option>
                    <option value="Erkek">Erkek</option>
                    <option value="Kadın">Kadın</option>
                    <option value="Diğer">Diğer</option>
                </select>
            </div>

            <div class="form-group">
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