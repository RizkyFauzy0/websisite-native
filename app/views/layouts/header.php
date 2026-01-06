<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?> - <?= $settings->nama_sekolah ?? 'School Website' ?></title>
    <meta name="description" content="Website resmi <?= $settings->nama_sekolah ?? 'School' ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4">
            <!-- Top bar with contact info -->
            <div class="hidden md:flex justify-between items-center py-2 text-sm border-b">
                <div class="flex items-center gap-4 text-gray-600">
                    <a href="tel:<?= $settings->no_telp ?? '' ?>" class="hover:text-blue-600">
                        <i class="fas fa-phone"></i> <?= $settings->no_telp ?? '' ?>
                    </a>
                    <a href="mailto:<?= $settings->email ?? '' ?>" class="hover:text-blue-600">
                        <i class="fas fa-envelope"></i> <?= $settings->email ?? '' ?>
                    </a>
                </div>
                <div class="flex gap-3">
                    <?php if(!empty($settings->facebook)): ?>
                    <a href="<?= $settings->facebook ?>" target="_blank" class="text-gray-600 hover:text-blue-600">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($settings->instagram)): ?>
                    <a href="<?= $settings->instagram ?>" target="_blank" class="text-gray-600 hover:text-pink-600">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <?php endif; ?>
                    <?php if(!empty($settings->youtube)): ?>
                    <a href="<?= $settings->youtube ?>" target="_blank" class="text-gray-600 hover:text-red-600">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Main navigation -->
            <nav class="flex items-center justify-between py-4">
                <!-- Logo -->
                <a href="<?= BASE_URL ?>" class="flex items-center gap-3">
                    <?php if(!empty($settings->logo)): ?>
                    <img src="<?= BASE_URL ?>/uploads/logo/<?= $settings->logo ?>" alt="Logo" class="h-12 w-12 object-contain">
                    <?php endif; ?>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800"><?= $settings->nama_sekolah ?? 'School' ?></h1>
                        <p class="text-xs text-gray-600">Website Resmi</p>
                    </div>
                </a>
                
                <!-- Desktop menu -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="<?= BASE_URL ?>" class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                    
                    <!-- Profil dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-1">
                            Profil <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2">
                            <a href="<?= BASE_URL ?>/profil/visi-misi" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Visi Misi</a>
                            <a href="<?= BASE_URL ?>/profil/sejarah" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Sejarah Singkat</a>
                            <a href="<?= BASE_URL ?>/profil/struktur-organisasi" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Struktur Organisasi</a>
                            <a href="<?= BASE_URL ?>/profil/keunggulan" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Keunggulan</a>
                        </div>
                    </div>
                    
                    <a href="<?= BASE_URL ?>/berita" class="text-gray-700 hover:text-blue-600 font-medium">Berita</a>
                    
                    <!-- Galeri dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-1">
                            Galeri <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2">
                            <a href="<?= BASE_URL ?>/galeri/foto" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Foto</a>
                            <a href="<?= BASE_URL ?>/galeri/video" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Video</a>
                        </div>
                    </div>
                    
                    <!-- Prestasi dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-1">
                            Prestasi <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" x-cloak class="absolute top-full left-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2">
                            <a href="<?= BASE_URL ?>/prestasi/siswa" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Prestasi Siswa</a>
                            <a href="<?= BASE_URL ?>/prestasi/guru" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Prestasi Guru</a>
                            <a href="<?= BASE_URL ?>/prestasi/sekolah" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600">Prestasi Sekolah</a>
                        </div>
                    </div>
                    
                    <a href="<?= BASE_URL ?>/download" class="text-gray-700 hover:text-blue-600 font-medium">Download</a>
                    <a href="<?= BASE_URL ?>/link-aplikasi" class="text-gray-700 hover:text-blue-600 font-medium">Link Aplikasi</a>
                    <a href="<?= BASE_URL ?>/kontak" class="text-gray-700 hover:text-blue-600 font-medium">Kontak</a>
                </div>
                
                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700 text-2xl">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </nav>
        </div>
        
        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden bg-white border-t" x-data="{ profilOpen: false, galeriOpen: false, prestasiOpen: false }">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="<?= BASE_URL ?>" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                
                <!-- Profil mobile -->
                <div>
                    <button @click="profilOpen = !profilOpen" class="w-full text-left py-2 text-gray-700 hover:text-blue-600 font-medium flex items-center justify-between">
                        Profil <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="profilOpen" x-cloak class="pl-4 space-y-1">
                        <a href="<?= BASE_URL ?>/profil/visi-misi" class="block py-2 text-gray-600 hover:text-blue-600">Visi Misi</a>
                        <a href="<?= BASE_URL ?>/profil/sejarah" class="block py-2 text-gray-600 hover:text-blue-600">Sejarah Singkat</a>
                        <a href="<?= BASE_URL ?>/profil/struktur-organisasi" class="block py-2 text-gray-600 hover:text-blue-600">Struktur Organisasi</a>
                        <a href="<?= BASE_URL ?>/profil/keunggulan" class="block py-2 text-gray-600 hover:text-blue-600">Keunggulan</a>
                    </div>
                </div>
                
                <a href="<?= BASE_URL ?>/berita" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Berita</a>
                
                <!-- Galeri mobile -->
                <div>
                    <button @click="galeriOpen = !galeriOpen" class="w-full text-left py-2 text-gray-700 hover:text-blue-600 font-medium flex items-center justify-between">
                        Galeri <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="galeriOpen" x-cloak class="pl-4 space-y-1">
                        <a href="<?= BASE_URL ?>/galeri/foto" class="block py-2 text-gray-600 hover:text-blue-600">Foto</a>
                        <a href="<?= BASE_URL ?>/galeri/video" class="block py-2 text-gray-600 hover:text-blue-600">Video</a>
                    </div>
                </div>
                
                <!-- Prestasi mobile -->
                <div>
                    <button @click="prestasiOpen = !prestasiOpen" class="w-full text-left py-2 text-gray-700 hover:text-blue-600 font-medium flex items-center justify-between">
                        Prestasi <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="prestasiOpen" x-cloak class="pl-4 space-y-1">
                        <a href="<?= BASE_URL ?>/prestasi/siswa" class="block py-2 text-gray-600 hover:text-blue-600">Prestasi Siswa</a>
                        <a href="<?= BASE_URL ?>/prestasi/guru" class="block py-2 text-gray-600 hover:text-blue-600">Prestasi Guru</a>
                        <a href="<?= BASE_URL ?>/prestasi/sekolah" class="block py-2 text-gray-600 hover:text-blue-600">Prestasi Sekolah</a>
                    </div>
                </div>
                
                <a href="<?= BASE_URL ?>/download" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Download</a>
                <a href="<?= BASE_URL ?>/link-aplikasi" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Link Aplikasi</a>
                <a href="<?= BASE_URL ?>/kontak" class="block py-2 text-gray-700 hover:text-blue-600 font-medium">Kontak</a>
            </div>
        </div>
    </header>
    
    <!-- Main content -->
    <main>
