<?php
require_once 'config/database.php';

// Branşları çek
$sql = "SELECT * FROM Brans ORDER BY BransAdi";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aydın Hastanesi - Hastane Otomasyon Sistemi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="hospital-name">Aydın Hastanesi</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Ana Sayfa</a></li>
                    <li><a href="hasta/index.php">Hasta İşlemleri</a></li>
                    <li><a href="doktor/index.php">Doktor İşlemleri</a></li>
                    <li><a href="randevu/index.php">Randevu İşlemleri</a></li>
                    <li><a href="sekreter/index.php">Sekreter İşlemleri</a></li>
                    <li><a href="brans/index.php">Branş İşlemleri</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="welcome-section">
            <h2>Hoş Geldiniz</h2>
            <p>Aydın Hastanesi'ne hoş geldiniz. Sağlığınız için buradayız.</p>
        </div>

        <div class="dashboard">
            <div class="card">
                <div class="card-icon">👥</div>
                <h2>Hasta İşlemleri</h2>
                <p>Hasta kayıt, listeleme ve güncelleme işlemleri</p>
                <a href="hasta/index.php" class="button">Hasta İşlemleri</a>
            </div>
            <div class="card">
                <div class="card-icon">👨‍⚕️</div>
                <h2>Doktor İşlemleri</h2>
                <p>Doktor ve branş yönetimi</p>
                <a href="doktor/index.php" class="button">Doktor İşlemleri</a>
            </div>
            <div class="card">
                <div class="card-icon">📅</div>
                <h2>Randevu İşlemleri</h2>
                <p>Randevu oluşturma ve yönetimi</p>
                <a href="randevu/index.php" class="button">Randevu İşlemleri</a>
            </div>
            <div class="card">
                <div class="card-icon">👩‍💼</div>
                <h2>Sekreter İşlemleri</h2>
                <p>Sekreter yönetimi</p>
                <a href="sekreter/index.php" class="button">Sekreter İşlemleri</a>
            </div>
            <div class="card">
                <div class="card-icon">🏥</div>
                <h2>Branş İşlemleri</h2>
                <p>Branş yönetimi ve doktor listesi</p>
                <a href="brans/index.php" class="button">Branş İşlemleri</a>
            </div>
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