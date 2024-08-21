<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

	private function navigasi($title)
    {
		
        $navigasi = '<a href="' . base_url('admin/dashboard') . '">Dashboard</a> / ' . $title;
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
		$data['periode'] = $this->model_periode->tahun_periode();  // Ubah hasil query menjadi array

        // Cek in alert
        $data['cek_subkriteria'] = $sub_bobot_cek;
        $data['kriteria'] = $bbt_kriteria;
        $data['total_subkr'] = $total_subkr;

		$data['title_page'] = 'Hasil | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/hasil/hasil', $data);
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
            'navigasi' => $this->navigasi(' <a href="' . base_url('spk/hasil') . '">Implementasi AHP</a> / ' . $title),
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
                $simpan[$i]['tanggungan'] = $dp['id_siswa'];
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
        $this->load->view('spk/hasil/cek_kriteria', $data);
        $this->load->view('templates/footer');

    }

    private function subtitusiBobot($column, $data_siswa, $kr_bobot)
    {
        $column2 = $column;
        $column2[5] = "status_siswa";

        // print_r($kr_bobot[3]['nama_kriteria']);
        // echo "<br>";
        // print_r($column2[0]);

        $no_p = 0;
        $score = array();
        foreach ($data_siswa->result_array() as $dp) {
            for ($i = 0; $i < count($column); $i++) {

                $j = 0;

                foreach ($kr_bobot as $kr) {
                    if ($column2[$i] == $kr['nama_kriteria']) {
                        // input tiap kolom array
                        $score[$no_p]['id_siswa'] = $dp['id_siswa'];
                        // $score[$no_p][$column[$i]] = $kr['bobot'];

                        // subkriteria
                        $subkr_bobot = $this->model_subkriteria->data_subkriteria($kr['id_kriteria'])->result_array();

                        foreach ($subkr_bobot as $sbb) {

                            $operator = "";
                            $pieces = explode(" ", $sbb['nama_subkriteria']);


                            if (count($pieces) == 3) {
                                if ($pieces[1] == "-") {

                                    // $operator = $pieces[0] . " <= " . $dp[$column[$i]] . " && " . $dp[$column[$i]] . " <= " . $pieces[2];

                                    if ($pieces[0] <= $dp[$column[$i]] && $dp[$column[$i]] <= $pieces[2]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == "&lt;") {
                                    if ($dp[$column[$i]] <= $pieces[2]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == "&gt;") {
                                    // $operator = $pieces[2] . " <= " . $dp[$column[$i]];

                                    if ($pieces[2] <= $dp[$column[$i]]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                }

                                // if ($operator) {
                                //     $score[$no_p][$i] = $kr['bobot'] * $sbb['bobot'];
                                // }
                            } else {
                                $pekerjaan_sama = $this->bobot_sama->get_pekerjaan_sama($sbb['id_subkriteria']);

                                if (count($pekerjaan_sama) > 0) {
                                    foreach ($pekerjaan_sama as $ps) {
                                        if (($dp[$column[$i]] == $sbb['nama_subkriteria']) || ($dp[$column[$i]] == $ps['nama_pekerjaansama'])) {
                                            $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                        }
                                    }
                                } else {
                                    if ($dp[$column[$i]] == $sbb['nama_subkriteria']) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                }
                            }
                        }
                    }
                    $j++;
                }
            }
            $no_p++;
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
            'navigasi' => $this->navigasi(' <a href="' . base_url('spk/hasil') . '">Implementasi AHP</a> / ' . ' <a href="' . base_url('spk/hasil/cek_implementasi/') . $id_periode . '">Cek Data Terhadap SubKriteria </a> / ' . $title),
        ];

        // get data siswa berdasarkan periode
        $data_siswa = $this->model_siswa->siswa_periode($id_periode);

        // get data kriteria bobot
        $kr_bobot = $this->model_kriteria->data_kriteria_on()->result_array();

        // get nama kolom tabel siswa
        $column = array();
        $column2 = array();
        $nm_column = $this->model_siswa->get_column_name()->result_array();
        for ($i = 4; $i < count($nm_column); $i++) {
            if ($i != 20) {
                array_push($column, $nm_column[$i]['Field']);
                array_push($column2, $nm_column[$i]['Field']);
            }
        }

        $column2[4] = "status_siswa";
        $nm_column[9]['Field'] = "status_siswa";


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

            redirect('spk/hasil/scoring/' . $id_periode);
        }

        // print_r($score[0]);

        // Export to Excel 
        if ($export != null && $export == 1) {
            $this->load->library("excel");
            $object = new PHPExcel();
            $alfabet = array('C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L');

            $object->setActiveSheetIndex(0);
            $object->getActiveSheet()->setCellValue('A1', 'No');
            $object->getActiveSheet()->setCellValue('B1', 'Nama');
            $k = 0;
            foreach ($kr_bobot as $kr) {
                $object->getActiveSheet()->setCellValue($alfabet[$k] . '1', $kr['nama_kriteria']);
                $k++;
            }
            $object->getActiveSheet()->setCellValue($alfabet[$k] . '1', 'Total');


            $excel_row = 2;
            $no = 1;
            $i = 0;

            foreach ($data_siswa->result_array() as $val) {
                $a = 0;

                $object->getActiveSheet()->setCellValue('A' . $excel_row, $no);
                $object->getActiveSheet()->setCellValue('B' . $excel_row, $val['nama']);

                for ($j = 0; $j < count($column_tb); $j++) {
                    $object->getActiveSheet()->setCellValue($alfabet[$a] . $excel_row, $score[$i][$j]);

                    $a++;
                }

                $object->getActiveSheet()->setCellValue($alfabet[$a] . $excel_row, $total[$i]['total']);



                $i++;
                $no++;
                $excel_row++;
            }


            $filename = "Data_Siswa" . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');



            $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            $writer->save('php://output');

            exit;
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
        $this->load->view('spk/hasil/hasil_urut', $data);
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
            'navigasi' => $this->navigasi(' <a href="' . base_url('spk/hasil') . '">Implementasi AHP</a> / ' . ' <a href="' . base_url('spk/hasil/cek_implementasi/') . $id_periode . '">Cek Data Terhadap SubKriteria </a> / ' . ' <a href="' . base_url('spk/hasil/implementWBobot/') . $id_periode . '">Proses Subtitusi Bobot AHP </a> / ' . $title),
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
		$this->load->view('spk/hasil/score_desc', $data);
		$this->load->view('templates/footer');
	}
	
	public function cetak()
    {
        $data['title'] = 'Cetak Laporan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $cek_periode = $this->model_periode->get_new_periode()->num_rows();

		 // ambil data periode yang sudah menggunakan spk
		 $periodeUseAHP = $this->model_periode->getNamaPeriodeUseAHP();
if ($periodeUseAHP !== false) {
    $periodeUseAHP = $periodeUseAHP->result_array();
} else {
    // Handle error di sini, misalnya dengan menampilkan pesan error atau default value
    $periodeUseAHP = [];
    log_message('error', 'Tidak ada data yang diambil dari getNamaPeriodeUseAHP.');
}




 		$title = 'Cetak Laporan';
        $data = [
            'title' => $title,
            'navigasi' => $this->navigasi($title),
            'periode' => $this->model_periode->tahun_periode(),
            'useAHP' => $periodeUseAHP,
            'cek_periode' => $cek_periode,
        ];
		
		$data['title_page'] = 'Cetak | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('about/cetak/cetak', $data);
        $this->load->view('templates/footer');
	}
	
	public function printlaporanSkor()
{
    // Mengambil data periode dari formulir
    $periode = htmlspecialchars($this->input->post('periodeAHP'));

    // Mengambil data dari model
    $periode_db = $this->model_periode->tahun_periode_id($periode)->row_array();

    // Cek apakah $periode_db tidak null sebelum mengakses elemen array
    if ($periode_db) {
        $data['dari'] = $periode_db['tanggal_awal'];
        $data['sampai'] = $periode_db['tanggal_akhir'];
    } else {
        // Jika $periode_db null, Anda bisa memberikan nilai default atau menampilkan error
        $data['dari'] = 'Tanggal tidak tersedia';
        $data['sampai'] = 'Tanggal tidak tersedia';
        log_message('error', 'Data periode tidak ditemukan untuk ID: ' . $periode);
    }

    // Mengambil data skor dari model alternatif
    $rekomendasi = $this->model_alternatif->sort_alternatif($periode)->result_array();

    // Menyusun data untuk view
    $data['nama_terang'] = $this->get_nama_terang(); // Ambil nama terang jika diperlukan

    // Memuat view untuk pencetakan
    $this->load->view('about/cetak/print_laporan', $data);
}


    private function get_nama_terang()
    {
        // Fungsi untuk mengambil nama terang atau bisa langsung didefinisikan di controller
        // Contoh implementasi:
        return 'Encup Supyan, S.Pd.I'; // Ganti dengan nama yang sesuai atau logika untuk mengambil nama
    }
}

    


    