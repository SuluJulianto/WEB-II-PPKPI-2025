<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation'); // Untuk validasi form
        $this->load->model('Book_model');        // Memuat Book_model

        // Cek apakah user sudah login. Jika belum, arahkan ke halaman login.
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Menampilkan daftar buku
    public function index()
    {
        $data['books'] = $this->Book_model->get_all_books(); // Ambil semua data buku
        $data['level'] = $this->session->userdata('level'); // Ambil level user untuk kontrol akses di view
        $this->load->view('templates/header'); // Header umum (jika ada)
        $this->load->view('books/index', $data); // Memuat view daftar buku
        $this->load->view('templates/footer'); // Footer umum (jika ada)
    }

    // Menampilkan form tambah buku atau memproses penambahan
    public function add()
    {
        // Hanya admin yang bisa menambah buku
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menambah buku.');
            redirect('books');
        }

        // Aturan validasi form
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required');
        $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau pertama kali akses form, tampilkan form
            $this->load->view('templates/header');
            $this->load->view('books/form');
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, proses penambahan buku
            $data = array(
                'judul'        => $this->input->post('judul'),
                'penulis'      => $this->input->post('penulis'),
                'penerbit'     => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'stok'         => $this->input->post('stok')
            );

            if ($this->Book_model->add_book($data)) {
                $this->session->set_flashdata('success', 'Buku berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan buku.');
            }
            redirect('books'); // Kembali ke daftar buku
        }
    }

    // Menampilkan form edit buku atau memproses pengeditan
    public function edit($id = NULL)
    {
        // Hanya admin yang bisa mengedit buku
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk mengedit buku.');
            redirect('books');
        }

        $data['book'] = $this->Book_model->get_book_by_id($id); // Ambil data buku berdasarkan ID

        // Jika buku tidak ditemukan
        if (empty($data['book'])) {
            $this->session->set_flashdata('error', 'Buku tidak ditemukan.');
            redirect('books');
        }

        // Aturan validasi form (sama seperti add)
        $this->form_validation->set_rules('judul', 'Judul', 'required');
        $this->form_validation->set_rules('penulis', 'Penulis', 'required');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'required');
        $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau pertama kali akses form, tampilkan form dengan data buku
            $this->load->view('templates/header');
            $this->load->view('books/form', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, proses pengeditan buku
            $data_update = array(
                'judul'        => $this->input->post('judul'),
                'penulis'      => $this->input->post('penulis'),
                'penerbit'     => $this->input->post('penerbit'),
                'tahun_terbit' => $this->input->post('tahun_terbit'),
                'stok'         => $this->input->post('stok')
            );

            if ($this->Book_model->update_book($id, $data_update)) {
                $this->session->set_flashdata('success', 'Buku berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui buku.');
            }
            redirect('books'); // Kembali ke daftar buku
        }
    }

    // Menghapus buku
    public function delete($id = NULL)
    {
        // Hanya admin yang bisa menghapus buku
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menghapus buku.');
            redirect('books');
        }

        if ($this->Book_model->delete_book($id)) {
            $this->session->set_flashdata('success', 'Buku berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus buku atau buku tidak ditemukan.');
        }
        redirect('books'); // Kembali ke daftar buku
    }
}
