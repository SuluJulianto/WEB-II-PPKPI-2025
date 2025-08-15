<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Konstruktor
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Memuat library database
    }

    // Fungsi untuk mendapatkan data user berdasarkan username
    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users'); // Mengambil data dari tabel 'users'
        return $query->row(); // Mengembalikan satu baris hasil query
    }

    // Fungsi untuk menambahkan user baru (misalnya untuk setup awal admin)
    public function add_user($data)
    {
        // Password harus di-hash sebelum disimpan
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->db->insert('users', $data);
    }

    // Fungsi untuk mendapatkan semua user (untuk manajemen petugas oleh admin)
    public function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Fungsi untuk mendapatkan user berdasarkan ID
    public function get_user_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

	// KODE YANG SUDAH DIPERBAIKI (HANYA 3 BARIS)
	public function update_user($id, $data)
	{
		// Hapus semua logika if-else dan hashing di sini.
		// Model hanya bertugas menyimpan data yang sudah siap dari controller.
		$this->db->where('id', $id);
		return $this->db->update('users', $data);
	}

    // Fungsi untuk menghapus user
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
