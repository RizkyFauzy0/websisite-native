<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <a href="<?= BASE_URL ?>/berita" class="text-white hover:text-blue-200 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Berita
        </a>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="max-w-4xl mx-auto">
        <article class="bg-white rounded-xl shadow-lg overflow-hidden">
            <?php if(!empty($berita->gambar)): ?>
            <img src="<?= BASE_URL ?>/uploads/<?= $berita->gambar ?>" 
                 alt="<?= htmlspecialchars($berita->judul) ?>" 
                 class="w-full h-96 object-cover">
            <?php endif; ?>
            
            <div class="p-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($berita->judul) ?></h1>
                
                <div class="flex items-center gap-6 text-gray-500 mb-6 pb-6 border-b">
                    <span><i class="far fa-calendar mr-2"></i> <?= date('d M Y', strtotime($berita->tanggal_publish)) ?></span>
                    <span><i class="far fa-user mr-2"></i> <?= htmlspecialchars($berita->penulis ?? 'Admin') ?></span>
                    <span><i class="far fa-eye mr-2"></i> <?= $berita->dibaca ?> kali dibaca</span>
                </div>
                
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <?= nl2br(htmlspecialchars($berita->isi_berita)) ?>
                </div>
            </div>
        </article>
        
        <!-- Related News -->
        <?php if(!empty($relatedBerita)): ?>
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Berita Terkait</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach($relatedBerita as $item): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <?php if(!empty($item->gambar)): ?>
                    <img src="<?= BASE_URL ?>/uploads/<?= $item->gambar ?>" 
                         alt="<?= htmlspecialchars($item->judul) ?>" 
                         class="w-full h-40 object-cover">
                    <?php endif; ?>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-2 line-clamp-2"><?= htmlspecialchars($item->judul) ?></h3>
                        <a href="<?= BASE_URL ?>/berita/detail/<?= $item->slug ?>" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
