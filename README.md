# Website Sekolah - PHP Native MVC

Website sekolah modern dan responsive yang dibangun dengan PHP Native menggunakan arsitektur MVC (Model-View-Controller) dan Tailwind CSS.

## 🎯 Fitur Utama

### Frontend (Landing Page)
- ✅ **Hero Slider** - Carousel foto yang berganti otomatis
- ✅ **Sambutan Kepala Sekolah** - Foto dan teks sambutan
- ✅ **Berita Terbaru** - Daftar berita sekolah dengan detail
- ✅ **Pengumuman** - Pengumuman penting sekolah
- ✅ **Statistik Siswa** - Jumlah siswa per tingkat
- ✅ **Profil Guru** - Foto, nama, dan mata pelajaran guru
- ✅ **Kontak & Maps** - Informasi kontak dan Google Maps
- ✅ **Profil Sekolah** - Visi Misi, Sejarah, Struktur Organisasi, Keunggulan
- ✅ **Galeri Foto & Video** - Galeri multimedia sekolah
- ✅ **Prestasi** - Prestasi siswa, guru, dan sekolah
- ✅ **Download** - File yang dapat diunduh
- ✅ **Link Aplikasi** - Link ke aplikasi eksternal

### Backend (Admin Panel)
- ✅ **Dashboard Admin** - Overview statistik website
- ✅ **Manajemen Slider** - CRUD foto slider
- ✅ **Sambutan Kepsek** - CRUD sambutan kepala sekolah
- ✅ **Manajemen Berita** - CRUD berita dengan slug dan views counter
- ✅ **Manajemen Pengumuman** - CRUD pengumuman
- ✅ **Data Siswa** - CRUD statistik siswa per tingkat
- ✅ **Data Guru** - CRUD profil guru
- ✅ **Profil Sekolah** - Kelola Visi Misi, Sejarah, Struktur, Keunggulan
- ✅ **Galeri** - Kelola foto dan video
- ✅ **Prestasi** - Kelola prestasi siswa, guru, sekolah
- ✅ **Download** - CRUD file download
- ✅ **Link Aplikasi** - CRUD link eksternal
- ✅ **Pesan Kontak** - Lihat pesan dari pengunjung
- ✅ **Setting Sekolah** - Logo, nama, alamat, kontak, social media

## 🛠️ Teknologi

- **Backend**: PHP Native (7.4+)
- **Arsitektur**: MVC (Model-View-Controller)
- **Frontend**: Tailwind CSS (via CDN)
- **JavaScript**: Alpine.js untuk interaktivitas
- **Database**: MySQL/MariaDB
- **Icons**: Font Awesome 6
- **URL Rewriting**: Apache .htaccess

## 📋 Requirements

- PHP 7.4 atau lebih tinggi
- MySQL 5.7+ atau MariaDB 10.2+
- Apache Web Server dengan mod_rewrite enabled
- Extension PHP: PDO, pdo_mysql, mbstring, gd

## 📦 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/RizkyFauzy0/websisite-native.git
cd websisite-native
```

### 2. Import Database

1. Buat database baru di MySQL/MariaDB:
   ```sql
   CREATE DATABASE sekolah_db;
   ```

2. Import file SQL:
   ```bash
   mysql -u root -p sekolah_db < sekolah_db.sql
   ```
   
   Atau melalui phpMyAdmin:
   - Buka phpMyAdmin
   - Pilih database `sekolah_db`
   - Klik tab "Import"
   - Pilih file `sekolah_db.sql`
   - Klik "Go"

### 3. Konfigurasi Database

Edit file `config/config.php` dan sesuaikan dengan konfigurasi database Anda:

```php
define('DB_HOST', 'localhost');     // Host database
define('DB_USER', 'root');          // Username database
define('DB_PASS', '');              // Password database
define('DB_NAME', 'sekolah_db');    // Nama database

// Sesuaikan BASE_URL dengan URL website Anda
define('BASE_URL', 'http://localhost/websisite-native/public');
```

### 4. Konfigurasi Apache

Pastikan `mod_rewrite` Apache sudah aktif:

```bash
sudo a2enmod rewrite
sudo service apache2 restart
```

Jika menggunakan XAMPP/WAMP, mod_rewrite biasanya sudah aktif secara default.

### 5. Set Permissions

Berikan permission write pada folder uploads:

```bash
chmod -R 777 public/uploads
```

### 6. Akses Website

- **Frontend**: `http://localhost/websisite-native/public`
- **Admin Panel**: `http://localhost/websisite-native/public/admin/login`

### Kredensial Login Admin Default:
```
Username: admin
Password: admin123
```

**⚠️ PENTING**: Segera ubah password admin setelah login pertama kali!

## 📁 Struktur Folder

```
websisite-native/
├── app/
│   ├── controllers/          # Controllers
│   │   ├── Admin/           # Admin controllers
│   │   └── ...              # Frontend controllers
│   ├── models/              # Models (Database logic)
│   └── views/               # Views (HTML templates)
│       ├── admin/           # Admin views
│       ├── frontend/        # Frontend views
│       └── layouts/         # Layout templates
├── config/
│   └── config.php           # Konfigurasi aplikasi
├── core/
│   ├── App.php              # Routing handler
│   ├── Controller.php       # Base controller
│   └── Database.php         # Database connection
├── public/                  # Public accessible folder
│   ├── uploads/             # Upload files
│   ├── .htaccess           # URL rewriting rules
│   └── index.php           # Entry point
├── .gitignore
├── .htaccess                # Root htaccess
├── README.md
└── sekolah_db.sql          # Database schema
```

