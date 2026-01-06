<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center">Galeri Video</h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <?php if(!empty($video)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php foreach($video as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="aspect-video bg-gray-200">
                    <?php
                    // Extract YouTube video ID
                    $videoUrl = $item->url_video;
                    $videoId = '';
                    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $videoUrl, $id)) {
                        $videoId = $id[1];
                    } elseif (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $videoUrl, $id)) {
                        $videoId = $id[1];
                    } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $videoUrl, $id)) {
                        $videoId = $id[1];
                    }
                    ?>
                    <?php if($videoId): ?>
                    <iframe class="w-full h-full" 
                            src="https://www.youtube.com/embed/<?= $videoId ?>" 
                            title="<?= htmlspecialchars($item->judul) ?>" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-video text-gray-400 text-6xl"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-2"><?= htmlspecialchars($item->judul) ?></h3>
                    <?php if(!empty($item->deskripsi)): ?>
                    <p class="text-sm text-gray-600 mb-2 line-clamp-2"><?= htmlspecialchars($item->deskripsi) ?></p>
                    <?php endif; ?>
                    <p class="text-sm text-gray-500">
                        <i class="far fa-calendar mr-1"></i> <?= date('d M Y', strtotime($item->tanggal_upload)) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($totalPages > 1): ?>
        <div class="flex justify-center gap-2">
            <?php if($currentPage > 1): ?>
            <a href="<?= BASE_URL ?>/galeri/video/<?= $currentPage - 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-left"></i>
            </a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <?php if($i == $currentPage): ?>
                <span class="px-4 py-2 bg-blue-600 text-white rounded"><?= $i ?></span>
                <?php else: ?>
                <a href="<?= BASE_URL ?>/galeri/video/<?= $i ?>" 
                   class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if($currentPage < $totalPages): ?>
            <a href="<?= BASE_URL ?>/galeri/video/<?= $currentPage + 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-video text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada video</p>
        </div>
    <?php endif; ?>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
