<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Borrowing_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
        $this->load->model('Book_model'); // Memuat Book_model untuk update stok
        $this->load->model('Member_model'); // Memuat Member_model untuk mendapatkan detail anggota
    }

    // Mengambil semua data peminjaman (bisa difilter nanti)
    public function get_all_borrowings()
    {
        $this->db->select('borrowings.*, members.nama as member_nama, books.judul as book_judul');
        $this->db->from('borrowings');
        $this->db->join('members', 'members.id = borrowings.member_id');
        $this->db->join('books', 'books.id = borrowings.book_id');
        $this->db->order_by('tanggal_pinjam', 'DESC'); // Urutkan berdasarkan tanggal pinjam terbaru
        $query = $this->db->get();
        return $query->result();
    }

    // Mengambil detail peminjaman berdasarkan ID
    public function get_borrowing_by_id($id)
    {
        $this->db->select('borrowings.*, members.nama as member_nama, books.judul as book_judul');
        $this->db->from('borrowings');
        $this->db->join('members', 'members.id = borrowings.member_id');
        $this->db->join('books', 'books.id = borrowings.book_id');
        $this->db->where('borrowings.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Menambahkan peminjaman baru
    public function add_borrowing($data)
    {
        // Pastikan stok buku berkurang saat dipinjam
        $book_id = $data['book_id'];
        $book = $this->Book_model->get_book_by_id($book_id);
        if ($book && $book->stok > 0) {
            $this->db->trans_start(); // Mulai transaksi database
            $this->db->insert('borrowings', $data);
            $this->Book_model->update_book($book_id, ['stok' => $book->stok - 1]);
            $this->db->trans_complete(); // Selesaikan transaksi

            return $this->db->trans_status(); // Mengembalikan status transaksi
        }
        return FALSE; // Gagal jika stok tidak cukup atau buku tidak ditemukan
    }

    // Mengupdate status peminjaman menjadi 'kembali' dan menghitung denda
    public function return_book($borrowing_id, $tanggal_dikembalikan)
    {
        $borrowing = $this->get_borrowing_by_id($borrowing_id);

        if (!$borrowing || $borrowing->status == 'kembali') {
            return FALSE; // Peminjaman tidak ditemukan atau sudah dikembalikan
        }

        $tanggal_kembali_seharusnya = new DateTime($borrowing->tanggal_kembali_seharusnya);
        $tanggal_dikembalikan_obj = new DateTime($tanggal_dikembalikan);

        $total_hari_terlambat = 0;
        $denda = 0;

        if ($tanggal_dikembalikan_obj > $tanggal_kembali_seharusnya) {
            $interval = $tanggal_dikembalikan_obj->diff($tanggal_kembali_seharusnya);
            $total_hari_terlambat = $interval->days;
            $denda = 2250 * $total_hari_terlambat; // Denda Rp. 2.250 per hari
        }

        $data_update = array(
            'tanggal_dikembalikan' => $tanggal_dikembalikan,
            'status'               => 'kembali',
            'total_hari_terlambat' => $total_hari_terlambat,
            'denda'                => $denda
        );

        // Pastikan stok buku bertambah saat dikembalikan
        $book_id = $borrowing->book_id;
        $book = $this->Book_model->get_book_by_id($book_id);

        $this->db->trans_start(); // Mulai transaksi database
        $this->db->where('id', $borrowing_id);
        $this->db->update('borrowings', $data_update);
        $this->Book_model->update_book($book_id, ['stok' => $book->stok + 1]);
        $this->db->trans_complete(); // Selesaikan transaksi

        return $this->db->trans_status(); // Mengembalikan status transaksi
    }

    // Menghapus record peminjaman (jarang dilakukan, biasanya hanya update status)
    public function delete_borrowing($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('borrowings');
    }
}
