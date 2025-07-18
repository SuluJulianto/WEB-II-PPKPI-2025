// Menjalankan kode setelah seluruh halaman (DOM) selesai dimuat.
$(document).ready(function() {

    // Event handler ini akan berjalan ketika modal dengan ID 'konfirmasiHapusModal' ditampilkan.
    $('#konfirmasiHapusModal').on('show.bs.modal', function (event) {
        // 'event.relatedTarget' adalah tombol yang memicu modal (tombol hapus di tabel).
        var button = $(event.relatedTarget); 
        
        // Mengambil data dari atribut 'data-noreg' dan 'data-nama' pada tombol.
        var noReg = button.data('noreg');
        var nama = button.data('nama');
        
        // Mendapatkan objek modal itu sendiri.
        var modal = $(this);
        
        // Mengisi nama siswa ke dalam modal body untuk pesan konfirmasi yang lebih personal.
        modal.find('.modal-body #namaSiswaDiModal').text(nama);
        
        // Membuat URL untuk penghapusan data.
        var deleteUrl = 'proses_hapus.php?NoReg=' + noReg;
        
        // Mengatur atribut 'href' pada tombol "Ya, Hapus" di dalam modal.
        modal.find('#tombolHapusFinal').attr('href', deleteUrl);
    });

    // Menambahkan event click pada tombol hapus final di dalam modal.
    // Ini adalah inti dari fitur AJAX.
    $('#tombolHapusFinal').on('click', function(e) {
        // Mencegah link default (navigasi ke halaman lain) berjalan.
        e.preventDefault();

        // Mengambil URL hapus dari atribut href yang sudah kita atur sebelumnya.
        var url = $(this).attr('href');
        
        // Mendapatkan NoReg dari URL untuk mengetahui baris mana yang harus dihapus dari tabel.
        var noReg = url.split('=')[1];

        // Memulai permintaan AJAX ke server.
        $.ajax({
            url: url,          // URL tujuan (file proses_hapus.php)
            type: 'GET',       // Metode request
            dataType: 'json',  // Tipe data yang diharapkan sebagai respons dari server

            // Fungsi yang berjalan jika request berhasil (success)
            success: function(response) {
                // Memeriksa status dari respons JSON yang dikirim server.
                if (response.status === 'success') {
                    // Menutup modal konfirmasi.
                    $('#konfirmasiHapusModal').modal('hide');

                    // Menghapus baris tabel (<tr>) yang sesuai dari halaman.
                    // Efek fadeOut memberikan animasi yang halus sebelum elemen dihapus.
                    $('#row-' + noReg).fadeOut(500, function() {
                        $(this).remove();
                    });

                    // (Opsional) Anda bisa menambahkan notifikasi sukses yang lebih canggih di sini.
                    // Untuk saat ini, kita bisa log ke konsol atau tidak melakukan apa-apa.
                    console.log('Data berhasil dihapus.');

                } else {
                    // Jika status dari server adalah 'error'.
                    alert('Gagal menghapus data: ' + response.message);
                }
            },
            
            // Fungsi yang berjalan jika terjadi error pada request AJAX itu sendiri (misal: server tidak merespons).
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat mencoba menghubungi server. Silakan coba lagi.');
                console.error("Error: ", xhr.responseText);
            }
        });
    });

});

// Menjalankan kode setelah seluruh halaman (DOM) selesai dimuat.
$(document).ready(function() {

    // --- LOGIKA UNTUK MODAL HAPUS (KODE DARI LANGKAH SEBELUMNYA) ---
    $('#konfirmasiHapusModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var noReg = button.data('noreg');
        var nama = button.data('nama');
        var modal = $(this);
        
        modal.find('.modal-body #namaSiswaDiModal').text(nama);
        var deleteUrl = 'proses_hapus.php?NoReg=' + noReg;
        modal.find('#tombolHapusFinal').attr('href', deleteUrl);
    });

    $('#tombolHapusFinal').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var noReg = url.split('=')[1];

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#konfirmasiHapusModal').modal('hide');
                    $('#row-' + noReg).fadeOut(500, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Gagal menghapus data: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan saat mencoba menghubungi server.');
            }
        });
    });

    // --- KODE BARU: LOGIKA UNTUK FILTER TABEL ---
    // Event 'keyup' akan aktif setiap kali pengguna melepaskan tombol keyboard di kotak pencarian.
    $("#pencarianData").on("keyup", function() {
        // 1. Mengambil teks dari kotak pencarian dan mengubahnya menjadi huruf kecil.
        var value = $(this).val().toLowerCase();

        // 2. Melakukan iterasi (looping) pada setiap baris (<tr>) di dalam <tbody> tabel.
        $("#dataSiswaTabel tr").filter(function() {
            
            // 3. 'toggle' akan menampilkan atau menyembunyikan baris.
            //    - Kondisi: Apakah teks di dalam baris (diubah ke huruf kecil) mengandung (indexOf > -1) teks pencarian.
            //    - Jika ya, baris akan ditampilkan (true).
            //    - Jika tidak, baris akan disembunyikan (false).
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    
});