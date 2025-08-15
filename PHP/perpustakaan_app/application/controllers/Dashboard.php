<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    // Konstruktor untuk memuat library dan helper yang dibutuhkan
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session'); // Library untuk manajemen session
        $this->load->helper('url');      // Helper untuk URL

        // Cek apakah user sudah login. Jika belum, arahkan ke halaman login.
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Fungsi default untuk menampilkan dashboard
    public function index()
    {
        // Ambil data session user
        $data['username'] = $this->session->userdata('username');
        $data['level'] = $this->session->userdata('level');

        // Memuat view dashboard dengan data user
        $this->load->view('dashboard_view', $data);
    }
}
