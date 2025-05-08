-- Hastane Otomasyon veritabanı şeması
CREATE DATABASE IF NOT EXISTS hastane_otomasyon;
USE hastane_otomasyon;

-- Branş tablosu
CREATE TABLE IF NOT EXISTS Brans (
    BransID INT PRIMARY KEY AUTO_INCREMENT,
    BransAdi VARCHAR(100) NOT NULL UNIQUE
);

-- Doktor tablosu
CREATE TABLE IF NOT EXISTS Doktor (
    DoktorID INT PRIMARY KEY AUTO_INCREMENT,
    Ad VARCHAR(50) NOT NULL,
    Soyad VARCHAR(50) NOT NULL,
    BransID INT,
    FOREIGN KEY (BransID) REFERENCES Brans(BransID)
);

-- Hasta tablosu
CREATE TABLE IF NOT EXISTS Hasta (
    HastaID INT PRIMARY KEY AUTO_INCREMENT,
    Ad VARCHAR(50) NOT NULL,
    Soyad VARCHAR(50) NOT NULL,
    TelefonNumarasi VARCHAR(20) NOT NULL UNIQUE,
    EPosta VARCHAR(100) UNIQUE,
    DogumTarihi DATE,
    Cinsiyet ENUM('Erkek', 'Kadın', 'Diğer')
);

-- Sekreter tablosu
CREATE TABLE IF NOT EXISTS Sekreter (
    SekreterID INT PRIMARY KEY AUTO_INCREMENT,
    SekreterAdi VARCHAR(50) NOT NULL,
    SekreterSoyadi VARCHAR(50) NOT NULL
);

-- Randevu tablosu
CREATE TABLE IF NOT EXISTS Randevu (
    RandevuID INT PRIMARY KEY AUTO_INCREMENT,
    HastaID INT,
    DoktorID INT,
    RandevuTarihi DATE NOT NULL,
    RandevuSaati TIME NOT NULL,
    RandevuDurumu ENUM('Planlandı', 'Gerçekleşti', 'İptal Edildi') DEFAULT 'Planlandı',
    FOREIGN KEY (HastaID) REFERENCES Hasta(HastaID),
    FOREIGN KEY (DoktorID) REFERENCES Doktor(DoktorID)
); 