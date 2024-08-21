<?php
class model_kriteria extends CI_Model
{

    function __construct()
    {
        // Set tabel name
        $this->table1 = 'kriteria';
        $this->table2 = 'perbandingan_kriteria';
    }

    public function data_kriteria()
    {
        return $this->db->get($this->table1);
    }

    public function data_kriteria_on()
    {
        $this->db->where("toggle = " . 1);
        return $this->db->get($this->table1);
    }

    public function get_data_kriteria($id)
    {
        $this->db->where("id_kriteria = " . $id);
        return $this->db->get($this->table1);
    }

    public function get_perbandingan_kriteria()
    {
        return $this->db->get($this->table2);
    }

    public function cek_data_perb()
    {
        return $this->db->count_all($this->table2);
    }

    public function insert_data_perb($data)
    {
        $this->db->insert($this->table2, $data);
    }

    public function update_if_exist($data, $where)
    {
        $this->db->where($where);
        $this->db->update($this->table2, $data);
    }

    public function update_bobot_kriteria($where, $data)
    {
        $this->db->where('nama_kriteria', $where);
        $this->db->update($this->table1, $data);
    }

    public function update_toggle($data, $id)
    {
        $this->db->where('id_kriteria', $id);
        $this->db->update($this->table1, $data);
    }

    public function reset()
    {
        $this->db->empty_table($this->table2);
    }
}
