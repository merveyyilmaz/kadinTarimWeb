<?php
include "db.php";

$name  = $_POST['name'] ?? null;
$price = $_POST['price'] ?? null;

if (!$name || !$price || !isset($_FILES['image'])) {
    header("Location: urun-ekle.php?durum=hata");
    exit;
}

$uploads_dir = "uploads/";
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir, 0777, true);
}

$filename = time() . "_" . basename($_FILES["image"]["name"]);
$target_path = $uploads_dir . $filename;

if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
    header("Location: urun-ekle.php?durum=hata");
    exit;
}

$sql = "INSERT INTO urunler (name, price, image_path)
        VALUES (:name, :price, :image)";

$stmt = $db->prepare($sql);
$stmt->execute([
    ':name'  => $name,
    ':price' => $price,
    ':image' => $target_path
]);

header("Location: urun-ekle.php?durum=ok");
exit;
