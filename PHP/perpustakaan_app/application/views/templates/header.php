<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
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
        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="text-3xl font-bold">Sistem Perpustakaan</h1>
        <nav>
            <a href="<?php echo site_url('dashboard'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Dashboard</a>
            <a href="<?php echo site_url('books'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Buku</a>
            <a href="<?php echo site_url('members'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Anggota</a>
            <a href="<?php echo site_url('borrowings'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Peminjaman</a>
            <?php if ($this->session->userdata('level') == 'admin'): ?>
                <a href="<?php echo site_url('staff'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Petugas</a>
            <?php endif; ?>
            <a href="<?php echo site_url('reports'); ?>" class="mr-4 text-white hover:text-blue-200 transition duration-300">Laporan</a>
            <a href="<?php echo site_url('auth/logout'); ?>" class="logout-button">Logout</a>
        </nav>
    </header>
    <main class="main-content">
