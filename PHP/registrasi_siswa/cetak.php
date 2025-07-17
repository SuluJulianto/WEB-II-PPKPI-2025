<?php
require_once "config/database.php";
require('fpdf/fpdf.php');

if (isset($_GET['NoReg'])) {
    $no_reg = $_GET['NoReg'];
    $query = mysqli_query($db, "SELECT * FROM registrasi WHERE NoReg = '$no_reg'");
    $data = mysqli_fetch_assoc($query);

    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    // KEPALA DOKUMEN
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(190,7,'BUKTI PENDAFTARAN SISWA BARU',0,1,'C');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,7,'SEKOLAH CODING NUSANTARA',0,1,'C');
    $pdf->Line(10, 30, 200, 30);
    $pdf->Ln(10);

    // ISI DOKUMEN
    $pdf->SetFont('Arial','',12);
    function createRow($pdf_obj, $label, $value) {
        $pdf_obj->Cell(50, 8, $label, 0, 0);
        $pdf_obj->Cell(5, 8, ':', 0, 0, 'C');
        $pdf_obj->Cell(100, 8, $value, 0, 1);
    }

    createRow($pdf, 'Nomor Registrasi', $data['NoReg']);
    createRow($pdf, 'Nama Lengkap', $data['Nama']);
    createRow($pdf, 'Jenis Kelamin', $data['JK']);
    createRow($pdf, 'Alamat', $data['Alamat']);
    createRow($pdf, 'Agama', $data['Agama']);
    createRow($pdf, 'Asal Sekolah', $data['AsalSekolah']);
    createRow($pdf, 'Jurusan Pilihan', $data['Jurusan']);

    // TANDA TANGAN
    $pdf->Ln(20);
    $pdf->Cell(130);
    $pdf->Cell(50, 8, 'Jakarta, ' . date('d F Y'), 0, 1, 'C');
    $pdf->Cell(130);
    $pdf->Cell(50, 8, 'Panitia Pendaftaran,', 0, 1, 'C');
    $pdf->Ln(20);
    $pdf->Cell(130);
    $pdf->SetFont('Arial','U',12);
    $pdf->Cell(50, 8, '.........................................', 0, 1, 'C');

    // OUTPUT PDF
    $pdf->Output("D", "Bukti-Pendaftaran-".$data['Nama'].".pdf");
}
?>