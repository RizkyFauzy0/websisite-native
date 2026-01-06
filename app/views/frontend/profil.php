<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center"><?= htmlspecialchars($page_title) ?></h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="max-w-5xl mx-auto">
        <?php if($profil): ?>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <?php if(!empty($profil->gambar)): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= $profil->gambar ?>" 
                     alt="<?= htmlspecialchars($profil->judul) ?>" 
                     class="w-full h-64 object-cover rounded-lg mb-6">
                <?php endif; ?>
                
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6"><?= htmlspecialchars($profil->judul) ?></h2>
                
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    <?= nl2br(htmlspecialchars($profil->isi_konten)) ?>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <i class="fas fa-info-circle text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Konten belum tersedia</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
