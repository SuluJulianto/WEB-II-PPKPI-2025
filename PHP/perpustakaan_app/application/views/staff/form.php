<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            <?php echo isset($staff) ? 'Edit Petugas' : 'Tambah Petugas Baru'; ?>
        </h2>

        <!-- Validation Error Messages -->
        <?php if (validation_errors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-4" role="alert">
                <strong class="font-bold">Validasi Gagal!</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php echo validation_errors('<li>', '</li>'); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Tambah/Edit Petugas -->
        <?php echo form_open(isset($staff) ? 'staff/edit/' . $staff->id : 'staff/add', ['class' => 'space-y-6']); ?>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" value="<?php echo set_value('username', isset($staff) ? $staff->username : ''); ?>"
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <?php echo isset($staff) ? '(Kosongkan jika tidak ingin diubah)' : ''; ?></label>
                <input type="password" id="password" name="password" value=""
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" <?php echo isset($staff) ? '' : 'required'; ?>>
            </div>

            <div>
                <label for="passconf" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="passconf" name="passconf" value=""
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" <?php echo isset($staff) ? '' : 'required'; ?>>
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level Akses</label>
                <select id="level" name="level" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    <option value="user" <?php echo set_select('level', 'user', (isset($staff) && $staff->level == 'user')); ?>>Petugas (User)</option>
                    <option value="admin" <?php echo set_select('level', 'admin', (isset($staff) && $staff->level == 'admin')); ?>>Admin</option>
                </select>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="<?php echo site_url('staff'); ?>" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?php echo isset($staff) ? 'Update Petugas' : 'Simpan Petugas'; ?>
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
