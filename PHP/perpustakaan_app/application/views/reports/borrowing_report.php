<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Laporan Peminjaman & Pengembalian</h2>

        <?php if (empty($borrowings)): ?>
            <p class="text-center text-gray-600 text-lg">Belum ada catatan peminjaman atau pengembalian.</p>
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
                            <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 rounded-tr-lg">Denda (Rp)</th>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-8 text-center">
            <a href="<?php echo site_url('reports'); ?>" class="inline-block px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                Kembali ke Pilihan Laporan
            </a>
        </div>
    </div>
</div>
