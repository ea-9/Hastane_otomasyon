<?php require_once '../header.php'; ?>
<?php
require_once '../config/database.php';

// Branş listesini doktor sayılarıyla birlikte çekme
$sql = "SELECT b.*, COUNT(d.DoktorID) as DoktorSayisi 
        FROM Brans b 
        LEFT JOIN Doktor d ON b.BransID = d.BransID 
        GROUP BY b.BransID 
        ORDER BY b.BransAdi";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branş Yönetimi - Aydın Hastanesi</title>
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
        <h1>Branş Yönetimi</h1>
        
        <div class="actions">
            <a href="ekle.php" class="button">Yeni Branş Ekle</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                İşlem başarıyla tamamlandı.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                Bir hata oluştu: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <div class="branches-grid">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="branch-card">
                <h3><?php echo htmlspecialchars($row['BransAdi']); ?></h3>
                <p class="doctor-count">Doktor Sayısı: <?php echo $row['DoktorSayisi']; ?></p>
                <div class="branch-actions">
                    <a href="doktorlar.php?id=<?php echo $row['BransID']; ?>" class="button">Doktorları Görüntüle</a>
                    <a href="duzenle.php?id=<?php echo $row['BransID']; ?>" class="button">Düzenle</a>
                    <a href="sil.php?id=<?php echo $row['BransID']; ?>" class="button" onclick="return confirm('Bu branşı silmek istediğinizden emin misiniz?')">Sil</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
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