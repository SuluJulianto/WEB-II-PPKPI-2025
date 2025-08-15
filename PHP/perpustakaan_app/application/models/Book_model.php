<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    // Mengambil semua data buku
    public function get_all_books()
    {
        $query = $this->db->get('books'); // Mengambil semua data dari tabel 'books'
        return $query->result(); // Mengembalikan hasil dalam bentuk array of objects
    }

    // Mengambil data buku berdasarkan ID
    public function get_book_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('books');
        return $query->row(); // Mengembalikan satu baris hasil query
    }

    // Menambahkan buku baru
    public function add_book($data)
    {
        return $this->db->insert('books', $data); // Memasukkan data ke tabel 'books'
    }

    // Mengupdate data buku
    public function update_book($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('books', $data); // Mengupdate data di tabel 'books'
    }

    // Menghapus buku
    public function delete_book($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('books'); // Menghapus data dari tabel 'books'
    }
}
