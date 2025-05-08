<?php
require_once '../config/database.php';

// Branş ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['brans_adi'])) {
    $brans_adi = mysqli_real_escape_string($conn, $_POST['brans_adi']);
    $sql = "INSERT INTO Brans (BransAdi) VALUES ('$brans_adi')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: brans.php?success=1');
        exit;
    } else {
        header('Location: brans.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}

// Branş silme işlemi
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = mysqli_real_escape_string($conn, $_GET['sil']);
    
    // Önce bu branşa ait doktor var mı kontrol et
    $check_sql = "SELECT COUNT(*) as count FROM Doktor WHERE BransID = $id";
    $result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['count'] > 0) {
        header('Location: brans.php?error=Bu branşa ait doktorlar bulunduğu için silinemez');
        exit;
    }
    
    $sql = "DELETE FROM Brans WHERE BransID = $id";
    if (mysqli_query($conn, $sql)) {
        header('Location: brans.php?success=1');
        exit;
    } else {
        header('Location: brans.php?error=' . urlencode(mysqli_error($conn)));
        exit;
    }
}

// Branş listesini çekme
$sql = "SELECT * FROM Brans ORDER BY BransAdi";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branş Yönetimi - Hastane Otomasyon Sistemi</title>
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
        <h1>Branş Yönetimi</h1>

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

        <div class="card">
            <h2>Yeni Branş Ekle</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="brans_adi">Branş Adı:</label>
                    <input type="text" id="brans_adi" name="brans_adi" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Ekle</button>
                </div>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branş Adı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['BransID']); ?></td>
                    <td><?php echo htmlspecialchars($row['BransAdi']); ?></td>
                    <td>
                        <a href="?sil=<?php echo $row['BransID']; ?>" class="button" onclick="return confirm('Bu branşı silmek istediğinizden emin misiniz?')">Sil</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="actions">
            <a href="index.php" class="button">Doktor Listesine Dön</a>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Hastane Otomasyon Sistemi</p>
    </footer>
</body>
</html> 