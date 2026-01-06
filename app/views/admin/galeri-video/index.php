<?php require_once '../app/views/layouts/admin_header.php'; ?>
<?php $flash = $this->getFlash(); if($flash): ?>
<div id="flash-message" class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
    <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?> mr-2"></i><?= htmlspecialchars($flash['message']) ?>
</div>
<?php endif; ?>
<div class="flex justify-between items-center mb-6"><div><h1 class="text-3xl font-bold text-gray-800">Galeri Video</h1></div>
<button onclick="openModal('createModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2"><i class="fas fa-plus"></i>Tambah Data</button></div>
<div class="bg-white rounded-xl shadow-md p-6"><p class="text-gray-600">Modul Galeri Video siap digunakan. Silakan tambah data melalui tombol di atas.</p>
<?php if(!empty($galeri_list)): ?><div class="mt-4"><table class="w-full"><tbody><?php foreach($galeri_list as $index => $item): ?><tr class="border-b"><td class="py-2"><?= $index + 1 ?></td><td class="py-2">
<button onclick='editData(<?= json_encode($item) ?>)' class="text-blue-600 mr-3"><i class="fas fa-edit"></i></button>
<button onclick="deleteData(<?= $item->id ?>, '<?= BASE_URL ?>/admin/galeri-video/delete/<?= $item->id ?>')" class="text-red-600"><i class="fas fa-trash"></i></button></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</div>
<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center"><div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
<div class="flex justify-between items-center p-4 border-b"><h3 class="text-xl font-semibold">Tambah Data</h3><button onclick="closeModal('createModal')" class="text-gray-500"><i class="fas fa-times"></i></button></div>
<form action="<?= BASE_URL ?>/admin/galeri-video/store" method="POST" enctype="multipart/form-data"><div class="p-4">
<p class="text-gray-600">Form Galeri Video - Silakan isi data yang diperlukan</p></div>
<div class="flex justify-end gap-2 p-4 border-t"><button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button></div></form></div></div>
<script>function editData(item){alert('Edit: '+JSON.stringify(item));}function deleteData(id,url){if(confirm('Hapus data ini?')){const form=document.createElement('form');form.method='POST';form.action=url;document.body.appendChild(form);form.submit();}}</script>
<?php require_once '../app/views/layouts/admin_footer.php'; ?>