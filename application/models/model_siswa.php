<?php
class model_siswa extends CI_Model
{

    function __construct()
    {
        // Set tabel name
        $this->table = 'tb_siswa';
    }

    public function data_siswa()
    {
        return $this->db->get($this->table);
    }

    public function siswa_periode($id)
    {
        $where = array('tb_siswa.id_periode' => $id);
        $this->db->join('tb_periode', 'tb_periode.id_periode = tb_siswa.id_periode');
        return $this->db->get_where('tb_siswa', $where);
    }

    public function tambah_siswa($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function get_siswa($id)
    {
        return $this->db->get_where($this->table, $id);
    }

    public function update_siswa($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
        return $this->db->error();
    }

    public function delete_siswa($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_column_name()
    {
        return $this->db->query("SHOW COLUMNS FROM $this->table");
    }

    public function get_sum_pekerjaan()
    {
        return $this->db->query("SELECT COUNT(*) as jumlah, pekerjaan FROM tb_siswa GROUP BY pekerjaan");
    }
}
