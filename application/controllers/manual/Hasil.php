<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil extends CI_Controller
{
    private function pick_three_word($val)
    {
        $str = explode(" ", $val);
        $name_str = "";

        if (count($str) > 3) {
            $name_str = $str[0] . " " . $str[1] . " " . $str[2] . "...";
        } else {
            $name_str = $val;
        }


        return $name_str;
    }

    private function navigasi($title)
    {
        $navigasi = '<a href="' . base_url('dashboard') . '">Dashboard</a> / ' . $title;
        return $navigasi;
    }

    public function index()
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Implementasi AHP';
        $data = [
            'spk' => 'hasil',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($title),
        ];

        // Cek apakah ada bobot kriteria atau bobot subkriteria yang masih null?
        $bbt_kriteria = $this->model_kriteria->data_kriteria()->result_array();


        $cek_kriteria = 0;

        $sub_bobot_cek = array();
        $total_subkr = array();
        // cek kriteria & subrkiteria bobot masih null?
        $i = 0;
        foreach ($bbt_kriteria as $bk) {
            if ($bk['bobot'] == null) {
                $cek_kriteria++;
            }

            // cek subkriteria
            $bbt_subkriteria = $this->model_subkriteria->data_subkriteria($bk['id_kriteria'])->result_array();

            $cek_subkriteria = 0;
            $total = 0;
            foreach ($bbt_subkriteria as $bsk) {
                if ($bsk['bobot'] == null) {
                    $cek_subkriteria++;
                }
                $total++;
            }

            $sub_bobot_cek[$bk['nama_kriteria']] = $cek_subkriteria;
            $total_subkr[$bk['nama_kriteria']] = $total;
        }



        // print_r($sub_bobot_cek);
        // end


        if ($cek_kriteria == count($bbt_kriteria)) {
            $data['cek_kriteria'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Kriteria Masih Belum Ada Bobot 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        } else {
            $data['cek_kriteria'] = '';
        }



        // Buat tabel untuk mau diimplementasikan di periode mana?
        $data['periode'] = $this->model_periode->tahun_periode();

        // Cek in alert
        $data['cek_subkriteria'] = $sub_bobot_cek;
        $data['kriteria'] = $bbt_kriteria;
        $data['total_subkr'] = $total_subkr;

		$data['title_page'] = 'Hasil | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/hasil/hasil', $data);
		$this->load->view('templates/footer');

    }

    public function cek_implementasi($id_periode)
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Cek Data Terhadap SubKriteria';
        $data = [
            'spk' => 'hasil',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/hasil') . '">Implementasi AHP</a> / ' . $title),
        ];

        $data_siswa = $this->model_siswa->siswa_periode($id_periode);

        $pekerjaan = $this->model_subkriteria->get_subkriteria_withName('pekerjaan')->result_array();

        $tanggungan = $this->model_subkriteria->get_subkriteria_withName('tanggungan')->result_array();

		$status_siswa = $this->model_subkriteria->get_subkriteria_withName('status_siswa')->result_array();



        // cek data terlebih dahulu
        $i = 0;
        $simpan = array();
        foreach ($data_siswa->result_array() as $dp) {

            // kelas
            if (!is_numeric($dp['kelas'])) {
                $simpan[$i]['id_siswa'] = $dp['id_siswa'];
                $simpan[$i]['nama'] = $dp['nama'];
                $simpan[$i]['kelas'] = 0;
            }

            // Tanggungan
            if (!is_numeric($dp['tanggungan'])) {
                $simpan[$i]['id_siswa'] = $dp['id_siswa'];
                $simpan[$i]['nama'] = $dp['nama'];
                $simpan[$i]['tanggungan'] = 0;
            }

            // pekerjaan
            $temp = 0;
            foreach ($pekerjaan as $p) {
                $pekerjaan_sama = $this->bobot_sama->get_pekerjaan_sama($p['id_subkriteria']);

                if (count($pekerjaan_sama) > 0) {
                    foreach ($pekerjaan_sama as $ps) {

                        if (($dp['pekerjaan'] == $p['nama_subkriteria']) || ($dp['pekerjaan'] == $ps['nama_pekerjaansama'])) {
                            $temp++;
                        }
                    }
                } else {
                    if ($dp['pekerjaan'] == $p['nama_subkriteria']) {
                        $temp++;
                    }
                }
            }
            if ($temp == 0) {
                $simpan[$i]['id_siswa'] = $dp['id_siswa'];
                $simpan[$i]['nama'] = $dp['nama'];
                $simpan[$i]['pekerjaan'] = $temp;
            }

            // Penghasilan
            if (!is_numeric($dp['penghasilan'])) {
                $simpan[$i]['id_siswa'] = $dp['id_siswa'];
                $simpan[$i]['nama'] = $dp['nama'];
                $simpan[$i]['penghasilan'] = 0;
            }

          

            // Status Siswa
            $temp = 0;
            foreach ($status_siswa as $p) {
                if ($dp['status_siswa'] == $p['nama_subkriteria']) {
                    $temp++;
                }
            }
            if ($temp == 0) {
                $simpan[$i]['id_siswa'] = $dp['id_siswa'];
                $simpan[$i]['nik'] = $dp['nik'];
                $simpan[$i]['status_siswa'] = $temp;
            }

            $i++;
        }

        // Show error
        $data['error_data'] = $simpan;

        $data['id_periode'] = $id_periode;
        $data['pekerjaan'] = $pekerjaan;
        $data['tanggungan'] = $tanggungan;
        $data['status_siswa'] = $status_siswa;
        $data['siswa'] = $data_siswa->result_array();

		$data['title_page'] = 'Cek Kriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/hasil/cek_kriteria', $data);
        $this->load->view('templates/footer');

    }
	private function subtitusiBobot($column, $data_siswa, $kr_bobot)
{
    $score = array();  // Inisialisasi array score
    $no_p = 0;  // Inisialisasi counter siswa

    // Loop melalui setiap siswa
    foreach ($data_siswa->result_array() as $dp) {
        $score[$no_p]['id_siswa'] = $dp['id_siswa'];  // Set ID siswa

        // Loop melalui setiap kolom yang relevan
        for ($i = 0; $i < count($column); $i++) {
            $nilai_bobot = 0;  // Inisialisasi nilai dengan 0
            
            // Loop melalui setiap kriteria bobot
            foreach ($kr_bobot as $kr) {
                // Cek apakah kolom saat ini cocok dengan kriteria
                if ($column[$i] == $kr['nama_kriteria']) {
                    // Ambil subkriteria yang relevan
                    $subkr_bobot = $this->model_subkriteria->data_subkriteria($kr['id_kriteria'])->result_array();
                    
                    // Loop melalui setiap subkriteria untuk menentukan bobot
                    foreach ($subkr_bobot as $sbb) {
                        if (is_numeric($dp[$column[$i]])) {
                            $pieces = explode(" ", $sbb['nama_subkriteria']);

                            // Pengecekan kondisi yang relevan
                            if (count($pieces) == 3) {
                                if ($pieces[1] == "-") {
                                    if ($pieces[0] <= $dp[$column[$i]] && $dp[$column[$i]] <= $pieces[2]) {
                                        $nilai_bobot = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == "<") {
                                    if ($dp[$column[$i]] <= $pieces[2]) {
                                        $nilai_bobot = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == ">") {
                                    if ($pieces[2] <= $dp[$column[$i]]) {
                                        $nilai_bobot = $kr['bobot'] * $sbb['bobot'];
                                    }
                                }
                            }
                        } else {
                            if ($dp[$column[$i]] == $sbb['nama_subkriteria']) {
                                $nilai_bobot = $kr['bobot'] * $sbb['bobot'];
                            }
                        }
                    }
                }
            }

            // Masukkan nilai bobot ke dalam array score
            $score[$no_p][$i] = $nilai_bobot;
        }
        $no_p++;  // Tambahkan counter untuk siswa berikutnya
    }

    return $score;
}



	private function jumTotalBobot($score)
{
    $total = array();
    
    foreach ($score as $sc) {
        if (isset($sc['id_siswa'])) { // Pastikan 'id_siswa' ada dalam array
            $temp = 0;

            // Iterasi melalui nilai-nilai array $sc
            foreach ($sc as $key => $value) {
                // Abaikan kunci 'id_siswa' jika ada
                if ($key != 'id_siswa') {
                    $temp += $value;
                }
            }
            
            $total[] = array(
                'id_siswa' => $sc['id_siswa'],
                'total' => $temp
            );
        }
    }

    return $total;
}

	

    public function implementWBobot($id_periode, $accept = null, $export = null)
	
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Proses Subtitusi Bobot AHP';
        $data = [
            'spk' => 'hasil',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/hasil') . '">Implementasi AHP</a> / ' . ' <a href="' . base_url('manual/hasil/cek_implementasi/') . $id_periode . '">Cek Data Terhadap SubKriteria </a> / ' . $title),
        ];

        // get data siswa berdasarkan periode
        $data_siswa = $this->model_siswa->siswa_periode($id_periode);

        // get data kriteria bobot
        $kr_bobot = $this->model_kriteria->data_kriteria_on()->result_array();

        // get nama kolom tabel siswa
        $column = array();
        $column2 = array();
        $nm_column = $this->model_siswa->get_column_name()->result_array();
        for ($i = 6; $i < count($nm_column); $i++) {
            if ($i !=30 ) {
                array_push($column, $nm_column[$i]['Field']);
                array_push($column2, $nm_column[$i]['Field']);
            }
        }

        $column2[6] = "status_siswa";
        $nm_column[30]['Field'] = "status_siswa";


        // buat kolom untuk ditampilin di view
        $column_tb = array();
        foreach ($kr_bobot as $kr) {
            array_push($column_tb, $kr['nama_kriteria']);
        }

        // print_r($column_tb);
        // echo "<br>";

        // Proses subtitusi 
        $score = $this->subtitusiBobot($column, $data_siswa, $kr_bobot);
        // end proses subtitusi

        // echo "<br>";
        // print_r($score[0]);

        // Jumlah 1 baris untuk mulai diurutkan
        $total = $this->jumTotalBobot($score);
        // End proses total

        // Insert ke tabel alternatif
        if ($accept != null && $accept == 1) {

            $this->model_alternatif->delete_exist_alternatif($id_periode);
            foreach ($total as $ahp) {
                $data = [
                    'id_siswa' => $ahp['id_siswa'],
                    'skor' => $ahp['total'],
                ];
                $this->model_alternatif->insert_alternatif($data);
            }

            redirect('manual/hasil/scoring/' . $id_periode);
        }

        $data['id_periode'] = $id_periode;
        $data['siswa'] = $data_siswa->result_array();
        $data['column'] = $column_tb;
        $data['score'] = $score;
        $data['total'] = $total;


        // // print_r($total);

		$data['title_page'] = 'Hasil Urut | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
	

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/hasil/hasil_urut', $data);
        $this->load->view('templates/footer');

    }
	public function scoring($id_periode, $accept = null)
	{
		$nama_user = $this->session->userdata('nama');
        $title = 'Proses Scoring Dan Status';
        $data = [
            'spk' => 'hasil',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/hasil') . '">Implementasi AHP</a> / ' . ' <a href="' . base_url('manual/hasil/cek_implementasi/') . $id_periode . '">Cek Data Terhadap SubKriteria </a> / ' . ' <a href="' . base_url('manual/hasil/implementWBobot/') . $id_periode . '">Proses Subtitusi Bobot AHP </a> / ' . $title),
        ];
		// Ambil data alternatif
        $alternatif = $this->model_alternatif->sort_alternatif($id_periode)->result_array();
	
		// Ambil data periode
		$periode = $this->model_periode->tahun_periode_id($id_periode)->row_array();
	
		// Inisialisasi array $score
		$score = array();
		$i = 0;
		foreach ($alternatif as $al) {
            if ($i <= $periode['kuota'] - 1) {
                $score[$i] = array(
                    'id_siswa' => $al['id_siswa'],
                    'nama' => $al['nama'],
                    'nik' => $al['nik'],
                    'alamat' => $al['alamat'],
                    'score' => $al['skor'],
                    'status' => 'Diterima'
                );
            } else {
                $score[$i] = array(
                    'id_siswa' => $al['id_siswa'],
                    'nama' => $al['nama'],
                    'nik' => $al['nik'],
                    'alamat' => $al['alamat'],
                    'score' => $al['skor'],
                    'status' => 'Ditolak'
                );
            }
            $i++;
        }
		
		// Jika ada parameter accept, proses update status
		if ($accept != null && ($accept == 1)) {

			foreach ($score as $sc) {

				$cek = $this->model_penerima->cek_status($sc['id_siswa']);
				
				
                if ($cek->num_rows() != 0) {
                    $update = array(
                        'tgl_penerima' => date("Y-m-d"),
                        'status' => $sc['status']
                    );

                    $this->model_penerima->update_status($sc['id_siswa'], $update);
                } else {
                    $insert = array(
                        'tgl_penerima' => date("Y-m-d"),
                        'id_siswa' => $sc['id_siswa'],
                        'status' => $sc['status']
                    );

                    $this->model_penerima->insert_status($insert);
                }
			}
			
			redirect('penerima/index/' . $id_periode);
		}
	
		// Kirim data ke view
		$data['data_scroring'] = $score;
		$data['id_periode'] = $id_periode;

		$data['title_page'] = 'Score desc | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		

		// Load view
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('manual/hasil/score_desc', $data);
		$this->load->view('templates/footer');
	}
	

    public function cek_akurasi($id_periode)
    {
        $this->load->library("excel");

        $nama_user = $this->session->userdata('nama');
        $title = 'Cek Akurasi Data';
        $data = [
            'spk' => 'hasil',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/hasil') . '">Implementasi AHP</a> / ' . ' <a href="' . base_url('manual/hasil/cek_implementasi/') . $id_periode . '">.</a> / ' . ' <a href="' . base_url('manual/hasil/implementWBobot/') . $id_periode . '">. </a> / ' . ' <a href="' . base_url('manual/hasil/scoring/') . $id_periode . '">Proses Scoring dan Status </a> / ' . $title),
        ];

        $this->form_validation->set_rules('file', 'File', 'callback_import_validation');


        // Inisialisasi
        $alternatif = $this->model_alternatif->sort_alternatif($id_periode)->result_array();
        $periode = $this->model_periode->tahun_periode_id($id_periode)->row_array();

        // Input array
        $score = array();
        $i = 0;
        foreach ($alternatif as $al) {
            if ($i <= $periode['kuota'] - 1) {
                $score[$i] = array(
                    'id_siswa' => $al['id_siswa'],
                    'nama' => $al['nama'],
                    'nik' => $al['nik'],
                    'alamat' => $al['alamat'],
                    'score' => $al['skor'],
                    'status' => 'Diterima'
                );
            } else {
                $score[$i] = array(
                    'id_siswa' => $al['id_siswa'],
                    'nama' => $al['nama'],
                    'nik' => $al['nik'],
                    'alamat' => $al['alamat'],
                    'score' => $al['skor'],
                    'status' => 'Ditolak'
                );
            }
            $i++;
        }
        // End 

        $data['hasil_ahp'] = $score;
        $data['id_periode'] = $id_periode;

		
		$data['title_page'] = 'Cek akurasi | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/hasil/cek_akurasi', $data);
        $this->load->view('templates/footer');
    }

    public function import_validation()
    {
        if (isset($_FILES['file'])) {
            $allowed = ['xls', 'xlsx'];

            if (empty($_FILES['file']['name'])) {
                $this->session->set_flashdata('import_validation', "Field tidak boleh kosong!");
                return false;
            } else if (!in_array(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION), $allowed)) {
                $this->session->set_flashdata('import_validation', 'File extensi bukan file excel');
                return false;
            } else if ($_FILES['file']['size'] >= 10485760) {
                $this->session->set_flashdata('import_validation', 'File Max 10mb' . ', Ukuran file yang diupload: ' . $_FILES['file']['size']);
                return false;
            } else {
                return true;
            }
        }
    }
	
}
