<?php
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php?error=ID belirtilmedi');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = mysqli_real_escape_string($conn, $_POST['ad']);
    $soyad = mysqli_real_escape_string($conn, $_POST['soyad']);
    $telefon = mysqli_real_escape_string($conn, $_POST['telefon']);
    $eposta = mysqli_real_escape_string($conn, $_POST['eposta']);
    $dogumTarihi = mysqli_real_escape_string($conn, $_POST['dogumTarihi']);
    $cinsiyet = mysqli_real_escape_string($conn, $_POST['cinsiyet']);

    $sql = "UPDATE Hasta SET 
            Ad = '$ad',
            Soyad = '$soyad',
            TelefonNumarasi = '$telefon',
            EPosta = '$eposta',
            DogumTarihi = '$dogumTarihi',
            Cinsiyet = '$cinsiyet'
            WHERE HastaID = $id";

    if (mysqli_query($conn, $sql)) {
        header('Location: index.php?success=1');
        exit;
    } else {
        header('Location: index.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}

// Hasta bilgilerini çekme
$sql = "SELECT * FROM Hasta WHERE HastaID = $id";
$result = mysqli_query($conn, $sql);
$hasta = mysqli_fetch_assoc($result);

if (!$hasta) {
    header('Location: index.php?error=Hasta bulunamadı');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasta Düzenle - Hastane Otomasyon Sistemi</title>
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
        <h1>Hasta Düzenle</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="ad">Ad:</label>
                <input type="text" id="ad" name="ad" value="<?php echo htmlspecialchars($hasta['Ad']); ?>" required>
            </div>

            <div class="form-group">
                <label for="soyad">Soyad:</label>
                <input type="text" id="soyad" name="soyad" value="<?php echo htmlspecialchars($hasta['Soyad']); ?>" required>
            </div>

            <div class="form-group">
                <label for="telefon">Telefon Numarası:</label>
                <input type="tel" id="telefon" name="telefon" value="<?php echo htmlspecialchars($hasta['TelefonNumarasi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="eposta">E-posta:</label>
                <input type="email" id="eposta" name="eposta" value="<?php echo htmlspecialchars($hasta['EPosta']); ?>">
            </div>

            <div class="form-group">
                <label for="dogumTarihi">Doğum Tarihi:</label>
                <input type="date" id="dogumTarihi" name="dogumTarihi" value="<?php echo htmlspecialchars($hasta['DogumTarihi']); ?>">
            </div>

            <div class="form-group">
                <label for="cinsiyet">Cinsiyet:</label>
                <select id="cinsiyet" name="cinsiyet" required>
                    <option value="">Seçiniz</option>
                    <option value="Erkek" <?php echo $hasta['Cinsiyet'] === 'Erkek' ? 'selected' : ''; ?>>Erkek</option>
                    <option value="Kadın" <?php echo $hasta['Cinsiyet'] === 'Kadın' ? 'selected' : ''; ?>>Kadın</option>
                    <option value="Diğer" <?php echo $hasta['Cinsiyet'] === 'Diğer' ? 'selected' : ''; ?>>Diğer</option>
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