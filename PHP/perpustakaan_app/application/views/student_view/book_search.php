<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Buku Perpustakaan</title>
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
        .main-content {
            flex-grow: 1;
            padding: 2rem;
        }
        .search-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db; /* border-gray-300 */
            border-radius: 0.375rem; /* rounded-md */
            box-sizing: border-box;
        }
        .search-button {
            padding: 0.75rem 1.5rem;
            background-color: #22c55e; /* bg-green-500 */
            color: white;
            border-radius: 0.375rem; /* rounded-md */
            font-weight: 600; /* font-semibold */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #16a34a; /* bg-green-600 */
        }
        .back-button {
            display: inline-block;
            px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out
        }
    </style>
</head>
<body>
    <header class="header">
        <h1 class="text-3xl font-bold">Pencarian Buku Perpustakaan</h1>
        <nav>
            <a href="<?php echo site_url('auth/login'); ?>" class="back-button px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm font-semibold transition duration-300">
                Kembali ke Login
            </a>
        </nav>
    </header>

    <main class="main-content">
        <div class="container mx-auto p-6">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Cari Ketersediaan Buku</h2>

                <!-- Search Form -->
                <?php echo form_open('student_view/book_search', ['method' => 'get', 'class' => 'mb-8']); ?>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-grow">
                            <input type="text" id="q" name="q" placeholder="Cari judul, penulis, atau penerbit..."
                                   value="<?php echo html_escape($search_query); ?>"
                                   class="search-input">
                        </div>
                        <div>
                            <button type="submit" class="search-button">Cari</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>

                <!-- Search Results -->
                <?php if (!empty($search_query) && empty($books)): ?>
                    <p class="text-center text-gray-600 text-lg">Tidak ditemukan buku dengan kata kunci "<?php echo html_escape($search_query); ?>".</p>
                <?php elseif (empty($books)): ?>
                    <p class="text-center text-gray-600 text-lg">Silakan masukkan kata kunci pencarian untuk menemukan buku.</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tl-lg">Judul</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Penulis</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Penerbit</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Tahun</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tr-lg">Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($books as $book): ?>
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="py-3 px-4 text-sm text-gray-800 font-medium"><?php echo $book->judul; ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->penulis; ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->penerbit; ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->tahun_terbit; ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-800">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                <?php echo ($book->stok > 0) ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'; ?>">
                                                <?php echo $book->stok; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        <p>&copy; <?php echo date('Y'); ?> Sistem Perpustakaan. All rights reserved.</p>
    </footer>
</body>
</html>
