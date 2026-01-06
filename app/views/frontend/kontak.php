<?php require_once '../app/views/layouts/header.php'; ?>

<section class="py-8 bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-white text-center">Hubungi Kami</h1>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
            
            <?php $flash = $this->getFlash(); ?>
            <?php if($flash): ?>
            <div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>/kontak/submit" method="POST" class="space-y-4">
                <div>
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email <span class="text-red-500">*</span></label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="subjek" class="block text-gray-700 font-medium mb-2">Subjek</label>
                    <input type="text" 
                           id="subjek" 
                           name="subjek" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="pesan" class="block text-gray-700 font-medium mb-2">Pesan <span class="text-red-500">*</span></label>
                    <textarea id="pesan" 
                              name="pesan" 
                              rows="5" 
                              required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                </button>
            </form>
        </div>
        
        <!-- Contact Info & Map -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-lg">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Alamat</h4>
                            <p class="text-gray-600"><?= $settings->alamat ?? '-' ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-lg">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Telepon</h4>
                            <p class="text-gray-600"><?= $settings->no_telp ?? '-' ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-lg">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Email</h4>
                            <p class="text-gray-600"><?= $settings->email ?? '-' ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-lg">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 mb-1">Website</h4>
                            <p class="text-gray-600"><?= $settings->website ?? '-' ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Map -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <?php if(!empty($settings->koordinat_maps)): ?>
                <iframe src="<?= $settings->koordinat_maps ?>" 
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"></iframe>
                <?php else: ?>
                <div class="h-72 bg-gray-200 flex items-center justify-center">
                    <p class="text-gray-500">Peta belum tersedia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
