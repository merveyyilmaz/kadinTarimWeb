# Kadın Tarım Girişimcilik

Kadın üreticilerin tarım ürünlerini dijital ortamda sergileyip satabileceği bir web uygulaması.  
Kullanıcı kaydı, giriş, ürün ekleme, sepet ve örnek ödeme akışı içerir.

> Bu proje bir **öğrenci / demo uygulamasıdır**. Gerçek ödeme altyapısı yoktur; kart bilgileri bankaya gönderilmez.

## Özellikler

- Kullanıcı kayıt ve giriş (şifreler `password_hash` ile saklanır)
- Ürün listeleme (görsel, ad, fiyat)
- Ürün ekleme (görsel yükleme)
- Sepete ekleme / sepetten çıkarma (kg seçimi)
- Örnek ödeme formu ve sipariş kaydı

## Kullanılan teknolojiler

- PHP
- PostgreSQL
- HTML / CSS
- PDO (veritabanı bağlantısı)

## Gereksinimler

- PHP 8.x (PDO PostgreSQL eklentisi açık olmalı)
- PostgreSQL
- Yerel sunucu: XAMPP, Laragon, WAMP veya PHP built-in server

## Kurulum

1. Depoyu klonlayın:

```bash
git clone https://github.com/merveyyilmaz/kadinTarimWeb.git
cd kadinTarimWeb
```

2. Örnek veritabanı dosyasını kopyalayıp kendi bilgilerinizi yazın:

```bash
cp db.example.php db.php
```

`db.php` içine kendi PostgreSQL şifrenizi yazın. Bu dosya GitHub’a yüklenmez.

3. PostgreSQL’de veritabanını oluşturun:

```sql
CREATE DATABASE "KadinTarim";
```

4. Tabloları oluşturun:

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE urunler (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price NUMERIC(10,2) NOT NULL,
    image_path VARCHAR(255)
);

CREATE TABLE siparisler (
    id SERIAL PRIMARY KEY,
    toplam_tutar NUMERIC(10,2) NOT NULL,
    olusturma_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

5. `uploads` klasörünün yazılabilir olduğundan emin olun (ürün görselleri buraya kaydedilir).

6. Projeyi tarayıcıda açın:

```text
http://localhost/KadinTarimGirisimcilik/login.php
```

veya PHP built-in server ile:

```bash
php -S localhost:8000
```

Sonra: `http://localhost:8000/login.php`

## Sayfalar

| Dosya | Açıklama |
| --- | --- |
| `register.php` | Yeni üye kaydı |
| `login.php` | Giriş |
| `logout.php` | Çıkış |
| `urunler.php` | Ürün listesi ve sepet |
| `urun-ekle.php` | Yeni ürün ekleme |
| `urun-kaydet.php` | Ürün kaydetme işlemi |
| `odeme.php` | Ödeme formu |
| `odeme_islem.php` | Siparişi kaydetme (demo) |
| `db.php` | Veritabanı bağlantısı (yerel, GitHub’da yok) |

## Kullanım

1. `register.php` ile hesap oluşturun.
2. `login.php` ile giriş yapın.
3. `urun-ekle.php` ile ürün ekleyin.
4. `urunler.php` üzerinden sepete ürün ekleyin.
5. Ödeme sayfasından siparişi tamamlayın (demo).

## Notlar

- `index.php` ve `test.html` geliştirme sırasında kullanılan test sayfalarıdır. Uygulamanın asıl giriş noktası `login.php` dosyasıdır.
- Ödeme ekranı eğitim amaçlıdır; gerçek kart işlemi yapılmaz.
- Gerçek veritabanı şifresi `db.php` içindedir ve GitHub’a gönderilmez. Depoda yalnızca `db.example.php` örneği vardır.

## Lisans

Bu proje eğitim amaçlıdır.
