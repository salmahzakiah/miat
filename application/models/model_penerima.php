<?php
class model_penerima extends CI_Model
{

		// Mengambil data penerima dengan status diurutkan
		public function siswa_status_periode($id_periode)
		{
			$this->db->join('tb_periode', 'tb_periode.id_periode = tb_siswa.id_periode');
			$this->db->join('tb_penerima', 'tb_penerima.id_siswa = tb_siswa.id_siswa');
			$this->db->where('tb_periode.id_periode', $id_periode);
			$this->db->order_by('tb_penerima.status', 'ASC'); // Mengurutkan berdasarkan status
			return $this->db->get('tb_siswa');
		}
	
		// Mengambil data penerima diterima
		public function siswa_diterima($id_periode)
		{
			$this->db->join('tb_periode', 'tb_periode.id_periode = tb_siswa.id_periode');
			$this->db->join('tb_penerima', 'tb_penerima.id_siswa = tb_siswa.id_siswa');
			$this->db->where('tb_periode.id_periode', $id_periode);
			$this->db->where('tb_penerima.status', 'Diterima');
			return $this->db->get('tb_siswa');
		}
	
		// Mengambil data penerima ditolak
		public function siswa_ditolak($id_periode)
		{
			$this->db->join('tb_periode', 'tb_periode.id_periode = tb_siswa.id_periode');
			$this->db->join('tb_penerima', 'tb_penerima.id_siswa = tb_siswa.id_siswa');
			$this->db->where('tb_periode.id_periode', $id_periode);
			$this->db->where('tb_penerima.status', 'Ditolak');
			return $this->db->get('tb_siswa');
		}
	
	
    public function siswa($id_periode)
    {
        $where = array('id_periode' => $id_periode);
        return $this->db->query("SELECT * FROM tb_siswa LEFT JOIN tb_periode USING (id_periode) LEFT JOIN tb_penerima USING (id_siswa) WHERE id_periode = $id_periode");
    }

    

    public function siswa_wstatus()
    {
        $this->db->join('tb_penerima', 'tb_penerima.id_siswa = tb_siswa.id_siswa');
        return $this->db->get('tb_siswa');
    }


    public function siswa_cstatus($id)
    {
        $this->db->join('tb_penerima', 'tb_penerima.id_siswa = tb_siswa.id_siswa');
        $this->db->where('tb_siswa.id_siswa', $id);
        return $this->db->get('tb_siswa');
    }

	public function hapus_penerima($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function insert_status($data)
    {
        $this->db->insert('tb_penerima', $data);
    }

    public function update_status($id, $data)
    {
        $this->db->where('id_siswa', $id);
        $this->db->update('tb_penerima', $data);
    }

    public function getPenerima($dari, $sampai)
    {
        return $this->db->query("SELECT * FROM tb_penerima 
        INNER JOIN tb_siswa USING (id_siswa) 
        INNER JOIN tb_periode USING (id_periode) 
        WHERE tanggal_awal >= '$dari' AND tanggal_akhir <= '$sampai'");
    }

    public function getPenerima_diterima($dari, $sampai)
    {
        return $this->db->query("SELECT * FROM tb_penerima 
        INNER JOIN tb_siswa USING (id_siswa) 
        INNER JOIN tb_periode USING (id_periode) 
        WHERE tanggal_awal >= '$dari' AND tanggal_akhir <= '$sampai' AND status = 'Diterima'");
    }

    public function cek_status($id)
    {
        $this->db->where('id_siswa =', $id);
        return $this->db->get('tb_penerima');
    }

    public function update_dana($id, $data)
    {
        $this->db->where('id_penerima', $id);
        $this->db->update('tb_penerima', $data);
    }
	
	public function get_status_by_periode($id_periode)
    {
        $this->db->where('id_periode', $id_periode);
        return $this->db->get('tb_penerima');
    }
	public function sort_alternatif($id_periode) {
		$this->db->select('id_penerima, nama, nik, kelas, nama_orangtua, pekerjaan, tanggungan, status_siswa');
		$this->db->from('penerima');
		$this->db->where('id_periode', $id_periode);
		$this->db->order_by('skor', 'DESC');
		return $this->db->get();
	}
	
}
