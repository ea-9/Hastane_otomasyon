<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = (int)$_GET['id'];

// Branş bilgilerini çek
$bransSql = "SELECT * FROM Brans WHERE BransID = $id";
$bransResult = mysqli_query($conn, $bransSql);

if (!$bransResult || mysqli_num_rows($bransResult) === 0) {
    header('Location: index.php?error=Branş bulunamadı');
    exit;
}

$brans = mysqli_fetch_assoc($bransResult);

// Branşa ait doktorları çek
$doktorSql = "SELECT * FROM Doktor WHERE BransID = $id ORDER BY Ad, Soyad";
$doktorResult = mysqli_query($conn, $doktorSql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($brans['BransAdi']); ?> Doktorları - Aydın Hastanesi</title>
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
        <h1><?php echo htmlspecialchars($brans['BransAdi']); ?> Doktorları</h1>
        
        <div class="actions">
            <a href="index.php" class="button">Branş Listesine Dön</a>
        </div>

        <?php if (mysqli_num_rows($doktorResult) === 0): ?>
            <p class="no-data">Bu branşta henüz doktor bulunmamaktadır.</p>
        <?php else: ?>
            <div class="doctors-grid">
                <?php while ($doktor = mysqli_fetch_assoc($doktorResult)): ?>
                <div class="doctor-card">
                    <h3><?php echo htmlspecialchars($doktor['Ad'] . ' ' . $doktor['Soyad']); ?></h3>
                    <div class="doctor-actions">
                        <a href="../doktor/duzenle.php?id=<?php echo $doktor['DoktorID']; ?>" class="button">Düzenle</a>
                        <a href="../randevu/index.php?doktor_id=<?php echo $doktor['DoktorID']; ?>" class="button">Randevuları Görüntüle</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
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