<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_view extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');         // Helper untuk URL
        $this->load->model('Book_model');    // Memuat Book_model untuk pencarian buku
    }

    // Menampilkan halaman pencarian buku untuk siswa
    public function book_search()
    {
        $search_query = $this->input->get('q'); // Ambil query pencarian dari URL

        if (!empty($search_query)) {
            // Jika ada query pencarian, cari buku berdasarkan judul, penulis, atau penerbit
            $this->db->like('judul', $search_query);
            $this->db->or_like('penulis', $search_query);
            $this->db->or_like('penerbit', $search_query);
            $query = $this->db->get('books');
            $data['books'] = $query->result();
            $data['search_query'] = $search_query;
        } else {
            // Jika tidak ada query, tampilkan semua buku (opsional, atau kosongkan)
            $data['books'] = $this->Book_model->get_all_books();
            $data['search_query'] = '';
        }

        $this->load->view('student_view/book_search', $data);
    }
}
