<?php
session_start();
if (empty($_SESSION['sepet'])) {
    header("Location: urunler.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Ödeme</title>
<style>
body {
    font-family: Arial;
    background: #7fa6dbff;
    padding: 40px;
}

.form {
    background: #fff;
    padding: 25px;
    max-width: 400px;
    margin: auto;
    border-radius: 10px;
    text-align: center; /* başlık ortalanır */
}

.form h2 {
    margin-bottom: 20px;
}

.form form {
    display: flex;
    flex-direction: column;
    align-items: center; /* inputlar ortalanır */
}

.form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    box-sizing: border-box;
}

.form button {
    width: 100%;
    padding: 10px;
    background: #27ae60;
    color: #fff;
    border: none;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
}

.form button:hover {
    background: #1e8449;
}

</style>
</head>
<body>

<div class="form">
<h2>💳 Ödeme Bilgileri</h2>
<form method="POST" action="odeme_islem.php">

    <input type="text"
           name="adsoyad"
           placeholder="Ad Soyad"
           required>

    <!-- Kart Numarası: 16 hane -->
    <input type="text"
           name="kartno"
           placeholder="Kart Numarası (16 hane)"
           maxlength="16"
           pattern="[0-9]{16}"
           title="Kart numarası 16 haneli olmalıdır"
           required>

    <!-- Son Kullanma Tarihi: AA/YY -->
    <input type="month"
       name="skt"
       required>


           

    <!-- CVV: 3 hane -->
    <input type="text"
           name="cvv"
           placeholder="CVV"
           maxlength="3"
           pattern="[0-9]{3}"
           title="CVV 3 haneli olmalıdır"
           required>

    <button type="submit">Ödeme Yap</button>
</form>

</div>

</body>
</html>
