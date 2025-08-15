<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Borrowing_model'); // Untuk data peminjaman/pengembalian
        $this->load->model('Member_model');    // Untuk data anggota
        $this->load->model('Book_model');      // Untuk data buku

        // Pastikan user sudah login. Jika belum, arahkan ke halaman login.
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Halaman utama laporan
    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('reports/index'); // View untuk memilih jenis laporan
        $this->load->view('templates/footer');
    }

    // Laporan Peminjaman dan Pengembalian
    public function borrowing_report()
    {
        $data['borrowings'] = $this->Borrowing_model->get_all_borrowings(); // Ambil semua data peminjaman
        $this->load->view('templates/header');
        $this->load->view('reports/borrowing_report', $data);
        $this->load->view('templates/footer');
    }

    // Laporan Buku Terlambat dan Denda
    public function overdue_report()
    {
        $this->db->select('borrowings.*, members.nama as member_nama, books.judul as book_judul');
        $this->db->from('borrowings');
        $this->db->join('members', 'members.id = borrowings.member_id');
        $this->db->join('books', 'books.id = borrowings.book_id');
        $this->db->where('status', 'dipinjam'); // Hanya buku yang masih dipinjam
        $this->db->where('tanggal_kembali_seharusnya < CURDATE()'); // Yang sudah melewati tanggal seharusnya
        $this->db->order_by('tanggal_kembali_seharusnya', 'ASC'); // Urutkan dari yang paling lama terlambat
        $query = $this->db->get();
        $data['overdue_borrowings'] = $query->result();

        $this->load->view('templates/header');
        $this->load->view('reports/overdue_report', $data);
        $this->load->view('templates/footer');
    }

    // Anda bisa menambahkan laporan lain di sini, misalnya:
    // public function member_report() { ... }
    // public function book_stock_report() { ... }
}
