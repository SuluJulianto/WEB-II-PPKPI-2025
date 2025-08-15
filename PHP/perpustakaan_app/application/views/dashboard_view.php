<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .header {
            background-color: #3b82f6; /* bg-blue-500 */
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container {
            flex-grow: 1;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .welcome-box {
            background-color: #ffffff;
            padding: 3rem;
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
            max-width: 600px;
            width: 100%;
        }
        .logout-button {
            background-color: #ef4444; /* bg-red-500 */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600; /* font-semibold */
            transition: background-color 0.3s ease;
        }
        .logout-button:hover {
            background-color: #dc2626; /* bg-red-600 */
        }
        .nav-button {
            display: inline-block;
            margin-top: 1rem;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #10b981; /* bg-emerald-500 */
            color: white;
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .nav-button:hover {
            background-color: #059669; /* bg-emerald-600 */
        }
        .admin-button {
            background-color: #3b82f6; /* bg-blue-500 */
        }
        .admin-button:hover {
            background-color: #2563eb; /* bg-blue-600 */
        }
        .user-button {
            background-color: #f97316; /* bg-orange-500 */
        }
        .user-button:hover {
            background-color: #ea580c; /* bg-orange-600 */
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="text-3xl font-bold">Sistem Perpustakaan</h1>
        <nav>
            <a href="<?php echo site_url('auth/logout'); ?>" class="logout-button">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="welcome-box">
            <h2 class="text-4xl font-extrabold text-gray-800 mb-4">Selamat Datang, <?php echo $username; ?>!</h2>
            <p class="text-xl text-gray-600 mb-6">Anda login sebagai <span class="font-bold text-blue-600"><?php echo ucfirst($level); ?></span>.</p>
            <p class="text-lg text-gray-700">Ini adalah halaman dashboard Anda. Di sini Anda akan menemukan fitur-fitur sesuai dengan hak akses Anda.</p>
            <div class="mt-8">
                <?php if ($level == 'admin'): ?>
                    <p class="text-gray-700 mb-4">Sebagai Admin, Anda memiliki akses penuh ke manajemen buku, anggota, petugas, dan laporan.</p>
                    <a href="<?php echo site_url('books'); ?>" class="nav-button admin-button">Manajemen Buku</a>
                    <a href="<?php echo site_url('members'); ?>" class="nav-button admin-button">Manajemen Anggota</a>
                    <a href="<?php echo site_url('borrowings'); ?>" class="nav-button admin-button">Peminjaman & Pengembalian</a>
                    <a href="<?php echo site_url('staff'); ?>" class="nav-button admin-button">Manajemen Petugas</a>
                    <a href="<?php echo site_url('reports'); ?>" class="nav-button admin-button">Laporan</a>
                <?php elseif ($level == 'user'): ?>
                    <p class="text-gray-700 mb-4">Sebagai Petugas, Anda dapat mengelola peminjaman dan pengembalian buku, serta melihat daftar buku dan anggota.</p>
                    <a href="<?php echo site_url('books'); ?>" class="nav-button user-button">Daftar Buku</a>
                    <a href="<?php echo site_url('borrowings'); ?>" class="nav-button user-button">Peminjaman & Pengembalian</a>
                    <a href="<?php echo site_url('members'); ?>" class="nav-button user-button">Daftar Anggota</a>
                    <a href="<?php echo site_url('reports'); ?>" class="nav-button user-button">Laporan</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
