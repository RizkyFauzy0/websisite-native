<?php require_once '../app/views/layouts/admin_header.php'; ?>

<!-- Flash Message -->
<?php $flash = $this->getFlash(); ?>
<?php if($flash): ?>
<div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
    <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>

<!-- Page Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600 mt-2">Selamat datang, <?= $_SESSION['admin_nama'] ?? 'Admin' ?>!</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Berita</p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['berita'] ?></p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-newspaper text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Guru</p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['guru'] ?></p>
            </div>
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['siswa'] ?></p>
            </div>
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Pesan Baru</p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['kontak_baru'] ?></p>
            </div>
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                <i class="fas fa-envelope text-red-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Prestasi</p>
                <p class="text-2xl font-bold text-gray-800 mt-2"><?= $stats['prestasi'] ?></p>
            </div>
            <i class="fas fa-trophy text-yellow-600 text-3xl"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Galeri Foto</p>
                <p class="text-2xl font-bold text-gray-800 mt-2"><?= $stats['galeri_foto'] ?></p>
            </div>
            <i class="fas fa-images text-purple-600 text-3xl"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Galeri Video</p>
                <p class="text-2xl font-bold text-gray-800 mt-2"><?= $stats['galeri_video'] ?></p>
            </div>
            <i class="fas fa-video text-pink-600 text-3xl"></i>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Pengumuman Aktif</p>
                <p class="text-2xl font-bold text-gray-800 mt-2"><?= $stats['pengumuman'] ?></p>
            </div>
            <i class="fas fa-bullhorn text-indigo-600 text-3xl"></i>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Berita -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Berita Terbaru</h2>
        <?php if(!empty($recent_berita)): ?>
        <div class="space-y-3">
            <?php foreach($recent_berita as $berita): ?>
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <i class="fas fa-newspaper text-blue-600 mt-1"></i>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-800"><?= htmlspecialchars(substr($berita->judul, 0, 50)) ?><?= strlen($berita->judul) > 50 ? '...' : '' ?></h3>
                    <p class="text-sm text-gray-500 mt-1"><?= date('d M Y', strtotime($berita->created_at)) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-gray-500">Belum ada berita</p>
        <?php endif; ?>
    </div>
    
    <!-- Recent Kontak -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Pesan Kontak Terbaru</h2>
        <?php if(!empty($recent_kontak)): ?>
        <div class="space-y-3">
            <?php foreach($recent_kontak as $kontak): ?>
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <i class="fas fa-envelope <?= $kontak->status == 'baru' ? 'text-red-600' : 'text-gray-600' ?> mt-1"></i>
                <div class="flex-1">
                    <h3 class="font-medium text-gray-800"><?= htmlspecialchars($kontak->nama) ?></h3>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars(substr($kontak->pesan, 0, 50)) ?><?= strlen($kontak->pesan) > 50 ? '...' : '' ?></p>
                    <p class="text-sm text-gray-500 mt-1"><?= date('d M Y H:i', strtotime($kontak->created_at)) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p class="text-gray-500">Belum ada pesan</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>
