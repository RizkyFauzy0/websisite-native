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
        <h1 class="text-3xl font-bold text-gray-800">Manajemen User</h1>
        <p class="text-gray-600 mt-2">Kelola user admin</p>
    </div>
    <button onclick="openModal('createModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-plus"></i>
        Tambah User
    </button>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                <?php if(!empty($user_list)): ?>
                    <?php foreach($user_list as $index => $user): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm"><?= $index + 1 ?></td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user->username) ?></td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user->nama_lengkap) ?></td>
                        <td class="px-6 py-4 text-sm"><?= htmlspecialchars($user->email) ?></td>
                        <td class="px-6 py-4 text-sm">
                            <button onclick='openEditModal(<?= json_encode($user) ?>)' class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if($user->id != $_SESSION['admin_id']): ?>
                            <button onclick="confirmDelete(<?= $user->id ?>, '<?= htmlspecialchars(addslashes($user->username)) ?>', '<?= BASE_URL ?>/admin/user/delete/<?= $user->id ?>')" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data user</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Create -->
<div id="createModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Tambah User Baru</h3>
            <button onclick="closeModal('createModal')" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
        </div>
        <form action="<?= BASE_URL ?>/admin/user/store" method="POST">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password *</label>
                    <input type="password" name="password_confirm" required class="w-full px-3 py-2 border rounded-lg">
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
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-xl font-semibold">Edit User</h3>
            <button onclick="closeModal('editModal')" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
        </div>
        <form id="editForm" method="POST">
            <div class="p-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirm" class="w-full px-3 py-2 border rounded-lg">
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
function openEditModal(user) {
    const form = document.getElementById('editForm');
    form.action = BASE_URL + '/admin/user/update/' + user.id;
    form.querySelector('[name="username"]').value = user.username || '';
    form.querySelector('[name="nama_lengkap"]').value = user.nama_lengkap || '';
    form.querySelector('[name="email"]').value = user.email || '';
    openModal('editModal');
}
function confirmDelete(id, name, deleteUrl) {
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus user "${name}"?`;
    document.getElementById('deleteForm').action = deleteUrl;
    openModal('deleteModal');
}
</script>

<?php require_once '../app/views/layouts/admin_footer.php'; ?>
