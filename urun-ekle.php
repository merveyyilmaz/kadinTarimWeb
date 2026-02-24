<?php
include "db.php";
$durum = $_GET['durum'] ?? '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Ekle</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff;
            padding: 30px;
            width: 360px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        input {
            width: 100%;
            padding: 14px;
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border-color: #27ae60;
        }

        /* 🗣️ Sesle ekle alanı */
        .voice-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: #ecf9f1;
            border: 2px dashed #27ae60;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 10px;
            font-size: 18px;
            color: #27ae60;
            user-select: none;
        }

        .voice-box span {
            font-size: 26px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #27ae60;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            cursor: pointer;
        }

        button:hover {
            background: #219150;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🌿 Ürün Ekle</h2>

    <?php if ($durum == "ok"): ?>
        <div class="message success">✅ Ürün başarıyla eklendi</div>
    <?php elseif ($durum == "hata"): ?>
        <div class="message error">❌ Ürün eklenirken hata oluştu</div>
    <?php endif; ?>

    <form action="urun-kaydet.php" method="POST" enctype="multipart/form-data">

        <!-- 🗣️ ÜRÜN ADININ ÜSTÜ -->
        <div class="voice-box">
            <span>🗣️</span>
            <div>Sesle ekle</div>
        </div>

        <input type="text" name="name" placeholder="Ürün adı" required>

        <input type="number" name="price" placeholder="Fiyat (₺)" required>

        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Kaydet</button>

    </form>
</div>

</body>
</html>
