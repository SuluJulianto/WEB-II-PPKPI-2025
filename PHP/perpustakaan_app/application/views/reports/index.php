<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Pilih Jenis Laporan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="<?php echo site_url('reports/borrowing_report'); ?>" class="block p-6 bg-blue-50 hover:bg-blue-100 rounded-lg shadow-md transition duration-300 ease-in-out text-center">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Laporan Peminjaman & Pengembalian</h3>
                <p class="text-gray-600">Lihat semua catatan peminjaman dan pengembalian buku, termasuk status dan denda.</p>
            </a>
            <a href="<?php echo site_url('reports/overdue_report'); ?>" class="block p-6 bg-red-50 hover:bg-red-100 rounded-lg shadow-md transition duration-300 ease-in-out text-center">
                <h3 class="text-xl font-semibold text-red-700 mb-2">Laporan Buku Terlambat & Denda</h3>
                <p class="text-gray-600">Daftar buku yang terlambat dikembalikan beserta perhitungan dendanya.</p>
            </a>
            <!-- Anda bisa menambahkan link laporan lain di sini -->
            <!--
            <a href="#" class="block p-6 bg-emerald-50 hover:bg-emerald-100 rounded-lg shadow-md transition duration-300 ease-in-out text-center">
                <h3 class="text-xl font-semibold text-emerald-700 mb-2">Laporan Anggota Aktif</h3>
                <p class="text-gray-600">Lihat daftar anggota yang aktif meminjam buku.</p>
            </a>
            <a href="#" class="block p-6 bg-purple-50 hover:bg-purple-100 rounded-lg shadow-md transition duration-300 ease-in-out text-center">
                <h3 class="text-xl font-semibold text-purple-700 mb-2">Laporan Stok Buku</h3>
                <p class="text-gray-600">Lihat ringkasan stok buku yang tersedia dan yang sedang dipinjam.</p>
            </a>
            -->
        </div>

        <div class="mt-8 text-center">
            <a href="<?php echo site_url('dashboard'); ?>" class="inline-block px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
