<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load the database library
    }

    // Get all members from the 'members' table
    public function get_all_members()
    {
        $query = $this->db->get('members');
        return $query->result(); // Return results as an array of objects
    }

    // Get a single member by ID
    public function get_member_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('members');
        return $query->row(); // Return a single row object
    }

    // Add a new member
    public function add_member($data)
    {
        return $this->db->insert('members', $data);
    }

    // Update an existing member
    public function update_member($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('members', $data);
    }

    // Delete a member by ID
    public function delete_member($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('members');
    }
}
