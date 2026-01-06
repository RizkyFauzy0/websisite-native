<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center"><?= htmlspecialchars($page_title) ?></h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <?php if(!empty($prestasi)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach($prestasi as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <?php if(!empty($item->gambar)): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= $item->gambar ?>" 
                     alt="<?= htmlspecialchars($item->judul) ?>" 
                     class="w-full h-48 object-cover">
                <?php else: ?>
                <div class="w-full h-48 bg-gradient-to-r from-yellow-400 to-yellow-600 flex items-center justify-center">
                    <i class="fas fa-trophy text-white text-6xl"></i>
                </div>
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                            <?= htmlspecialchars($item->tingkat ?? 'Umum') ?>
                        </span>
                        <span class="text-sm text-gray-500"><?= htmlspecialchars($item->tahun ?? '') ?></span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($item->judul) ?></h3>
                    <?php if(!empty($item->deskripsi)): ?>
                    <p class="text-gray-600"><?= nl2br(htmlspecialchars($item->deskripsi)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
        <div class="flex justify-center gap-2">
            <?php if($currentPage > 1): ?>
            <a href="<?= BASE_URL ?>/prestasi/<?= $jenis ?>/<?= $currentPage - 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-left"></i>
            </a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <?php if($i == $currentPage): ?>
                <span class="px-4 py-2 bg-blue-600 text-white rounded"><?= $i ?></span>
                <?php else: ?>
                <a href="<?= BASE_URL ?>/prestasi/<?= $jenis ?>/<?= $i ?>" 
                   class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if($currentPage < $totalPages): ?>
            <a href="<?= BASE_URL ?>/prestasi/<?= $jenis ?>/<?= $currentPage + 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada prestasi</p>
        </div>
    <?php endif; ?>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
