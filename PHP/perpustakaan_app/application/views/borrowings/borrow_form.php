<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Catat Peminjaman Buku</h2>

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

        <!-- Form Peminjaman Buku -->
        <?php echo form_open('borrowings/borrow', ['class' => 'space-y-6']); ?>

            <div>
                <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Anggota</label>
                <select id="member_id" name="member_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($members as $member): ?>
                        <option value="<?php echo $member->id; ?>" <?php echo set_select('member_id', $member->id); ?>>
                            <?php echo $member->nama . ' (NIS: ' . $member->nis . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="book_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku</label>
                <select id="book_id" name="book_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($books as $book): ?>
                        <option value="<?php echo $book->id; ?>" <?php echo set_select('book_id', $book->id); ?> <?php echo ($book->stok == 0) ? 'disabled' : ''; ?>>
                            <?php echo $book->judul . ' (Stok: ' . $book->stok . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Buku dengan stok 0 tidak dapat dipilih.</p>
            </div>

            <div>
                <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="<?php echo set_value('tanggal_pinjam', date('Y-m-d')); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="tanggal_kembali_seharusnya" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali Seharusnya</label>
                <input type="date" id="tanggal_kembali_seharusnya" name="tanggal_kembali_seharusnya" value="<?php echo set_value('tanggal_kembali_seharusnya', date('Y-m-d', strtotime('+7 days'))); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <p class="text-xs text-gray-500 mt-1">Disarankan 7 hari dari tanggal pinjam.</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo site_url('borrowings'); ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Catat Peminjaman
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
