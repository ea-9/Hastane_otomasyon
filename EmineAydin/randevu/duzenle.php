<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Hasta listesini çekme
$hasta_sql = "SELECT * FROM Hasta ORDER BY Ad, Soyad";
$hastalar = mysqli_query($conn, $hasta_sql);

// Doktor listesini branşlarıyla birlikte çekme
$doktor_sql = "SELECT Doktor.*, Brans.BransAdi 
               FROM Doktor 
               INNER JOIN Brans ON Doktor.BransID = Brans.BransID 
               ORDER BY Doktor.Ad, Doktor.Soyad";
$doktorlar = mysqli_query($conn, $doktor_sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hasta_id = mysqli_real_escape_string($conn, $_POST['hasta_id']);
    $doktor_id = mysqli_real_escape_string($conn, $_POST['doktor_id']);
    $randevu_tarihi = mysqli_real_escape_string($conn, $_POST['randevu_tarihi']);
    $randevu_saati = mysqli_real_escape_string($conn, $_POST['randevu_saati']);
    $randevu_durumu = mysqli_real_escape_string($conn, $_POST['randevu_durumu']);

    // Aynı doktor için aynı tarih ve saatte başka randevu var mı kontrol et
    $check_sql = "SELECT COUNT(*) as count FROM Randevu 
                  WHERE DoktorID = $doktor_id 
                  AND RandevuTarihi = '$randevu_tarihi' 
                  AND RandevuSaati = '$randevu_saati'
                  AND RandevuID != $id";
    $check_result = mysqli_query($conn, $check_sql);
    $check_row = mysqli_fetch_assoc($check_result);

    if ($check_row['count'] > 0) {
        header('Location: index.php?error=Seçilen tarih ve saatte doktorun başka bir randevusu bulunmaktadır');
        exit;
    }

    $sql = "UPDATE Randevu SET 
            HastaID = '$hasta_id',
            DoktorID = '$doktor_id',
            RandevuTarihi = '$randevu_tarihi',
            RandevuSaati = '$randevu_saati',
            RandevuDurumu = '$randevu_durumu'
            WHERE RandevuID = $id";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php?success=1');
        exit;
    } else {
        header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}

// Randevu bilgilerini çekme
$sql = "SELECT * FROM Randevu WHERE RandevuID = $id";
$result = mysqli_query($conn, $sql);
$randevu = mysqli_fetch_assoc($result);

if (!$randevu) {
    header('Location: index.php?error=Randevu bulunamadı');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Düzenle - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Ana Sayfa</a></li>
                <li><a href="../hasta/index.php">Hasta İşlemleri</a></li>
                <li><a href="../doktor/index.php">Doktor İşlemleri</a></li>
                <li><a href="index.php">Randevu İşlemleri</a></li>
                <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Randevu Düzenle</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="hasta_id">Hasta:</label>
                <select id="hasta_id" name="hasta_id" required>
                    <option value="">Hasta Seçiniz</option>
                    <?php while ($hasta = mysqli_fetch_assoc($hastalar)): ?>
                        <option value="<?php echo $hasta['HastaID']; ?>" 
                                <?php echo $hasta['HastaID'] == $randevu['HastaID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($hasta['Ad'] . ' ' . $hasta['Soyad']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="doktor_id">Doktor:</label>
                <select id="doktor_id" name="doktor_id" required>
                    <option value="">Doktor Seçiniz</option>
                    <?php while ($doktor = mysqli_fetch_assoc($doktorlar)): ?>
                        <option value="<?php echo $doktor['DoktorID']; ?>"
                                <?php echo $doktor['DoktorID'] == $randevu['DoktorID'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($doktor['Ad'] . ' ' . $doktor['Soyad'] . ' (' . $doktor['BransAdi'] . ')'); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="randevu_tarihi">Randevu Tarihi:</label>
                <input type="date" id="randevu_tarihi" name="randevu_tarihi" 
                       value="<?php echo htmlspecialchars($randevu['RandevuTarihi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="randevu_saati">Randevu Saati:</label>
                <input type="time" id="randevu_saati" name="randevu_saati" 
                       value="<?php echo htmlspecialchars($randevu['RandevuSaati']); ?>" required>
            </div>

            <div class="form-group">
                <label for="randevu_durumu">Randevu Durumu:</label>
                <select id="randevu_durumu" name="randevu_durumu" required>
                    <option value="Planlandı" <?php echo $randevu['RandevuDurumu'] === 'Planlandı' ? 'selected' : ''; ?>>Planlandı</option>
                    <option value="Gerçekleşti" <?php echo $randevu['RandevuDurumu'] === 'Gerçekleşti' ? 'selected' : ''; ?>>Gerçekleşti</option>
                    <option value="İptal Edildi" <?php echo $randevu['RandevuDurumu'] === 'İptal Edildi' ? 'selected' : ''; ?>>İptal Edildi</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="button">Güncelle</button>
                <a href="index.php" class="button">İptal</a>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Hastane Otomasyon Sistemi</p>
    </footer>
</body>
</html> 