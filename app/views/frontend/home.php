<?php require_once '../app/views/layouts/header.php'; ?>

<!-- Hero Slider Section -->
<section class="relative">
    <div class="overflow-hidden" x-data="slider()">
        <!-- Slides -->
        <div class="relative h-[400px] md:h-[500px] lg:h-[600px]">
            <?php if(!empty($sliders)): ?>
                <?php foreach($sliders as $index => $slider): ?>
                <div x-show="currentSlide === <?= $index ?>" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-500"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-full"
                     class="absolute inset-0">
                    <img src="<?= BASE_URL ?>/uploads/sliders/<?= $slider->gambar ?>" 
                         alt="<?= htmlspecialchars($slider->judul ?? '') ?>" 
                         class="w-full h-full object-cover">
                    <?php if(!empty($slider->judul) || !empty($slider->deskripsi)): ?>
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <?php if(!empty($slider->judul)): ?>
                            <h2 class="text-3xl md:text-5xl font-bold mb-4"><?= htmlspecialchars($slider->judul) ?></h2>
                            <?php endif; ?>
                            <?php if(!empty($slider->deskripsi)): ?>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto"><?= htmlspecialchars($slider->deskripsi) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-center">
                    <div class="text-center text-white px-4">
                        <h2 class="text-3xl md:text-5xl font-bold mb-4">Selamat Datang</h2>
                        <p class="text-lg md:text-xl">di <?= htmlspecialchars($settings->nama_sekolah ?? 'School') ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Navigation Buttons -->
        <?php if(count($sliders) > 1): ?>
        <button @click="previousSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 p-3 rounded-full transition">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button @click="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white bg-opacity-50 hover:bg-opacity-75 text-gray-800 p-3 rounded-full transition">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
            <?php foreach($sliders as $index => $slider): ?>
            <button @click="currentSlide = <?= $index ?>" 
                    :class="currentSlide === <?= $index ?> ? 'bg-white' : 'bg-white bg-opacity-50'"
                    class="w-3 h-3 rounded-full transition"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Sambutan Kepala Sekolah -->
<?php if($sambutan): ?>
<section class="container mx-auto px-4 py-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Sambutan Kepala Sekolah</h2>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden md:flex">
            <?php if(!empty($sambutan->foto)): ?>
            <div class="md:w-1/3">
                <img src="<?= BASE_URL ?>/uploads/<?= $sambutan->foto ?>" 
                     alt="<?= htmlspecialchars($sambutan->nama_kepsek) ?>" 
                     class="w-full h-64 md:h-full object-cover">
            </div>
            <?php endif; ?>
            <div class="p-8 <?= !empty($sambutan->foto) ? 'md:w-2/3' : 'w-full' ?>">
                <h3 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($sambutan->nama_kepsek) ?></h3>
                <p class="text-blue-600 mb-4"><?= htmlspecialchars($sambutan->jabatan) ?></p>
                <div class="text-gray-600 leading-relaxed">
                    <?= nl2br(htmlspecialchars($sambutan->isi_sambutan)) ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Berita Terbaru -->
<?php if(!empty($berita)): ?>
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Berita Terbaru</h2>
            <a href="<?= BASE_URL ?>/berita" class="text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($berita as $item): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                <?php if(!empty($item->gambar)): ?>
                <img src="<?= BASE_URL ?>/uploads/<?= $item->gambar ?>" 
                     alt="<?= htmlspecialchars($item->judul) ?>" 
                     class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-6">
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                        <span><i class="far fa-calendar mr-1"></i> <?= date('d M Y', strtotime($item->tanggal_publish)) ?></span>
                        <span><i class="far fa-eye mr-1"></i> <?= $item->dibaca ?></span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2"><?= htmlspecialchars($item->judul) ?></h3>
                    <p class="text-gray-600 mb-4 line-clamp-3"><?= htmlspecialchars(substr(strip_tags($item->isi_berita), 0, 150)) ?>...</p>
                    <a href="<?= BASE_URL ?>/berita/detail/<?= $item->slug ?>" class="text-blue-600 hover:text-blue-700 font-medium">
                        Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Pengumuman -->
<?php if(!empty($pengumuman)): ?>
<section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Pengumuman</h2>
    <div class="max-w-4xl mx-auto space-y-4">
        <?php foreach($pengumuman as $item): ?>
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fas fa-bullhorn text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($item->judul) ?></h3>
                    <p class="text-gray-600 mb-2"><?= nl2br(htmlspecialchars($item->isi_pengumuman)) ?></p>
                    <p class="text-sm text-gray-500">
                        <i class="far fa-calendar mr-1"></i> 
                        <?= date('d M Y', strtotime($item->tanggal_mulai)) ?>
                        <?php if($item->tanggal_selesai): ?>
                        - <?= date('d M Y', strtotime($item->tanggal_selesai)) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Statistik Siswa -->
<?php if(!empty($siswa_stats)): ?>
<section class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-white">Jumlah Siswa</h2>
        <div class="grid grid-cols-2 md:grid-cols-<?= min(count($siswa_stats), 4) ?> gap-6">
            <?php foreach($siswa_stats as $stat): ?>
            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-lg p-6 text-center text-white hover:bg-opacity-20 transition">
                <div class="text-4xl md:text-5xl font-bold mb-2"><?= $stat->jumlah_siswa ?></div>
                <div class="text-lg"><?= htmlspecialchars($stat->tingkat) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Profil Guru -->
<?php if(!empty($guru)): ?>
<section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Tenaga Pendidik</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach($guru as $item): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="aspect-square bg-gray-200">
                <?php if(!empty($item->foto)): ?>
                <img src="<?= BASE_URL ?>/uploads/guru/<?= $item->foto ?>" 
                     alt="<?= htmlspecialchars($item->nama_guru) ?>" 
                     class="w-full h-full object-cover">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <i class="fas fa-user text-6xl"></i>
                </div>
                <?php endif; ?>
            </div>
            <div class="p-4 text-center">
                <h3 class="font-bold text-gray-800 mb-1"><?= htmlspecialchars($item->nama_guru) ?></h3>
                <?php if(!empty($item->mata_pelajaran)): ?>
                <p class="text-sm text-blue-600"><?= htmlspecialchars($item->mata_pelajaran) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Kontak & Maps -->
<section class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-800">Lokasi & Kontak</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Map -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <?php if(!empty($settings->koordinat_maps)): ?>
                <iframe src="<?= $settings->koordinat_maps ?>" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"></iframe>
                <?php else: ?>
                <div class="h-96 bg-gray-200 flex items-center justify-center">
                    <p class="text-gray-500">Peta belum tersedia</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Hubungi Kami</h3>
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
        </div>
    </div>
</section>

<script>
    function slider() {
        return {
            currentSlide: 0,
            totalSlides: <?= count($sliders) ?>,
            autoplay: null,
            
            init() {
                if (this.totalSlides > 1) {
                    this.startAutoplay();
                }
            },
            
            startAutoplay() {
                this.autoplay = setInterval(() => {
                    this.nextSlide();
                }, 5000);
            },
            
            stopAutoplay() {
                if (this.autoplay) {
                    clearInterval(this.autoplay);
                }
            },
            
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            
            previousSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            }
        }
    }
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
