<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center">Link Aplikasi</h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="max-w-5xl mx-auto">
        <?php if(!empty($links)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($links as $item): ?>
                <a href="<?= htmlspecialchars($item->url) ?>" 
                   target="_blank"
                   class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1 text-center">
                    <?php if(!empty($item->icon)): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= $item->icon ?>" 
                         alt="<?= htmlspecialchars($item->nama_aplikasi) ?>" 
                         class="w-20 h-20 mx-auto mb-4 object-contain">
                    <?php else: ?>
                    <div class="w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-link text-blue-600 text-3xl"></i>
                    </div>
                    <?php endif; ?>
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($item->nama_aplikasi) ?></h3>
                    <?php if(!empty($item->deskripsi)): ?>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($item->deskripsi) ?></p>
                    <?php endif; ?>
                    <div class="mt-4 text-blue-600 font-medium">
                        Buka Aplikasi <i class="fas fa-external-link-alt ml-1"></i>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-link text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada link aplikasi</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
