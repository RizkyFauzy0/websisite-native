<?php require_once '../app/views/layouts/admin_header.php'; ?>

<!-- Flash Message -->
<?php $flash = $this->getFlash(); ?>
<?php if($flash): ?>
<div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
    <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i>
    <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>

<!-- Page Header -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Slider</h1>
        <p class="text-gray-600 mt-2">Kelola slider gambar pada halaman utama website</p>
    </div>
    <button onclick="openModal('createModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah Slider
    </button>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(!empty($sliders)): ?>
                    <?php foreach($sliders as $index => $slider): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if(!empty($slider->gambar)): ?>
                                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($slider->gambar) ?>" alt="Slider" class="h-16 w-24 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">No image</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?= htmlspecialchars($slider->judul) ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars(substr($slider->deskripsi, 0, 50)) ?><?= strlen($slider->deskripsi) > 50 ? '...' : '' ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $slider->urutan ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full <?= $slider->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= ucfirst($slider->status) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick='openEditModal(<?= json_encode($slider) ?>)' class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="confirmDelete(<?= $slider->id ?>, '<?= htmlspecialchars($slider->judul) ?>', '<?= BASE_URL ?>/admin/slider/delete/<?= $slider->id ?>')" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data slider</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Tambah Slider Baru</h3>
            <button onclick="closeModal('createModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?= BASE_URL ?>/admin/slider/store" method="POST" enctype="multipart/form-data">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar * (Max 5MB)</label>
                    <input type="file" name="gambar" accept="image/*" required onchange="previewImage(this, 'createImagePreview')" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <img id="createImagePreview" class="mt-2 hidden w-48 h-32 object-cover rounded">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="urutan" value="0" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 p-4 border-t bg-gray-50">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Edit Slider</h3>
            <button onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Baru (Kosongkan jika tidak ingin mengganti)</label>
                    <input type="file" name="gambar" accept="image/*" onchange="previewImage(this, 'editImagePreview')" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    <img id="editImagePreview" class="mt-2 hidden w-48 h-32 object-cover rounded">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutan</label>
                        <input type="number" name="urutan" value="0" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 p-4 border-t bg-gray-50">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-center mb-2">Konfirmasi Hapus</h3>
            <p id="deleteMessage" class="text-gray-600 text-center mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
            <form id="deleteForm" method="POST">
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(slider) {
    const form = document.getElementById('editForm');
    form.action = BASE_URL + '/admin/slider/update/' + slider.id;
    form.querySelector('[name="judul"]').value = slider.judul || '';
    form.querySelector('[name="deskripsi"]').value = slider.deskripsi || '';
    form.querySelector('[name="urutan"]').value = slider.urutan || 0;
    form.querySelector('[name="status"]').value = slider.status || 'aktif';
    
    const imgPreview = document.getElementById('editImagePreview');
    if (slider.gambar) {
        imgPreview.src = BASE_URL + '/uploads/' + slider.gambar;
        imgPreview.classList.remove('hidden');
    }
    
    openModal('editModal');
}

function confirmDelete(id, name, deleteUrl) {
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus "${name}"?`;
    document.getElementById('deleteForm').action = deleteUrl;
    openModal('deleteModal');
}
</script>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>
