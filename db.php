<?php
$host = "localhost";
$port = "5432";
$dbname = "KadinTarim";
$user = "postgres";
$pass = "12345"; // kendi şifren

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // HATA GÖSTER
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
?>
