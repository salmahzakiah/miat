<?php
class model_subkriteria extends CI_Model
{

    function __construct()
    {
        // Set tabel name
        $this->table1 = 'sub_kriteria';
        $this->table2 = 'perbandingan_subkriteria';
    }

    public function data_subkriteria_all()
    {
        return $this->db->get($this->table1);
    }

    public function data_subkriteria($kriteria)
    {
        $where = "id_kriteria = " . $kriteria;
        $this->db->where($where);
        return $this->db->get($this->table1);
    }

    public function get_subkriteria($id)
    {
        $this->db->where('id_subkriteria =', $id);
        return $this->db->get($this->table1);
    }

    public function get_subkriteria_withName($name_kriteria)
    {
        return $this->db->query("SELECT * FROM sub_kriteria WHERE id_kriteria = (SELECT id_kriteria FROM kriteria WHERE nama_kriteria = '$name_kriteria')");
    }

    public function insert_subKrit($data)
    {
        $this->db->insert($this->table1, $data);
    }

    public function update_all_subkrit_null($id_krit)
    {
        $data = array('bobot' => null);
        $this->db->where("id_kriteria =" . $id_krit);
        $this->db->update($this->table1, $data);
    }

    public function update_subKrit($id, $data)
    {
        $this->db->where("id_subkriteria =" . $id);
        $this->db->update($this->table1, $data);
    }

    public function hapus_sub($id)
    {
        $where = array('id_subkriteria' => $id);
        $this->db->delete($this->table1, $where);
    }

    public function get_perbandingan_subkrit($id_krit)
    {
        return $this->db->query("SELECT * FROM perbandingan_subkriteria WHERE id_subkriteria1 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit) OR id_subkriteria2 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit)");
    }

    public function cek_data_perb($id_krit)
    {
        $query = $this->db->query("SELECT * FROM perbandingan_subkriteria WHERE id_subkriteria1 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit) OR id_subkriteria2 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit)")->result_array();

        return count($query);
    }

    public function delete_perbandingan_subkrit($id_krit)
    {
        $this->db->query("DELETE FROM perbandingan_subkriteria WHERE id_subkriteria1 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit) OR id_subkriteria2 IN (SELECT id_subkriteria FROM sub_kriteria WHERE id_kriteria = $id_krit)");
    }

    public function update_bobot_kriteria($where, $data)
    {
        $this->db->where('id_subkriteria', $where);
        $this->db->update($this->table1, $data);
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

    public function get_subkriteria_pekerjaan()
    {
        $this->db->join('kriteria', 'kriteria.id_kriteria = sub_kriteria.id_kriteria');
        $this->db->where('nama_kriteria', 'pekerjaan');
        return $this->db->get($this->table1);
    }
}
