<?php require_once '../header.php'; ?>
<?php
require_once '../config/database.php';

// Randevu listesini hasta ve doktor bilgileriyle birlikte çekme
$sql = "SELECT Randevu.*, 
        Hasta.Ad AS HastaAdi, Hasta.Soyad AS HastaSoyadi,
        Doktor.Ad AS DoktorAdi, Doktor.Soyad AS DoktorSoyadi,
        Brans.BransAdi
        FROM Randevu 
        INNER JOIN Hasta ON Randevu.HastaID = Hasta.HastaID
        INNER JOIN Doktor ON Randevu.DoktorID = Doktor.DoktorID
        INNER JOIN Brans ON Doktor.BransID = Brans.BransID
        ORDER BY Randevu.RandevuTarihi DESC, Randevu.RandevuSaati DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Yönetimi - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
                    <li><a href="index.php">Randevu İşlemleri</a></li>
                    <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
                    <li><a href="../brans/index.php">Branş İşlemleri</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Randevu Yönetimi</h1>
        
        <div class="actions">
            <a href="ekle.php" class="button">Yeni Randevu Oluştur</a>
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

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hasta</th>
                    <th>Doktor</th>
                    <th>Branş</th>
                    <th>Tarih</th>
                    <th>Saat</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['RandevuID']); ?></td>
                    <td><?php echo htmlspecialchars($row['HastaAdi'] . ' ' . $row['HastaSoyadi']); ?></td>
                    <td><?php echo htmlspecialchars($row['DoktorAdi'] . ' ' . $row['DoktorSoyadi']); ?></td>
                    <td><?php echo htmlspecialchars($row['BransAdi']); ?></td>
                    <td><?php echo htmlspecialchars($row['RandevuTarihi']); ?></td>
                    <td><?php echo htmlspecialchars($row['RandevuSaati']); ?></td>
                    <td><?php echo htmlspecialchars($row['RandevuDurumu']); ?></td>
                    <td>
                        <a href="duzenle.php?id=<?php echo $row['RandevuID']; ?>" class="button">Düzenle</a>
                        <a href="sil.php?id=<?php echo $row['RandevuID']; ?>" class="button" onclick="return confirm('Bu randevuyu silmek istediğinizden emin misiniz?')">Sil</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 Hastane Otomasyon Sistemi</p>
    </footer>
</body>
</html> 