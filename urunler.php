<?php
session_start();

// 🔒 Giriş kontrolü
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

// Sepet dizisi yoksa oluştur
if (!isset($_SESSION['sepet'])) {
    $_SESSION['sepet'] = [];
}

// Sepetten çıkarma işlemi
if (isset($_GET['cikar_id'])) {
    $cikar_id = $_GET['cikar_id'];
    foreach ($_SESSION['sepet'] as $key => $item) {
        if ($item['urun_id'] == $cikar_id) {
            unset($_SESSION['sepet'][$key]);
            break;
        }
    }
    $_SESSION['sepet'] = array_values($_SESSION['sepet']); // indexleri düzelt
    header("Location: urunler.php");
    exit;
}

// Sepete ekleme işlemi
if (isset($_POST['urun_id']) && isset($_POST['kilo'])) {
    $urun_id = $_POST['urun_id'];
    $kilo = $_POST['kilo'];

    // Aynı ürün varsa kilo güncelle
    $found = false;
    foreach ($_SESSION['sepet'] as &$item) {
        if ($item['urun_id'] == $urun_id) {
            $item['kilo'] = $kilo;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['sepet'][] = ['urun_id' => $urun_id, 'kilo' => $kilo];
    }
    header("Location: urunler.php");
    exit;
}

// Ürünleri veritabanından çek
$urunler = $db->query("SELECT * FROM urunler ORDER BY id DESC")
              ->fetchAll(PDO::FETCH_ASSOC);

// Sepetteki ürünleri detaylı çekmek için
$sepet_detay = [];
foreach ($_SESSION['sepet'] as $item) {
    foreach ($urunler as $urun) {
        if ($urun['id'] == $item['urun_id']) {
            $urun['kilo'] = $item['kilo'];
            $sepet_detay[] = $urun;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Ürünler</title>
<style>
body { font-family: Arial, Helvetica, sans-serif; background: #7fa6dbff; margin:0; padding:20px; }
h2 { text-align:center; margin-bottom:30px; color:#2c3e50; }
.urunler { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px; }
.urun { background:#fff; border-radius:10px; padding:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); text-align:center; }
.urun img { width:100%; height:150px; object-fit:cover; border-radius:8px; margin-bottom:10px; }
.urun h3 { margin:10px 0 5px; font-size:18px; color:#333; }
.urun p { margin:0; font-size:16px; font-weight:bold; color:#27ae60; }
.siparis-btn { display:inline-block; margin-top:12px; padding:10px 16px; background:#27ae60; color:#fff; text-decoration:none; border-radius:6px; font-size:15px; font-weight:bold; transition:0.3s; cursor:pointer; border:none; }
.siparis-btn:hover { background:#219150; transform:scale(1.05); }
select { margin-top:10px; padding:5px; border-radius:5px; }
.sepet { background:#fff; padding:15px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); margin-bottom:30px; }
.sepet h3 { margin-top:0; }

/* Sepet satırı düzeni */
.sepet-item { 
    display:flex; 
    justify-content:space-between; 
    align-items:center; 
    margin-bottom:8px; 
    padding:5px 0;
}

/* Sepetten çıkar butonu */
.cikar-btn { 
    background:red; 
    color:#fff; 
    border:none; 
    border-radius:4px; 
    padding:4px 8px; 
    cursor:pointer; 
    font-weight:bold; 
    margin-right:10px; 
}
.cikar-btn:hover { background:#c0392b; }

/* Ödeme butonu */
.odeme-btn { 
    margin-top:10px; 
    padding:10px 16px; 
    background:#27ae60; 
    color:#fff; 
    border:none; 
    border-radius:6px; 
    cursor:pointer; 
    font-weight:bold; 
}
.odeme-btn:hover { 
    background:#1e8449; 
    transform:scale(1.05); 
}
</style>

</head>
<body>

<h2>🌿ÜRÜN LİSTESİ</h2>

<!-- Sepet Kısmı -->
<div class="sepet">
<h3>🛒 Sepetiniz</h3>
<?php if (empty($sepet_detay)): ?>
    <p>Sepetiniz boş.</p>
<?php else: ?>
    <?php foreach ($sepet_detay as $item): ?>
        <div class="sepet-item">
            <span style="display:flex; align-items:center; justify-content:space-between; width:100%;">
                <span>
                    <?= htmlspecialchars($item['name']) ?> (<?= $item['kilo'] ?> kg)
                </span>
                <span style="display:flex; align-items:center;">
                    <form method="GET" style="margin:0;">
                        <input type="hidden" name="cikar_id" value="<?= $item['id'] ?>">
                        <button class="cikar-btn" type="submit">❌</button>
                    </form>
                    <span style="margin-left:10px; font-weight:bold;"><?= htmlspecialchars($item['price'] * $item['kilo']) ?> ₺</span>
                </span>
            </span>
        </div>
    <?php endforeach; ?>
    <strong>Toplam: 
    <?php
    $toplam = 0;
    foreach ($sepet_detay as $item) { $toplam += $item['price'] * $item['kilo']; }
    echo $toplam . " ₺";
    ?>
    </strong><br>

<a href="odeme.php">
    <button class="odeme-btn">💳 Ödeme</button>
</a>

<?php endif; ?>
</div>


<!-- Ürünler Listesi -->
<div class="urunler">
<?php foreach ($urunler as $urun): ?>
    <div class="urun">
        <?php if (!empty($urun["image_path"])): ?>
            <img src="<?= htmlspecialchars($urun["image_path"]) ?>" alt="Ürün Görseli">
        <?php else: ?>
            <img src="uploads/default.png" alt="Varsayılan Görsel">
        <?php endif; ?>
        <h3><?= htmlspecialchars($urun["name"]) ?></h3>
        <p><?= htmlspecialchars($urun["price"]) ?> ₺</p>

        <!-- Sepete ekleme formu -->
        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="urun_id" value="<?= $urun['id'] ?>">
            <select name="kilo">
                <?php for ($i=1; $i<=5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?>.0</option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="siparis-btn">🛒 Sepete Ekle</button>
        </form>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
