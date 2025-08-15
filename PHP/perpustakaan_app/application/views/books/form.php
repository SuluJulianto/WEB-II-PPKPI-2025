<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            <?php echo isset($book) ? 'Edit Buku' : 'Tambah Buku Baru'; ?>
        </h2>

        <!-- Pesan Error Validasi -->
        <?php if (validation_errors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Validasi Gagal!</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php echo validation_errors('<li>', '</li>'); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Tambah/Edit Buku -->
        <?php echo form_open(isset($book) ? 'books/edit/' . $book->id : 'books/add', ['class' => 'space-y-6']); ?>

            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                <input type="text" id="judul" name="judul" value="<?php echo set_value('judul', isset($book) ? $book->judul : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="penulis" class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                <input type="text" id="penulis" name="penulis" value="<?php echo set_value('penulis', isset($book) ? $book->penulis : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                <input type="text" id="penerbit" name="penerbit" value="<?php echo set_value('penerbit', isset($book) ? $book->penerbit : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?php echo set_value('tahun_terbit', isset($book) ? $book->tahun_terbit : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required min="1000" max="<?php echo date('Y'); ?>">
            </div>

            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                <input type="number" id="stok" name="stok" value="<?php echo set_value('stok', isset($book) ? $book->stok : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required min="0">
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo site_url('books'); ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php echo isset($book) ? 'Update Buku' : 'Simpan Buku'; ?>
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
