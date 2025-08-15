<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Manajemen Buku</h2>

        <!-- Pesan Flashdata -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline"><?php echo $this->session->flashdata('success'); ?></span>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($level == 'admin'): ?>
            <div class="mb-6 text-right">
                <a href="<?php echo site_url('books/add'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Buku Baru
                </a>
            </div>
        <?php endif; ?>

        <?php if (empty($books)): ?>
            <p class="text-center text-gray-600 text-lg">Belum ada buku yang terdaftar.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tl-lg">ID</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Judul</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Penulis</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Penerbit</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Tahun</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Stok</th>
                            <?php if ($level == 'admin'): ?>
                                <th class="py-3 px-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tr-lg">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($books as $book): ?>
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->id; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800 font-medium"><?php echo $book->judul; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->penulis; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->penerbit; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->tahun_terbit; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $book->stok; ?></td>
                                <?php if ($level == 'admin'): ?>
                                    <td class="py-3 px-4 text-center text-sm">
                                        <a href="<?php echo site_url('books/edit/' . $book->id); ?>" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs font-semibold mr-2 transition duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </a>
                                        <a href="<?php echo site_url('books/delete/' . $book->id); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <a href="<?php echo site_url('dashboard'); ?>" class="inline-block px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
