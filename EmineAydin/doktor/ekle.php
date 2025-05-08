<?php
require_once '../config/database.php';

// Branş listesini çekme
$sql = "SELECT * FROM Brans ORDER BY BransAdi";
$branslar = mysqli_query($conn, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = mysqli_real_escape_string($conn, $_POST['ad']);
    $soyad = mysqli_real_escape_string($conn, $_POST['soyad']);
    $brans_id = mysqli_real_escape_string($conn, $_POST['brans_id']);

    $sql = "INSERT INTO Doktor (Ad, Soyad, BransID) VALUES ('$ad', '$soyad', '$brans_id')";

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
    <title>Yeni Doktor Ekle - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="../index.php">Ana Sayfa</a></li>
                <li><a href="../hasta/index.php">Hasta İşlemleri</a></li>
                <li><a href="index.php">Doktor İşlemleri</a></li>
                <li><a href="../randevu/index.php">Randevu İşlemleri</a></li>
                <li><a href="../sekreter/index.php">Sekreter İşlemleri</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Yeni Doktor Ekle</h1>

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
                <label for="brans_id">Branş:</label>
                <select id="brans_id" name="brans_id" required>
                    <option value="">Branş Seçiniz</option>
                    <?php while ($brans = mysqli_fetch_assoc($branslar)): ?>
                        <option value="<?php echo $brans['BransID']; ?>">
                            <?php echo htmlspecialchars($brans['BransAdi']); ?>
                        </option>
                    <?php endwhile; ?>
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