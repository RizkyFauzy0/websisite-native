<?php require_once '../app/views/layouts/admin_header.php'; ?>

<?php $flash = $this->getFlash(); ?>
<?php if($flash): ?>
<div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
    <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i>
    <?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Berita</h1>
        <p class="text-gray-600 mt-2">Kelola berita sekolah</p>
    </div>
    <button onclick="openModal('createModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah Berita
    </button>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(!empty($berita_list)): ?>
                    <?php foreach($berita_list as $index => $berita): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $index + 1 ?></td>
                        <td class="px-6 py-4">
                            <?php if(!empty($berita->gambar)): ?>
                                <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($berita->gambar) ?>" alt="Berita" class="h-16 w-24 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">No image</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars(substr($berita->judul, 0, 50)) ?><?= strlen($berita->judul) > 50 ? '...' : '' ?></td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($berita->penulis) ?></td>
                        <td class="px-6 py-4 text-sm"><?= date('d/m/Y', strtotime($berita->tanggal_publish)) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full <?= $berita->status == 'publish' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                <?= ucfirst($berita->status) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick='openEditModal(<?= json_encode($berita) ?>)' class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="confirmDelete(<?= $berita->id ?>, '<?= htmlspecialchars(addslashes($berita->judul)) ?>', '<?= BASE_URL ?>/admin/berita/delete/<?= $berita->id ?>')" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada data berita</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Tambah Berita Baru</h3>
            <button onclick="closeModal('createModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?= BASE_URL ?>/admin/berita/store" method="POST" enctype="multipart/form-data">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penulis *</label>
                    <input type="text" name="penulis" value="<?= $_SESSION['admin_nama'] ?? '' ?>" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita *</label>
                    <textarea name="isi_berita" rows="8" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar (Max 5MB)</label>
                    <input type="file" name="gambar" accept="image/*" onchange="previewImage(this, 'createImagePreview')" class="w-full px-3 py-2 border rounded-lg">
                    <img id="createImagePreview" class="mt-2 hidden w-48 h-32 object-cover rounded">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                        <input type="date" name="tanggal_publish" value="<?= date('Y-m-d') ?>" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg">
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 p-4 border-t bg-gray-50">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Edit Berita</h3>
            <button onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Penulis *</label>
                    <input type="text" name="penulis" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita *</label>
                    <textarea name="isi_berita" rows="8" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Baru</label>
                    <input type="file" name="gambar" accept="image/*" onchange="previewImage(this, 'editImagePreview')" class="w-full px-3 py-2 border rounded-lg">
                    <img id="editImagePreview" class="mt-2 hidden w-48 h-32 object-cover rounded">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Publish</label>
                        <input type="date" name="tanggal_publish" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg">
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 p-4 border-t bg-gray-50">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
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
            <p id="deleteMessage" class="text-gray-600 text-center mb-6"></p>
            <form id="deleteForm" method="POST">
                <div class="flex gap-2">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(berita) {
    const form = document.getElementById('editForm');
    form.action = BASE_URL + '/admin/berita/update/' + berita.id;
    form.querySelector('[name="judul"]').value = berita.judul || '';
    form.querySelector('[name="penulis"]').value = berita.penulis || '';
    form.querySelector('[name="isi_berita"]').value = berita.isi_berita || '';
    form.querySelector('[name="tanggal_publish"]').value = berita.tanggal_publish || '';
    form.querySelector('[name="status"]').value = berita.status || 'draft';
    
    const imgPreview = document.getElementById('editImagePreview');
    if (berita.gambar) {
        imgPreview.src = BASE_URL + '/uploads/' + berita.gambar;
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
