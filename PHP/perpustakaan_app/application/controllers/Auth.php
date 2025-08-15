<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    // Konstruktor untuk memuat library dan model yang dibutuhkan
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation'); // Library untuk validasi form
        $this->load->library('session');         // Library untuk manajemen session
        $this->load->helper('url');              // Helper untuk URL
        $this->load->model('User_model');        // Memuat User_model untuk interaksi database
    }

    // Fungsi default, akan dialihkan ke halaman login
    public function index()
    {
        redirect('auth/login');
    }

    // Menampilkan halaman login
    public function login()
    {
        // Jika user sudah login, arahkan ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Memuat view login
        $this->load->view('auth/login');
    }

    // Memproses otentikasi login
    public function authenticate()
    {
        // Aturan validasi untuk username dan password
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        // Jika validasi gagal, kembali ke halaman login
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors()); // Set pesan error validasi
            $this->load->view('auth/login');
        } else {
            // Ambil data dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Coba dapatkan user dari database berdasarkan username
            $user = $this->User_model->get_user_by_username($username);

            // Verifikasi user dan password
            if ($user && password_verify($password, $user->password)) {
                // Jika kredensial benar, set data session
                $session_data = array(
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'level'     => $user->level,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);

                // Arahkan ke dashboard
                redirect('dashboard');
            } else {
                // Jika kredensial salah, set pesan error dan kembali ke login
                $this->session->set_flashdata('error', 'Username atau password salah.');
                $this->load->view('auth/login');
            }
        }
    }

    // Fungsi untuk logout
    public function logout()
    {
        // Hapus semua data session
        $this->session->unset_userdata(array('user_id', 'username', 'level', 'logged_in'));
        $this->session->sess_destroy(); // Hancurkan session

        // Set pesan sukses dan arahkan ke halaman login
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('auth/login');
    }

}
