# 🎟️ Tickify - Modern Concert Ticketing System

Tickify adalah platform pemesanan tiket konser berbasis web yang dibangun dengan **Laravel 10** dan **Tailwind CSS**. Aplikasi ini dirancang untuk memberikan pengalaman pembelian tiket yang realistis, aman, dan anti-calo.

![Tickify Dashboard Banner](public/logo.png) 
*(Ganti link di atas dengan screenshot project kamu nanti)*

## 🌟 Fitur Unggulan

### 🛡️ Sistem Keamanan & Anti-Calo
* **Validasi Data Diri:** Mewajibkan input NIK (16 digit), Nama Sesuai KTP, dan No. HP saat checkout.
* **Limit Pembelian:** Algoritma cerdas membatasi maksimal **4 tiket per akun** (gabungan riwayat transaksi & order baru).
* **Real-time Stock:** Mencegah pembelian jika stok tiket habis.

### 💰 Sistem Pembayaran Realistis (Manual Gateway)
* **Rincian Biaya Transparan:** Perhitungan otomatis Harga Tiket + PPN 11% + Biaya Layanan.
* **Alur Pembayaran:** Checkout -> Scan QRIS -> Upload Bukti Transfer -> Verifikasi Admin.
* **E-Ticket:** Tiket hanya terbit setelah pembayaran diverifikasi oleh Admin.

### 👨‍💻 Admin Dashboard
* **Kelola Konser:** Tambah event, set venue, tanggal, dan upload banner.
* **Manajemen Tiket:** Atur kategori tiket (VIP, Festival, Tribune) dan kuota stok.
* **Verifikasi Transaksi:** Panel khusus untuk Validasi/Reject bukti pembayaran user.
* **Laporan:** Ringkasan total pendapatan, tiket terjual, dan venue aktif.

### 🎨 UI/UX Modern
* **Dark Mode Design:** Tampilan elegan dan nyaman di mata (ala Spotify/Netflix).
* **Interactive Carousel:** Banner slide otomatis menggunakan **Alpine.js**.
* **Responsive:** Tampilan optimal di Desktop dan Mobile.

## 🛠️ Teknologi yang Digunakan

* **Backend:** Laravel 10 (PHP 8.2)
* **Frontend:** Blade Templating, Tailwind CSS
* **Database:** MySQL
* **Interactivity:** Alpine.js
* **Authentication:** Laravel Breeze

## 🚀 Cara Install (Localhost)

Ikuti langkah ini untuk menjalankan project di komputer kamu:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username-kamu/tickify-app.git](https://github.com/username-kamu/tickify-app.git)
    cd tickify-app
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Setup Environment**
    Duplikat file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan setting database:
    ```
    DB_DATABASE=tickify_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Generate Key & Migrate**
    ```bash
    php artisan key:generate
    php artisan migrate --seed
    ```

5.  **Link Storage (Penting untuk Gambar)**
    ```bash
    php artisan storage:link
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000` di browser.

## 📸 Screenshots

| Halaman Depan | Detail Konser |
|dev/images/home.png|dev/images/detail.png|
| **Checkout & Validasi** | **Admin Dashboard** |
|dev/images/checkout.png|dev/images/admin.png|

*(Disarankan buat folder `dev/images` lalu masukkan screenshot kamu ke sana biar README-nya ada gambarnya)*

## 📝 License

[MIT](https://choosealicense.com/licenses/mit/)