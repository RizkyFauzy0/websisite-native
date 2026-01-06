<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center">Download</h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <?php if(!empty($downloads)): ?>
            <div class="space-y-4">
                <?php foreach($downloads as $item): ?>
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition flex items-center gap-6">
                    <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-4 rounded-lg">
                        <i class="fas fa-file-download text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($item->judul) ?></h3>
                        <?php if(!empty($item->deskripsi)): ?>
                        <p class="text-gray-600 mb-2"><?= htmlspecialchars($item->deskripsi) ?></p>
                        <?php endif; ?>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="far fa-calendar mr-1"></i> <?= date('d M Y', strtotime($item->tanggal_upload)) ?></span>
                            <?php if(!empty($item->ukuran_file)): ?>
                            <span><i class="fas fa-hdd mr-1"></i> <?= htmlspecialchars($item->ukuran_file) ?></span>
                            <?php endif; ?>
                            <span><i class="fas fa-download mr-1"></i> <?= $item->jumlah_download ?> downloads</span>
                        </div>
                    </div>
                    <a href="<?= BASE_URL ?>/download/file/<?= $item->id ?>" 
                       class="flex-shrink-0 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                        <i class="fas fa-download mr-2"></i> Download
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-file-download text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada file untuk diunduh</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
