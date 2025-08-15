<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowings extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Borrowing_model');
        $this->load->model('Book_model');
        $this->load->model('Member_model');

        // Check if user is logged in. If not, redirect to login page.
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Display list of borrowings
    public function index()
    {
        $data['borrowings'] = $this->Borrowing_model->get_all_borrowings();
        $data['level'] = $this->session->userdata('level');
        $this->load->view('templates/header');
        $this->load->view('borrowings/index', $data);
        $this->load->view('templates/footer');
    }

    // Display form to borrow a new book or process borrowing
    public function borrow()
    {
        // Only admin and user (petugas) can borrow books
        if ($this->session->userdata('level') == 'student') { // If you later implement student login
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk meminjam buku.');
            redirect('borrowings');
        }

        $data['members'] = $this->Member_model->get_all_members();
        $data['books'] = $this->Book_model->get_all_books(); // Ambil semua buku

        $this->form_validation->set_rules('member_id', 'Anggota', 'required|numeric');
        $this->form_validation->set_rules('book_id', 'Buku', 'required|numeric');
        $this->form_validation->set_rules('tanggal_pinjam', 'Tanggal Pinjam', 'required|date');
        $this->form_validation->set_rules('tanggal_kembali_seharusnya', 'Tanggal Kembali Seharusnya', 'required|date|callback_date_check');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header');
            $this->load->view('borrowings/borrow_form', $data);
            $this->load->view('templates/footer');
        } else {
            $book_id = $this->input->post('book_id');
            $book = $this->Book_model->get_book_by_id($book_id);

            if ($book && $book->stok > 0) {
                $borrowing_data = array(
                    'member_id'                => $this->input->post('member_id'),
                    'book_id'                  => $book_id,
                    'tanggal_pinjam'           => $this->input->post('tanggal_pinjam'),
                    'tanggal_kembali_seharusnya' => $this->input->post('tanggal_kembali_seharusnya'),
                    'status'                   => 'dipinjam' // Default status
                );

                if ($this->Borrowing_model->add_borrowing($borrowing_data)) {
                    $this->session->set_flashdata('success', 'Peminjaman buku berhasil dicatat.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mencatat peminjaman buku. Stok mungkin tidak cukup atau terjadi kesalahan database.');
                }
            } else {
                $this->session->set_flashdata('error', 'Buku tidak tersedia atau stok habis.');
            }
            redirect('borrowings');
        }
    }

    // Custom callback to ensure return date is after borrow date
    public function date_check($tanggal_kembali_seharusnya)
    {
        $tanggal_pinjam = $this->input->post('tanggal_pinjam');
        if (strtotime($tanggal_kembali_seharusnya) < strtotime($tanggal_pinjam)) {
            $this->form_validation->set_message('date_check', 'Tanggal Kembali Seharusnya tidak boleh sebelum Tanggal Pinjam.');
            return FALSE;
        }
        return TRUE;
    }

    // Display form to return a book or process return
    public function return_book_form($borrowing_id = NULL)
    {
        // Only admin and user (petugas) can return books
        if ($this->session->userdata('level') == 'student') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk mengembalikan buku.');
            redirect('borrowings');
        }

        $data['borrowing'] = $this->Borrowing_model->get_borrowing_by_id($borrowing_id);

        if (empty($data['borrowing'])) {
            $this->session->set_flashdata('error', 'Data peminjaman tidak ditemukan.');
            redirect('borrowings');
        }

        if ($data['borrowing']->status == 'kembali') {
            $this->session->set_flashdata('error', 'Buku ini sudah dikembalikan.');
            redirect('borrowings');
        }

        $this->form_validation->set_rules('tanggal_dikembalikan', 'Tanggal Dikembalikan', 'required|date');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header');
            $this->load->view('borrowings/return_form', $data);
            $this->load->view('templates/footer');
        } else {
            $tanggal_dikembalikan = $this->input->post('tanggal_dikembalikan');

            if ($this->Borrowing_model->return_book($borrowing_id, $tanggal_dikembalikan)) {
                $this->session->set_flashdata('success', 'Buku berhasil dikembalikan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengembalikan buku atau buku sudah dikembalikan.');
            }
            redirect('borrowings');
        }
    }

    // Delete a borrowing record (admin only, use with caution)
    public function delete($id = NULL)
    {
        // Only admin can delete borrowing records
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menghapus riwayat peminjaman.');
            redirect('borrowings');
        }

        if ($this->Borrowing_model->delete_borrowing($id)) {
            $this->session->set_flashdata('success', 'Riwayat peminjaman berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus riwayat peminjaman atau tidak ditemukan.');
        }
        redirect('borrowings');
    }
}
