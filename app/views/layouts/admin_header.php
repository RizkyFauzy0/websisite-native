<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-gray-800 text-white transform lg:translate-x-0 transition-transform duration-300 z-30"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <h2 class="text-xl font-bold">Admin Panel</h2>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-5rem)]">
            <a href="<?= BASE_URL ?>/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'dashboard' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/slider" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'slider' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-images"></i>
                <span>Slider</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/sambutan" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'sambutan' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-user-tie"></i>
                <span>Sambutan Kepsek</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/berita" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'berita' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-newspaper"></i>
                <span>Berita</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/pengumuman" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'pengumuman' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-bullhorn"></i>
                <span>Pengumuman</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/siswa" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'siswa' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-users"></i>
                <span>Data Siswa</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/guru" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'guru' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Data Guru</span>
            </a>
            
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-building"></i>
                        <span>Profil Sekolah</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-cloak class="ml-8 mt-2 space-y-2">
                    <a href="<?= BASE_URL ?>/admin/profil/visi-misi" class="block px-4 py-2 rounded hover:bg-gray-700">Visi Misi</a>
                    <a href="<?= BASE_URL ?>/admin/profil/sejarah" class="block px-4 py-2 rounded hover:bg-gray-700">Sejarah</a>
                    <a href="<?= BASE_URL ?>/admin/profil/struktur-organisasi" class="block px-4 py-2 rounded hover:bg-gray-700">Struktur Organisasi</a>
                    <a href="<?= BASE_URL ?>/admin/profil/keunggulan" class="block px-4 py-2 rounded hover:bg-gray-700">Keunggulan</a>
                </div>
            </div>
            
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-photo-video"></i>
                        <span>Galeri</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-cloak class="ml-8 mt-2 space-y-2">
                    <a href="<?= BASE_URL ?>/admin/galeri-foto" class="block px-4 py-2 rounded hover:bg-gray-700">Galeri Foto</a>
                    <a href="<?= BASE_URL ?>/admin/galeri-video" class="block px-4 py-2 rounded hover:bg-gray-700">Galeri Video</a>
                </div>
            </div>
            
            <div x-data="{ open: false }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-trophy"></i>
                        <span>Prestasi</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm" :class="open ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open" x-cloak class="ml-8 mt-2 space-y-2">
                    <a href="<?= BASE_URL ?>/admin/prestasi-siswa" class="block px-4 py-2 rounded hover:bg-gray-700">Prestasi Siswa</a>
                    <a href="<?= BASE_URL ?>/admin/prestasi-guru" class="block px-4 py-2 rounded hover:bg-gray-700">Prestasi Guru</a>
                    <a href="<?= BASE_URL ?>/admin/prestasi-sekolah" class="block px-4 py-2 rounded hover:bg-gray-700">Prestasi Sekolah</a>
                </div>
            </div>
            
            <a href="<?= BASE_URL ?>/admin/download" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'download' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-download"></i>
                <span>Download</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/link-aplikasi" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'link-aplikasi' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-link"></i>
                <span>Link Aplikasi</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/kontak" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'kontak' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-envelope"></i>
                <span>Pesan Kontak</span>
            </a>
            
            <a href="<?= BASE_URL ?>/admin/setting" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-700 transition <?= isset($active_menu) && $active_menu == 'setting' ? 'bg-gray-700' : '' ?>">
                <i class="fas fa-cog"></i>
                <span>Setting</span>
            </a>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 py-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex-1 lg:flex-initial"></div>
                
                <div class="flex items-center gap-4">
                    <a href="<?= BASE_URL ?>" target="_blank" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-globe mr-2"></i>
                        <span class="hidden sm:inline">Lihat Website</span>
                    </a>
                    
                    <div class="border-l pl-4">
                        <span class="text-gray-600 mr-3"><?= $_SESSION['admin_nama'] ?? 'Admin' ?></span>
                        <a href="<?= BASE_URL ?>/admin/login/logout" class="text-red-600 hover:text-red-700">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="p-6">
