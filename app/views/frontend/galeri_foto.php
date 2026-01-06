<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center">Galeri Foto</h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <?php if(!empty($foto)): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-12">
            <?php foreach($foto as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 cursor-pointer"
                 onclick="openImageModal('<?= BASE_URL ?>/uploads/galeri/<?= $item->gambar ?>', '<?= htmlspecialchars($item->judul) ?>', '<?= htmlspecialchars($item->deskripsi ?? '') ?>')">
                <div class="aspect-square bg-gray-200">
                    <img src="<?= BASE_URL ?>/uploads/galeri/<?= $item->gambar ?>" 
                         alt="<?= htmlspecialchars($item->judul) ?>" 
                         class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 line-clamp-1"><?= htmlspecialchars($item->judul) ?></h3>
                    <p class="text-sm text-gray-500 mt-1">
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
            <a href="<?= BASE_URL ?>/galeri/foto/<?= $currentPage - 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-left"></i>
            </a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <?php if($i == $currentPage): ?>
                <span class="px-4 py-2 bg-blue-600 text-white rounded"><?= $i ?></span>
                <?php else: ?>
                <a href="<?= BASE_URL ?>/galeri/foto/<?= $i ?>" 
                   class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if($currentPage < $totalPages): ?>
            <a href="<?= BASE_URL ?>/galeri/foto/<?= $currentPage + 1 ?>" 
               class="px-4 py-2 bg-white border border-gray-300 rounded hover:bg-gray-50 transition">
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada foto</p>
        </div>
    <?php endif; ?>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
    <div class="max-w-4xl w-full bg-white rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800"></h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="" class="w-full h-auto">
            <p id="modalDescription" class="text-gray-600 mt-4"></p>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc, title, description) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

// Close modal on outside click
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
