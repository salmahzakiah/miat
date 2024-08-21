<?php
class model_periode extends CI_Model
{
    function __construct()
    {
        $this->table = 'tb_periode';
    }

	public function tahun_periode()
	{
		$query = $this->db->get('tb_periode');
		if ($query->num_rows() > 0) {
			return $query->result_array(); // Pastikan ini mengembalikan array hasil
		} else {
			return []; // Jika tidak ada data, kembalikan array kosong
		}
	}
	
    public function tahun_periode_id($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_periode');
    }
	public function sort_alternatif($id_periode) {
		$this->db->where('id_periode', $id_periode);
		return $this->db->get('alternatif');
	}
	
	
		public function get_by_id($id_periode) {
			$this->db->where('id_periode', $id_periode);
			$query = $this->db->get('tb_periode');
			return $query->row_array(); // Pastikan ini digunakan jika hanya mengambil satu baris
		}

	
	

    public function get_new_periode()
    {
        $this->db->limit(1);
        $this->db->order_by('tanggal_awal', 'DESC');
        return $this->db->get('tb_periode');
    }

	
    public function get_periode($where)
    {
        return $this->db->get_where($this->table, $where);
    }

    public function delete_periode($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function update_periode($where, $data)
    {
        $this->db->where($where);
        $this->db->update($this->table, $data);
    }


    public function insert_periode($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function get_anggaran_periode()
    {
        return $this->db->query('SELECT nama_periode, anggaran FROM tb_periode');
    }

    public function sum_anggaran()
    {
        $query = $this->db->query("SELECT SUM(anggaran) as jumlah FROM tb_periode")->row_array();
        return $query['jumlah'];
    }

    public function getCountSiswaPerPeriode()
    {
        $query = $this->db->query("SELECT nama_periode, COUNT(nama) AS jumlah FROM tb_siswa INNER JOIN tb_periode USING(id_periode) GROUP BY nama_periode ORDER BY id_periode ASC");
        return $query;
    }

    

	public function get_current_period() {
        $this->db->order_by('id_periode', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tb_periode');
        return $query->row()->id_periode;
    }

	public function getNamaPeriodeUseAHP()
{
    $this->db->select('id_periode, nama_periode');
    $this->db->from('tb_periode'); // Pastikan tabel yang benar digunakan
    $this->db->where('spk_ahp', 1); // Kondisi yang relevan
    $query = $this->db->get();

    if ($query === false) {
        log_message('error', 'Query gagal dijalankan: ' . $this->db->last_query());
        return false; // Return false jika query gagal
    }

    return $query; // Return query object jika berhasil
}


}
