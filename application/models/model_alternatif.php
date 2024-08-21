<?php
class model_alternatif extends CI_Model
{
    function __construct()
    {
        // Set tabel name
        $this->table = 'alternatif';
    }

    public function get_alternatif($id_periode)
    {
        return $this->db->query("SELECT * FROM alternatif WHERE id_siswa IN (SELECT id_siswa FROM tb_siswa WHERE id_periode = $id_periode)");
    }

    public function sort_alternatif($id_periode) {
        $this->db->select('*');
        $this->db->from('alternatif');
        $this->db->join('tb_siswa', 'alternatif.id_siswa = tb_siswa.id_siswa');
        $this->db->where('tb_siswa.id_periode', $id_periode);
        $this->db->order_by('skor', 'DESC');
        
        $query = $this->db->get();
        if ($query) {
            return $query;
        } else {
            log_message('error', 'Query failed: ' . $this->db->error()['message']);
            return FALSE;
        }
    }

    public function insert_alternatif($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function exist_alternatif_siswa ($id_periode)
    {
        $query = $this->db->query("SELECT * FROM alternatif WHERE id_siswa IN (SELECT id_siswa FROM tb_siswa WHERE id_periode = $id_periode)");
        return $query;
    }

    public function delete_exist_alternatif($id_periode)
    {
        $this->db->query("DELETE FROM alternatif WHERE id_siswa IN (SELECT id_siswa FROM tb_siswa WHERE id_periode = $id_periode)");
    }

    public function update_alternatif($where, $data)
    {
        $this->db->where('id_siswa', $where);
        $this->db->update($this->table, $data);
    }

    public function sortAlternatifPenerima($id_periode)
    {
        return $this->db->query("SELECT * FROM alternatif INNER JOIN tb_siswa USING(id_siswa) INNER JOIN tb_penerima USING (id_siswa) WHERE id_siswa IN (SELECT id_siswa FROM tb_siswa WHERE id_periode = $id_periode) ORDER BY skor DESC ");
    }
}
