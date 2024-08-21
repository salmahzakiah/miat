<?php

class user_model extends CI_Model
{
    public function get_data()
    {
        return $this->db->get('user')->result_array();
    }

    public function getNamaTerang($id_user)
    {
        $this->db->select('nama_terang');
        $this->db->where('id_user', $id_user);
        return $this->db->get('user')->row_array();
    }

    public function setNamaTerang($data, $where)
    {
        $this->db->where('id_user', $where);
        $this->db->update('user', $data);
    }

    public function get_data_wid($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('user')->row_array();
    }

    public function update_data($data, $id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }

    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function update_password($email, $password) {
        $data = array(
            'password' => password_hash($password, PASSWORD_BCRYPT)
        );
        $this->db->where('email', $email);
        return $this->db->update('users', $data);
    }
}


