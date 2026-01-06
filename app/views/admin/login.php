<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - School Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-800 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                    <i class="fas fa-user-shield text-blue-600 text-4xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Panel</h1>
                <p class="text-gray-600">Silakan login untuk melanjutkan</p>
            </div>
            
            <?php
            if (isset($_SESSION['flash'])) {
                $flash = $_SESSION['flash'];
                unset($_SESSION['flash']);
            ?>
            <div class="mb-6 p-4 rounded-lg <?= $flash['type'] == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
            <?php } ?>
            
            <form action="<?= BASE_URL ?>/admin/login/auth" method="POST">
                <div class="mb-6">
                    <label for="username" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-user mr-2"></i>Username
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Masukkan username">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                           placeholder="Masukkan password">
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium text-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <a href="<?= BASE_URL ?>" class="text-blue-600 hover:text-blue-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Website
                </a>
            </div>
        </div>
        
        <div class="text-center mt-6 text-white text-sm">
            <p>&copy; <?= date('Y') ?> School Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
