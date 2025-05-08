<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sekreterAdi = mysqli_real_escape_string($conn, $_POST['sekreterAdi']);
    $sekreterSoyadi = mysqli_real_escape_string($conn, $_POST['sekreterSoyadi']);

    $sql = "UPDATE Sekreter SET SekreterAdi = '$sekreterAdi', SekreterSoyadi = '$sekreterSoyadi' WHERE SekreterID = $id";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php?success=1');
        exit;
    } else {
        header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}

// Sekreter bilgilerini çekme
$sql = "SELECT * FROM Sekreter WHERE SekreterID = $id";
$result = mysqli_query($conn, $sql);
$sekreter = mysqli_fetch_assoc($result);

if (!$sekreter) {
    header('Location: index.php?error=Sekreter bulunamadı');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekreter Düzenle - Hastane Otomasyon Sistemi</title>
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
        <h1>Sekreter Düzenle</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="sekreterAdi">Ad:</label>
                <input type="text" id="sekreterAdi" name="sekreterAdi" value="<?php echo htmlspecialchars($sekreter['SekreterAdi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="sekreterSoyadi">Soyad:</label>
                <input type="text" id="sekreterSoyadi" name="sekreterSoyadi" value="<?php echo htmlspecialchars($sekreter['SekreterSoyadi']); ?>" required>
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