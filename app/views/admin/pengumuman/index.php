<?php require_once '../app/views/layouts/admin_header.php'; ?>
<?php $flash = $this->getFlash(); if($flash): ?>
<div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
    <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i><?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>
<div class="flex justify-between items-center mb-6"><div><h1 class="text-3xl font-bold text-gray-800">Manajemen Pengumuman</h1><p class="text-gray-600 mt-2">Kelola pengumuman sekolah</p></div>
<button onclick="openModal('createModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"><i class="fas fa-plus"></i>Tambah Pengumuman</button></div>
<div class="bg-white rounded-xl shadow-md overflow-hidden"><div class="overflow-x-auto"><table class="w-full">
<thead class="bg-gray-50 border-b"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th></tr></thead>
<tbody class="bg-white divide-y"><?php if(!empty($pengumuman_list)): foreach($pengumuman_list as $index => $item): ?>
<tr class="hover:bg-gray-50"><td class="px-6 py-4 text-sm"><?= $index + 1 ?></td><td class="px-6 py-4 text-sm"><?= htmlspecialchars($item->judul) ?></td>
<td class="px-6 py-4 text-sm"><?= date('d/m/Y', strtotime($item->tanggal_mulai)) ?></td>
<td class="px-6 py-4"><span class="px-2 py-1 text-xs rounded-full <?= $item->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>"><?= ucfirst($item->status) ?></span></td>
<td class="px-6 py-4 text-sm"><button onclick='openEditModal(<?= htmlspecialchars(json_encode($item), ENT_QUOTES) ?>)' class="text-blue-600 mr-3"><i class="fas fa-edit"></i></button>
<button onclick="confirmDelete(<?= $item->id ?>, '<?= htmlspecialchars(addslashes($item->judul)) ?>', '<?= BASE_URL ?>/admin/pengumuman/delete/<?= $item->id ?>')" class="text-red-600"><i class="fas fa-trash"></i></button></td></tr>
<?php endforeach; else: ?><tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data</td></tr><?php endif; ?></tbody></table></div></div>
<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center"><div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
<div class="flex justify-between items-center p-4 border-b"><h3 class="text-xl font-semibold">Tambah Pengumuman</h3><button onclick="closeModal('createModal')" class="text-gray-500"><i class="fas fa-times"></i></button></div>
<form action="<?= BASE_URL ?>/admin/pengumuman/store" method="POST"><div class="p-4 space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label><input type="text" name="judul" required class="w-full px-3 py-2 border rounded-lg"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Isi Pengumuman *</label><textarea name="isi_pengumuman" rows="5" required class="w-full px-3 py-2 border rounded-lg"></textarea></div>
<div class="grid grid-cols-2 gap-4"><div><label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label><input type="date" name="tanggal_mulai" value="<?= date('Y-m-d') ?>" required class="w-full px-3 py-2 border rounded-lg"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label><input type="date" name="tanggal_selesai" class="w-full px-3 py-2 border rounded-lg"></div></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Status</label><select name="status" class="w-full px-3 py-2 border rounded-lg"><option value="aktif">Aktif</option><option value="nonaktif">Non-Aktif</option></select></div>
</div><div class="flex justify-end gap-2 p-4 border-t bg-gray-50"><button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button></div></form></div></div>
<div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center"><div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
<div class="flex justify-between items-center p-4 border-b"><h3 class="text-xl font-semibold">Edit Pengumuman</h3><button onclick="closeModal('editModal')" class="text-gray-500"><i class="fas fa-times"></i></button></div>
<form id="editForm" method="POST"><div class="p-4 space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label><input type="text" name="judul" required class="w-full px-3 py-2 border rounded-lg"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Isi Pengumuman *</label><textarea name="isi_pengumuman" rows="5" required class="w-full px-3 py-2 border rounded-lg"></textarea></div>
<div class="grid grid-cols-2 gap-4"><div><label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label><input type="date" name="tanggal_mulai" required class="w-full px-3 py-2 border rounded-lg"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label><input type="date" name="tanggal_selesai" class="w-full px-3 py-2 border rounded-lg"></div></div>
<div><label class="block text-sm font-medium text-gray-700 mb-2">Status</label><select name="status" class="w-full px-3 py-2 border rounded-lg"><option value="aktif">Aktif</option><option value="nonaktif">Non-Aktif</option></select></div>
</div><div class="flex justify-end gap-2 p-4 border-t bg-gray-50"><button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button></div></form></div></div>
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center"><div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4"><div class="p-6">
<div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4"><i class="fas fa-exclamation-triangle text-red-600 text-xl"></i></div>
<h3 class="text-lg font-semibold text-center mb-2">Konfirmasi Hapus</h3><p id="deleteMessage" class="text-gray-600 text-center mb-6"></p>
<form id="deleteForm" method="POST"><div class="flex gap-2"><button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
<button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button></div></form></div></div></div>
<script>function openEditModal(item){const form=document.getElementById('editForm');form.action=BASE_URL+'/admin/pengumuman/update/'+item.id;
form.querySelector('[name="judul"]').value=item.judul||'';form.querySelector('[name="isi_pengumuman"]').value=item.isi_pengumuman||'';
form.querySelector('[name="tanggal_mulai"]').value=item.tanggal_mulai||'';form.querySelector('[name="tanggal_selesai"]').value=item.tanggal_selesai||'';
form.querySelector('[name="status"]').value=item.status||'aktif';openModal('editModal');}
function confirmDelete(id,name,deleteUrl){document.getElementById('deleteMessage').textContent=`Apakah Anda yakin ingin menghapus "${name}"?`;
document.getElementById('deleteForm').action=deleteUrl;openModal('deleteModal');}</script>
<?php require_once '../app/views/layouts/admin_footer.php'; ?>