## 🎨 Fitur Design

### Responsive Design
- ✅ Mobile-first approach
- ✅ Hamburger menu untuk mobile
- ✅ Grid system responsive
- ✅ Optimized untuk berbagai ukuran layar

### Modern UI/UX
- ✅ Tailwind CSS framework
- ✅ Smooth animations dan transitions
- ✅ Card-based layout
- ✅ Interactive hover effects
- ✅ Clean dan modern interface

### Frontend Features
- ✅ Auto-playing slider with controls
- ✅ Dropdown navigation menus
- ✅ Pagination untuk list
- ✅ Image modal lightbox
- ✅ YouTube video embed
- ✅ Google Maps integration
- ✅ Contact form validation

### Admin Panel Features
- ✅ Sidebar navigation
- ✅ Statistics dashboard
- ✅ Modal popup untuk CRUD (recommended to implement)
- ✅ File upload system
- ✅ Session-based authentication
- ✅ Flash messages
- ✅ Responsive admin layout

## 🔧 Penggunaan

### Mengelola Konten

#### 1. Slider
- Masuk ke Admin Panel > Slider
- Upload gambar slider (JPG, PNG, GIF, max 5MB)
- Tambahkan judul dan deskripsi (opsional)
- Atur urutan tampilan
- Set status aktif/nonaktif

#### 2. Berita
- Admin Panel > Berita
- Tambah berita baru dengan judul, konten, dan gambar
- Slug akan dibuat otomatis dari judul
- Set status publish/draft
- Berita published akan muncul di frontend

#### 3. Galeri
- **Foto**: Upload foto dengan judul dan deskripsi
- **Video**: Tambahkan URL YouTube video

#### 4. Setting Sekolah
- Admin Panel > Setting
- Upload logo sekolah
- Isi informasi kontak (alamat, telp, email)
- Tambahkan koordinat Google Maps
- Atur link social media

### Upload Files

Sistem mendukung upload untuk:
- **Gambar**: JPG, JPEG, PNG, GIF (max 5MB)
- **Dokumen**: PDF, DOC, DOCX, XLS, XLSX (untuk download)

File akan disimpan di folder `public/uploads/` dengan nama unik (timestamp).

## 🔒 Keamanan

- ✅ Password hashing dengan `password_hash()`
- ✅ Session-based authentication
- ✅ SQL injection prevention dengan PDO prepared statements
- ✅ XSS protection dengan `htmlspecialchars()`
- ✅ File upload validation
- ✅ CSRF protection (recommended to add)

## 🚀 Pengembangan Lanjutan

### Rekomendasi Fitur Tambahan:
1. **CRUD dengan Modal Popup** - Implementasi lengkap modal untuk semua operasi CRUD
2. **WYSIWYG Editor** - TinyMCE atau CKEditor untuk konten
3. **Image Cropper** - Crop dan resize gambar saat upload
4. **Multi-language** - Support bahasa Indonesia dan Inggris
5. **SEO Optimization** - Meta tags, sitemap, robots.txt
6. **Analytics** - Integration dengan Google Analytics
7. **Cache System** - Untuk performa lebih baik
8. **API REST** - Untuk integrasi dengan aplikasi lain
9. **Dark Mode** - Theme switcher
10. **Email Notifications** - Notifikasi email untuk kontak baru

### Cara Menambah Module CRUD Baru:

1. **Buat Model** di `app/models/`
2. **Buat Controller** di `app/controllers/Admin/`
3. **Buat View** di `app/views/admin/`
4. **Tambah Menu** di `app/views/layouts/admin_header.php`

## 📝 Database Schema

Database memiliki 14 tabel utama:
- `users` - Admin users
- `settings` - Pengaturan sekolah
- `sliders` - Hero slider
- `sambutan` - Sambutan kepala sekolah
- `berita` - Berita sekolah
- `pengumuman` - Pengumuman
- `siswa_stats` - Statistik siswa
- `guru` - Data guru
- `profil` - Profil sekolah (visi misi, sejarah, dll)
- `galeri_foto` - Galeri foto
- `galeri_video` - Galeri video
- `prestasi` - Prestasi
- `downloads` - File download
- `link_aplikasi` - Link aplikasi eksternal
- `kontak` - Pesan kontak dari pengunjung

## 🐛 Troubleshooting

### Error: "Page Not Found" atau halaman tidak redirect dengan benar
- Pastikan `mod_rewrite` Apache aktif
- Periksa file `.htaccess` ada di root dan folder `public/`
- Sesuaikan `BASE_URL` di `config/config.php`

### Error: Database Connection Failed
- Periksa kredensial database di `config/config.php`
- Pastikan MySQL service berjalan
- Cek apakah database sudah dibuat dan diimport

### Error: Upload File Gagal
- Periksa permission folder `public/uploads/` (harus writable)
- Cek ukuran file tidak melebihi limit (5MB)
- Pastikan ekstensi file diizinkan

### Gambar tidak muncul
- Periksa path upload folder sudah benar
- Cek permission folder uploads
- Pastikan `BASE_URL` sudah benar

## 📄 License

This project is open-source and available under the MIT License.

## 👨‍💻 Developer

Developed by RizkyFauzy0

## 📞 Support

Jika ada pertanyaan atau menemukan bug, silakan buat issue di repository ini.

---

**Selamat menggunakan! 🎉**