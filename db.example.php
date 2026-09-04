<?php
$host = "localhost";
$port = "5432";
$dbname = "KadinTarim";
$user = "postgres";
$pass = "BURAYA_SIFRENI_YAZ";

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}
