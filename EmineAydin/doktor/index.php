<?php require_once '../header.php'; ?>
<?php
require_once '../config/database.php';

// Branşları çek
$bransSql = "SELECT * FROM Brans ORDER BY BransAdi";
$bransResult = mysqli_query($conn, $bransSql);

// Doktor listesini branşlarıyla birlikte çekme
$sql = "SELECT Doktor.*, Brans.BransAdi 
        FROM Doktor 
        LEFT JOIN Brans ON Doktor.BransID = Brans.BransID 
        ORDER BY Doktor.DoktorID DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doktor Yönetimi - Hastane Otomasyon Sistemi</title>
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
                    <li><a href="index.php">Doktor İşlemleri</a></li>
                    <li><a href="../randevu/index.php">Randevu İşlemleri</a></li>
                    <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
                    <li><a href="../brans/index.php">Branş İşlemleri</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Doktor Yönetimi</h1>
        
        <div class="actions">
            <a href="ekle.php" class="button">Yeni Doktor Ekle</a>
            <a href="brans.php" class="button">Branş Yönetimi</a>
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
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Branş</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['DoktorID']); ?></td>
                    <td><?php echo htmlspecialchars($row['Ad']); ?></td>
                    <td><?php echo htmlspecialchars($row['Soyad']); ?></td>
                    <td><?php echo htmlspecialchars($row['BransAdi']); ?></td>
                    <td>
                        <a href="duzenle.php?id=<?php echo $row['DoktorID']; ?>" class="button">Düzenle</a>
                        <a href="sil.php?id=<?php echo $row['DoktorID']; ?>" class="button" onclick="return confirm('Bu doktoru silmek istediğinizden emin misiniz?')">Sil</a>
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