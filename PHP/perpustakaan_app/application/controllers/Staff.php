<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('User_model'); // Menggunakan User_model untuk manajemen user/staff

        // Pastikan user sudah login dan memiliki level 'admin'
        if (!$this->session->userdata('logged_in') || $this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
            redirect('auth/login');
        }
    }

    // Menampilkan daftar petugas
    public function index()
    {
        $data['staffs'] = $this->User_model->get_all_users(); // Ambil semua user (termasuk admin)
        $this->load->view('templates/header');
        $this->load->view('staff/index', $data); // Memuat view daftar petugas
        $this->load->view('templates/footer');
    }

    // Menampilkan form tambah petugas atau memproses penambahan
    public function add()
    {
        // Aturan validasi form
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('level', 'Level', 'required|in_list[admin,user]'); // Admin bisa membuat admin lain atau user

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal atau pertama kali akses form, tampilkan form
            $this->load->view('templates/header');
            $this->load->view('staff/form');
            $this->load->view('templates/footer');
        } else {
            // Jika validasi sukses, proses penambahan petugas
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'), // Password akan di-hash di model
                'level'    => $this->input->post('level')
            );

            if ($this->User_model->add_user($data)) {
                $this->session->set_flashdata('success', 'Petugas berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan petugas.');
            }
            redirect('staff'); // Kembali ke daftar petugas
        }
    }

// Menampilkan form edit petugas atau memproses pengeditan
public function edit($id = NULL)
{
    $data['staff'] = $this->User_model->get_user_by_id($id); // Ambil data user berdasarkan ID

    // Jika user tidak ditemukan
    if (empty($data['staff'])) {
        $this->session->set_flashdata('error', 'Petugas tidak ditemukan.');
        redirect('staff');
    }

    // ==========================================================
    // BAGIAN YANG DIPERBAIKI ADA DI BAWAH INI
    // ==========================================================

    // Aturan validasi form dasar
    $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check['.$id.']');
    $this->form_validation->set_rules('level', 'Level', 'required|in_list[admin,user]');

    // Aturan validasi KONDISIONAL untuk password
    // Aturan ini hanya berjalan JIKA kolom password diisi.
    if ($this->input->post('password')) {
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
    }

    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal atau pertama kali akses form, tampilkan form dengan data user
        $this->load->view('templates/header');
        $this->load->view('staff/form', $data); // Pastikan nama view ini benar
        $this->load->view('templates/footer');
    } else {
        // Jika validasi sukses, proses pengeditan user
        $data_update = array(
            'username' => $this->input->post('username'),
            'level'    => $this->input->post('level')
        );

        // Hanya update password jika diisi
        if (!empty($this->input->post('password'))) {
            // REKOMENDASI: Lakukan hashing di controller agar lebih aman dan terpusat
            $data_update['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        if ($this->User_model->update_user($id, $data_update)) {
            $this->session->set_flashdata('success', 'Data petugas berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data petugas.');
        }
        redirect('staff'); // Kembali ke daftar petugas
    }
}

    // Custom callback for username uniqueness check on edit
    public function username_check($username, $id)
    {
        $this->db->where('username', $username);
        $this->db->where('id !=', $id); // Exclude current user's ID
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', 'Username ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    // Menghapus petugas
    public function delete($id = NULL)
    {
        // Pastikan admin tidak bisa menghapus dirinya sendiri
        if ($this->session->userdata('user_id') == $id) {
            $this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
            redirect('staff');
        }

        if ($this->User_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'Petugas berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus petugas atau petugas tidak ditemukan.');
        }
        redirect('staff'); // Kembali ke daftar petugas
    }
}
