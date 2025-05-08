<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = (int)$_GET['id'];

// Branş bilgilerini çek
$sql = "SELECT * FROM Brans WHERE BransID = $id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    header('Location: index.php?error=Branş bulunamadı');
    exit;
}

$brans = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bransAdi = mysqli_real_escape_string($conn, $_POST['bransAdi']);
    
    // Branş adının boş olup olmadığını kontrol et
    if (empty($bransAdi)) {
        header('Location: index.php?error=Branş adı boş olamaz');
        exit;
    }
    
    // Aynı isimde başka bir branş var mı kontrol et
    $checkSql = "SELECT COUNT(*) as count FROM Brans WHERE BransAdi = '$bransAdi' AND BransID != $id";
    $checkResult = mysqli_query($conn, $checkSql);
    $row = mysqli_fetch_assoc($checkResult);
    
    if ($row['count'] > 0) {
        header('Location: index.php?error=Bu isimde bir branş zaten mevcut');
        exit;
    }
    
    // Branşı güncelle
    $sql = "UPDATE Brans SET BransAdi = '$bransAdi' WHERE BransID = $id";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php?success=1');
    } else {
        header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branş Düzenle - Aydın Hastanesi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="hospital-name">Aydın Hastanesi</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Ana Sayfa</a></li>
                    <li><a href="../hasta/index.php">Hasta İşlemleri</a></li>
                    <li><a href="../doktor/index.php">Doktor İşlemleri</a></li>
                    <li><a href="../randevu/index.php">Randevu İşlemleri</a></li>
                    <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
                    <li><a href="index.php">Branş İşlemleri</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Branş Düzenle</h1>
        
        <form method="POST" class="form">
            <div class="form-group">
                <label for="bransAdi">Branş Adı:</label>
                <input type="text" id="bransAdi" name="bransAdi" value="<?php echo htmlspecialchars($brans['BransAdi']); ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="button">Değişiklikleri Kaydet</button>
                <a href="index.php" class="button">İptal</a>
            </div>
        </form>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Aydın Hastanesi - Tüm Hakları Saklıdır</p>
            <div class="footer-info">
                <p>Adres: Örnek Mahallesi, Örnek Sokak No:1</p>
                <p>Telefon: (0212) 123 45 67</p>
                <p>E-posta: info@aydinhastanesi.com</p>
            </div>
        </div>
    </footer>
</body>
</html> 