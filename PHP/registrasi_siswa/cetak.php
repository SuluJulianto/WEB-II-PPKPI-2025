<?php
// Memuat file konfigurasi database.
require_once "config/database.php";

// PERBAIKAN DI SINI: Path ke fpdf.php telah diubah ke folder 'lib/'.
require_once "lib/fpdf/fpdf.php";

// Memeriksa apakah NoReg ada di parameter URL.
if (isset($_GET['NoReg'])) {
    $no_reg = $_GET['NoReg'];

    // Mengambil data siswa dari database menggunakan prepared statement agar lebih aman.
    $stmt = mysqli_prepare($db, "SELECT * FROM registrasi WHERE NoReg = ?");
    mysqli_stmt_bind_param($stmt, "s", $no_reg);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($query);

    // Jika data ditemukan, buat PDF.
    if ($data) {
        // --- Proses Pembuatan PDF ---
        $pdf = new FPDF('P','mm','A4');
        $pdf->AddPage();

        // KEPALA DOKUMEN
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(190,7,'BUKTI PENDAFTARAN SISWA BARU',0,1,'C');
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,7,'SEKOLAH CODING NUSANTARA',0,1,'C');
        $pdf->Line(10, 30, 200, 30); // Garis pemisah
        $pdf->Ln(10); // Spasi

        // ISI DOKUMEN
        $pdf->SetFont('Arial','',12);
        
        // Fungsi bantuan untuk membuat baris agar tidak menulis kode berulang
        function createRow($pdf_obj, $label, $value) {
            $pdf_obj->Cell(50, 8, $label, 0, 0); // Lebar kolom label
            $pdf_obj->Cell(5, 8, ':', 0, 0, 'C'); // Titik dua
            // Menggunakan MultiCell untuk menangani teks panjang seperti alamat
            $pdf_obj->MultiCell(0, 8, $value, 0, 'L'); 
        }

        // Mencetak setiap baris data
        createRow($pdf, 'Nomor Registrasi', $data['NoReg']);
        createRow($pdf, 'Nama Lengkap', $data['Nama']);
        createRow($pdf, 'Jenis Kelamin', $data['JK']);
        createRow($pdf, 'Alamat', $data['Alamat']);
        createRow($pdf, 'Agama', $data['Agama']);
        createRow($pdf, 'Asal Sekolah', $data['AsalSekolah']);
        createRow($pdf, 'Jurusan Pilihan', $data['Jurusan']);

        // TANDA TANGAN
        $pdf->Ln(20); // Spasi
        $pdf->Cell(130); // Pindah ke kanan
        $pdf->Cell(50, 8, 'Jakarta, ' . date('d F Y'), 0, 1, 'C');
        $pdf->Cell(130);
        $pdf->Cell(50, 8, 'Panitia Pendaftaran,', 0, 1, 'C');
        $pdf->Ln(20); // Spasi untuk tanda tangan
        $pdf->Cell(130);
        $pdf->SetFont('Arial','U',12);
        $pdf->Cell(50, 8, '.........................................', 0, 1, 'C');

        // OUTPUT PDF
        // "D" berarti file akan langsung di-download oleh browser.
        $pdf->Output("D", "Bukti-Pendaftaran-".$data['Nama'].".pdf");

    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "Nomor Registrasi tidak valid.";
}
?>