-- Database Schema for School Website
-- Create database
CREATE DATABASE IF NOT EXISTS sekolah_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sekolah_db;

-- Table: users (Admin users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin (password: admin123)
INSERT INTO users (username, password, nama_lengkap, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@sekolah.com');

-- Table: settings (School settings)
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_sekolah VARCHAR(200) NOT NULL,
    logo VARCHAR(255),
    alamat TEXT,
    no_telp VARCHAR(20),
    email VARCHAR(100),
    website VARCHAR(100),
    koordinat_maps TEXT,
    facebook VARCHAR(200),
    instagram VARCHAR(200),
    youtube VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings
INSERT INTO settings (nama_sekolah, alamat, no_telp, email, website) VALUES
('SMP Negeri 1 Contoh', 'Jl. Pendidikan No. 123, Jakarta', '021-1234567', 'info@smpn1contoh.sch.id', 'www.smpn1contoh.sch.id');

-- Table: sliders (Hero slider)
CREATE TABLE sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200),
    deskripsi TEXT,
    gambar VARCHAR(255) NOT NULL,
    urutan INT DEFAULT 0,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: sambutan (Sambutan Kepala Sekolah)
CREATE TABLE sambutan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kepsek VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) DEFAULT 'Kepala Sekolah',
    foto VARCHAR(255),
    isi_sambutan TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: berita (School news)
CREATE TABLE berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    isi_berita TEXT NOT NULL,
    gambar VARCHAR(255),
    penulis VARCHAR(100),
    tanggal_publish DATE NOT NULL,
    dibaca INT DEFAULT 0,
    status ENUM('publish', 'draft') DEFAULT 'publish',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: pengumuman (Announcements)
CREATE TABLE pengumuman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    isi_pengumuman TEXT NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: siswa_stats (Student statistics by grade)
CREATE TABLE siswa_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tingkat VARCHAR(50) NOT NULL,
    jumlah_siswa INT NOT NULL DEFAULT 0,
    tahun_ajaran VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: guru (Teacher profiles)
CREATE TABLE guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_guru VARCHAR(100) NOT NULL,
    nip VARCHAR(30),
    foto VARCHAR(255),
    mata_pelajaran VARCHAR(100),
    pendidikan VARCHAR(100),
    email VARCHAR(100),
    no_telp VARCHAR(20),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: profil (School profile content)
CREATE TABLE profil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis ENUM('visi_misi', 'sejarah', 'struktur_organisasi', 'keunggulan') NOT NULL,
    judul VARCHAR(200) NOT NULL,
    isi_konten TEXT NOT NULL,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_jenis (jenis)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: galeri_foto (Photo gallery)
CREATE TABLE galeri_foto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) NOT NULL,
    tanggal_upload DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: galeri_video (Video gallery)
CREATE TABLE galeri_video (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    url_video VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255),
    tanggal_upload DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: prestasi (Achievements)
CREATE TABLE prestasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jenis ENUM('siswa', 'guru', 'sekolah') NOT NULL,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    tingkat VARCHAR(50),
    tahun VARCHAR(10),
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: downloads (Downloadable files)
CREATE TABLE downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    nama_file VARCHAR(255) NOT NULL,
    ukuran_file VARCHAR(20),
    jumlah_download INT DEFAULT 0,
    tanggal_upload DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: link_aplikasi (External links)
CREATE TABLE link_aplikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_aplikasi VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    url VARCHAR(255) NOT NULL,
    icon VARCHAR(255),
    urutan INT DEFAULT 0,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: kontak (Contact messages from visitors)
CREATE TABLE kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subjek VARCHAR(200),
    pesan TEXT NOT NULL,
    status ENUM('baru', 'dibaca', 'dibalas') DEFAULT 'baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
