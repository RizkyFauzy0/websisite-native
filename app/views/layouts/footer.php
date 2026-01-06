    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Tentang Kami</h3>
                    <p class="text-gray-300 mb-4"><?= $settings->nama_sekolah ?? 'School' ?></p>
                    <p class="text-gray-400 text-sm"><?= $settings->alamat ?? '' ?></p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Link Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="<?= BASE_URL ?>/profil/visi-misi" class="text-gray-300 hover:text-white">Visi Misi</a></li>
                        <li><a href="<?= BASE_URL ?>/berita" class="text-gray-300 hover:text-white">Berita</a></li>
                        <li><a href="<?= BASE_URL ?>/galeri/foto" class="text-gray-300 hover:text-white">Galeri</a></li>
                        <li><a href="<?= BASE_URL ?>/kontak" class="text-gray-300 hover:text-white">Kontak</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><i class="fas fa-phone mr-2"></i> <?= $settings->no_telp ?? '' ?></li>
                        <li><i class="fas fa-envelope mr-2"></i> <?= $settings->email ?? '' ?></li>
                        <li><i class="fas fa-globe mr-2"></i> <?= $settings->website ?? '' ?></li>
                    </ul>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Media Sosial</h3>
                    <div class="flex gap-4">
                        <?php if(!empty($settings->facebook)): ?>
                        <a href="<?= $settings->facebook ?>" target="_blank" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($settings->instagram)): ?>
                        <a href="<?= $settings->instagram ?>" target="_blank" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(!empty($settings->youtube)): ?>
                        <a href="<?= $settings->youtube ?>" target="_blank" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="bg-gray-900 py-4">
            <div class="container mx-auto px-4 text-center text-gray-400 text-sm">
                <p>&copy; <?= date('Y') ?> <?= $settings->nama_sekolah ?? 'School' ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Custom JavaScript -->
    <script>
        // Auto-close flash messages
        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>
