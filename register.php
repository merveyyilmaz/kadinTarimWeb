<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Kullanıcı adı kontrolü
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $error = "Bu kullanıcı adı zaten alınmış!";
    } else {
        // Yeni kullanıcı ekle
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([':username' => $username, ':password' => $password]);

        // Kayıttan sonra giriş sayfasına yönlendir
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Kayıt Ol - Kadın Tarım</title>
<style>
/* Arka plan görseli */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    background: url('uploads/background.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form kutusu */
.form-container {
    background: rgba(255, 255, 255, 0.9); /* yarı saydam beyaz arka plan */
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    width: 350px;
    text-align: center;
}

/* Başlık */
.form-container h2 {
    margin-bottom: 25px;
    color: #2c3e50;
    font-family: 'Georgia', serif;
}

/* Inputlar */
.form-container input[type="text"],
.form-container input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
}

/* Buton */
.form-container button {
    width: 100%;
    padding: 12px;
    background-color: #27ae60;
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}
.form-container button:hover {
    background-color: #1e8449;
    transform: scale(1.05);
}

/* Hata mesajı */
.error {
    color: red;
    margin-bottom: 15px;
}

/* Link */
.form-container a {
    display: inline-block;
    margin-top: 12px;
    color: #27ae60;
    text-decoration: none;
}
.form-container a:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="form-container">
    <h2>Kayıt Ol</h2>
    <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit">Kaydol</button>
    </form>
    <a href="login.php">Giriş Yap</a>
</div>

</body>
</html>
