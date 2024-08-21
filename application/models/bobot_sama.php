<?php
class bobot_sama extends CI_Model
{
    function __construct()
    {
        // Set tabel name
        $this->table = 'bobot_sama';
    }

    public function get_pekerjaan_sama($id_pekerjaan)
    {
        $this->db->where('id_subkriteria', $id_pekerjaan);
        return $this->db->get($this->table)->result_array();
    }

    public function get_all_pekerjaan_sama()
    {
        return $this->db->get($this->table);
    }

    public function set_pekerjaan_sama($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function delete_pekerjaan_sama($id_pekerjaansama)
    {
        $where = array(
            "id_pekerjaansama" => $id_pekerjaansama
        );
        $this->db->delete($this->table, $where);
    }
}
