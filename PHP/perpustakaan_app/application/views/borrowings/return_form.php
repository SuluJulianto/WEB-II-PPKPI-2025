<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Form Pengembalian Buku</h2>

        <!-- Validation Error Messages -->
        <?php if (validation_errors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Validasi Gagal!</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php echo validation_errors('<li>', '</li>'); ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline"><?php echo $this->session->flashdata('error'); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($borrowing)): ?>
            <div class="mb-6 p-4 bg-gray-50 rounded-md border border-gray-200">
                <p class="text-lg font-semibold text-gray-800">Detail Peminjaman:</p>
                <p class="text-gray-700"><strong>Anggota:</strong> <?php echo $borrowing->member_nama; ?></p>
                <p class="text-gray-700"><strong>Buku:</strong> <?php echo $borrowing->book_judul; ?></p>
                <p class="text-gray-700"><strong>Tanggal Pinjam:</strong> <?php echo $borrowing->tanggal_pinjam; ?></p>
                <p class="text-gray-700"><strong>Tanggal Kembali Seharusnya:</strong> <?php echo $borrowing->tanggal_kembali_seharusnya; ?></p>
                <p class="text-gray-700"><strong>Status:</strong> <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800"><?php echo ucfirst($borrowing->status); ?></span></p>
            </div>

            <!-- Form Pengembalian Buku -->
            <?php echo form_open('borrowings/return_book_form/' . $borrowing->id, ['class' => 'space-y-6']); ?>

                <div>
                    <label for="tanggal_dikembalikan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dikembalikan</label>
                    <input type="date" id="tanggal_dikembalikan" name="tanggal_dikembalikan" value="<?php echo set_value('tanggal_dikembalikan', date('Y-m-d')); ?>"
                           class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="<?php echo site_url('borrowings'); ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Proses Pengembalian
                    </button>
                </div>
            <?php echo form_close(); ?>
        <?php else: ?>
            <p class="text-center text-gray-600 text-lg">Data peminjaman tidak ditemukan.</p>
            <div class="mt-8 text-center">
                <a href="<?php echo site_url('borrowings'); ?>" class="inline-block px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                    Kembali ke Daftar Peminjaman
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

