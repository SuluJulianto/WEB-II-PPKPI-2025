<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Peminjaman & Pengembalian</h2>

        <!-- Flashdata Messages -->
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

        <div class="mb-6 text-right">
            <a href="<?php echo site_url('borrowings/borrow'); ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Catat Peminjaman Baru
            </a>
        </div>

        <?php if (empty($borrowings)): ?>
            <p class="text-center text-gray-600 text-lg">Belum ada catatan peminjaman.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tl-lg">ID</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Anggota</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Buku</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Tgl Pinjam</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Tgl Kembali Seharusnya</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Tgl Dikembalikan</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Status</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Hari Terlambat</th>
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">Denda (Rp)</th>
                            <th class="py-3 px-4 text-center text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($borrowings as $borrowing): ?>
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $borrowing->id; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800 font-medium"><?php echo $borrowing->member_nama; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $borrowing->book_judul; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $borrowing->tanggal_pinjam; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800"><?php echo $borrowing->tanggal_kembali_seharusnya; ?></td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    <?php echo $borrowing->tanggal_dikembalikan ? $borrowing->tanggal_dikembalikan : '-'; ?>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        <?php echo ($borrowing->status == 'dipinjam') ? 'bg-orange-100 text-orange-800' : 'bg-emerald-100 text-emerald-800'; ?>">
                                        <?php echo ucfirst($borrowing->status); ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    <?php echo $borrowing->total_hari_terlambat ? $borrowing->total_hari_terlambat : '-'; ?>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-800">
                                    <?php echo $borrowing->denda ? number_format($borrowing->denda, 0, ',', '.') : '0'; ?>
                                </td>
                                <td class="py-3 px-4 text-center text-sm">
                                    <?php if ($borrowing->status == 'dipinjam'): ?>
                                        <a href="<?php echo site_url('borrowings/return_book_form/' . $borrowing->id); ?>" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs font-semibold mr-2 transition duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Kembalikan
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($level == 'admin'): ?>
                                        <a href="<?php echo site_url('borrowings/delete/' . $borrowing->id); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan peminjaman ini?');" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </a>
                                    <?php endif; ?>
                                </td>
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
