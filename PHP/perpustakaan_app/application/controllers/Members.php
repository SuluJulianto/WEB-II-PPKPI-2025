<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation'); // For form validation
        $this->load->model('Member_model');      // Load Member_model

        // Check if user is logged in. If not, redirect to login page.
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Display list of members
    public function index()
    {
        $data['members'] = $this->Member_model->get_all_members(); // Get all member data
        $data['level'] = $this->session->userdata('level'); // Get user level for access control in view
        $this->load->view('templates/header');
        $this->load->view('members/index', $data); // Load member list view
        $this->load->view('templates/footer');
    }

    // Display add member form or process addition
    public function add()
    {
        // Only admin can add members
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menambah anggota.');
            redirect('members');
        }

        // Form validation rules
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required|numeric|is_unique[members.nis]'); // NIS must be unique
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails or first time accessing form, display form
            $this->load->view('templates/header');
            $this->load->view('members/form');
            $this->load->view('templates/footer');
        } else {
            // If validation succeeds, process member addition
            $data = array(
                'nama'         => $this->input->post('nama'),
                'nis'          => $this->input->post('nis'),
                'alamat'       => $this->input->post('alamat'),
                'no_telepon'   => $this->input->post('no_telepon')
            );

            if ($this->Member_model->add_member($data)) {
                $this->session->set_flashdata('success', 'Anggota berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan anggota.');
            }
            redirect('members'); // Redirect back to member list
        }
    }

    // Display edit member form or process editing
    public function edit($id = NULL)
    {
        // Only admin can edit members
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk mengedit anggota.');
            redirect('members');
        }

        $data['member'] = $this->Member_model->get_member_by_id($id); // Get member data by ID

        // If member not found
        if (empty($data['member'])) {
            $this->session->set_flashdata('error', 'Anggota tidak ditemukan.');
            redirect('members');
        }

        // Form validation rules (same as add, but unique rule ignores current ID)
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nis', 'NIS', 'required|numeric|callback_nis_check['.$id.']'); // Custom callback for unique NIS on edit
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
        $this->form_validation->set_rules('no_telepon', 'Nomor Telepon', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            // If validation fails or first time accessing form, display form with member data
            $this->load->view('templates/header');
            $this->load->view('members/form', $data);
            $this->load->view('templates/footer');
        } else {
            // If validation succeeds, process member update
            $data_update = array(
                'nama'         => $this->input->post('nama'),
                'nis'          => $this->input->post('nis'),
                'alamat'       => $this->input->post('alamat'),
                'no_telepon'   => $this->input->post('no_telepon')
            );

            if ($this->Member_model->update_member($id, $data_update)) {
                $this->session->set_flashdata('success', 'Anggota berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui anggota.');
            }
            redirect('members'); // Redirect back to member list
        }
    }

    // Custom callback for NIS uniqueness check on edit
    public function nis_check($nis, $id)
    {
        $this->db->where('nis', $nis);
        $this->db->where('id !=', $id); // Exclude current member's ID
        $query = $this->db->get('members');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('nis_check', 'NIS ini sudah terdaftar untuk anggota lain.');
            return FALSE;
        }
        return TRUE;
    }


    // Delete a member
    public function delete($id = NULL)
    {
        // Only admin can delete members
        if ($this->session->userdata('level') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk menghapus anggota.');
            redirect('members');
        }

        if ($this->Member_model->delete_member($id)) {
            $this->session->set_flashdata('success', 'Anggota berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus anggota atau anggota tidak ditemukan.');
        }
        redirect('members'); // Redirect back to member list
    }
}
