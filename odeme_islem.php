<?php
session_start();
include "db.php"; // eğer siparişleri kaydetmek istiyorsan db bağlantısı

if (empty($_SESSION['sepet'])) {
    header("Location: urunler.php");
    exit;
}

// Toplam tutarı hesapla
$toplam = 0;
foreach ($_SESSION['sepet'] as $item) {
    $urun = $db->prepare("SELECT price FROM urunler WHERE id=?");
    $urun->execute([$item['urun_id']]);
    $fiyat = $urun->fetchColumn();
    $toplam += $fiyat * $item['kilo'];
}

// Siparişi kaydet (opsiyonel)
$siparis = $db->prepare("INSERT INTO siparisler (toplam_tutar) VALUES (?)");
$siparis->execute([$toplam]);

// Sepeti temizle
unset($_SESSION['sepet']);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Sipariş Başarılı</title>
<style>
body { font-family: Arial; background:#7fa6dbff; text-align:center; padding:100px; }
.box { background:#fff; display:inline-block; padding:30px 40px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);}
h2 { color:#27ae60; margin-bottom:20px; }
p { font-size:16px; margin-bottom:20px; }
a.button {
    display:inline-block;
    padding:10px 20px;
    background:#27ae60;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    transition:0.3s;
}
a.button:hover { background:#1e8449; transform:scale(1.05); }
</style>
</head>
<body>

<div class="box">
    <h2>✅ Siparişiniz Başarılı</h2>
    <p>Siparişiniz başarıyla oluşturuldu.<br>Toplam Tutar: <strong><?= $toplam ?> ₺</strong></p>
    <a class="button" href="urunler.php">🛒 Ürünlere Dön</a>
</div>

</body>
</html>
