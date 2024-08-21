<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proses extends CI_Controller
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
        $navigasi = '<a href="' . base_url('admin/dashboard') . '">Dashboard</a> / ' . $title;
        return $navigasi;
    }

    private function faktorial($digit)
    {
		if ($digit < 0) {
			return 0; // Atau Anda dapat memutuskan bagaimana menangani angka negatif
		}
        $total = 1;
        for ($i = 1; $i <= $digit; $i++) {
            $total = $total * $i;
        }
        return $total;
    }

    private function jum_perbandingan($angka)
    {
		if ($angka < 2) {
			return 0; // Atau nilai lain yang sesuai jika angka kurang dari 2 tidak valid
		}
        // Rumus pairwise comparasion
        $rumus = $this->faktorial($angka) / ($this->faktorial(2) * $this->faktorial(($angka - 2)));
        return $rumus;
    }

    // **** Function untuk AHP

    /**
     * Membuat matrix comparison AHP matrix for => var[kolom][baris] | x = kolom, y = baris, memiliki return $matrix_comp
     * @param integer $n total kriteria
     * @param int $set_radio variabel set_radio dari db perbandingan
     * @param int $nilai_perb_arr nilai dari perbandingan elemen prioritas
     * @return array tersimpan array 'matrik' dan 'total'
     */
    private function matrix_comparison($n, $set_radio, $nilai_perb_arr)
    {
        // ** Membuat matrix perbandingan
        // Matrix for => var[kolom][baris]
        // x = kolom
        // y = baris
        $matrik = array();
        $urut = 0;

		for ($x = 0; $x <= ($n - 2); $x++) {
            for ($y = ($x + 1); $y <= ($n - 1); $y++) {
                if ($set_radio[$urut] == 1) {
                    $matrik[$x][$y] = $nilai_perb_arr[$urut];
                    $matrik[$y][$x] = 1 / $nilai_perb_arr[$urut];
                } else {
                    $matrik[$x][$y] = 1 / $nilai_perb_arr[$urut];
                    $matrik[$y][$x] = $nilai_perb_arr[$urut];
                }
                $urut++;
            }
        
        }

        for ($x = 0; $x < $n; $x++) {
            $matrik[$x][$x] = 1;
        }

        // Total
        $total = array(0, 0, 0, 0, 0, 0, 0);
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $total[$x] += $matrik[$y][$x];
            }
        }

        $matrix_comp = array(
            'matrik' => $matrik,
            'total' => $total
        );

        return $matrix_comp;
    }

    /**
     * Membuat matrix normalisasi AHP matrix for => var[kolom][baris] | x = kolom, y = baris, memiliki return $matrik_normalisasi
     * @param integer $n total kriteria
     * @param array $matrik matrik dari function matrik_comp()
     * @param int $total total dari function matrik_comp()
     * @return array tersimpan array 'normalisasi', 'prioritas', 'total_norm', 'jumlah'
     */
    private function matrik_normalisasi($n, $matrik, $total)
    {
        $normalisasi = array();
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $normalisasi[$y][$x] = $matrik[$y][$x] / $total[$x];
            }
        }

        $prioritas = array(0, 0, 0, 0, 0, 0, 0);
        $total_norm = array(0, 0, 0, 0, 0, 0, 0);
        $jumlah = array(0, 0, 0, 0, 0, 0, 0);
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $jumlah[$x] += $normalisasi[$x][$y];
                $total_norm[$x] += $normalisasi[$y][$x];
            }
            $prioritas[$x] = $jumlah[$x] / $n;
        }

        $matrik_normalisasi = array(
            'normalisasi' => $normalisasi,
            'prioritas' => $prioritas,
            'total_norm' => $total_norm,
            'jumlah' => $jumlah
        );

        return $matrik_normalisasi;
    }

    /**
     * Membuat matrix Penjumlahan tiap baris AHP matrix for => var[kolom][baris] | x = kolom, y = baris, memiliki return $matrik_ptb
     * 
     * @param integer $n total kriteria/subkriteria
     * @param array $matrik matrik dari function matrik_comp()
     * @param int $prioritas total dari function matrik_normalisasi()
     * @return array tersimpan array 'penjuml_tiap_bar', 'jumlah_tiap_bar'
     */
    private function matrik_ptb($n, $matrik, $prioritas)
    {
        $penjuml_tiap_bar = array();
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $penjuml_tiap_bar[$y][$x] = $matrik[$y][$x] * $prioritas[$x];
            }
        }

        $jumlah_tiap_bar = array(0, 0, 0, 0, 0, 0, 0);
        for ($x = 0; $x < $n; $x++) {
            for ($y = 0; $y < $n; $y++) {
                $jumlah_tiap_bar[$x] += $penjuml_tiap_bar[$x][$y];
            }
        }

        $matrik_ptb = array(
            'penjuml_tiap_bar' => $penjuml_tiap_bar,
            'jumlah_tiap_bar' => $jumlah_tiap_bar
        );

        return $matrik_ptb;
    }

    /**
     * Membuat Rasio Consistensi AHP matrix, memiliki return $matrik_normalisasi
     * 
     * @param integer $n total kriteria/subkriteria
     * @param array $jumlah_tiap_bar array dari function matrik_ptb()
     * @param int $prioritas total dari function matrik_normalisasi()
     * @return array tersimpan array 'penjuml_tiap_bar', 'jumlah_tiap_bar'
     */
    private function consistensi_rasio($n, $jumlah_tiap_bar, $prioritas)
    {
        $nilai = array(0, 0, 0, 0, 0, 0, 0);
        $jumlah_nilai = 0;
        for ($x = 0; $x < $n; $x++) {
            $nilai[$x] = $jumlah_tiap_bar[$x] / $prioritas[$x];
            $jumlah_nilai += $nilai[$x];
        }

        $rasio_konsistensi = array(
            'nilai' => $nilai,
            'jumlah_nilai' => $jumlah_nilai
        );

        return $rasio_konsistensi;
    }

    /**
     * Menghitung Consistensi Index
     * 
     * @param integer $eigen nilai dari jumlah nilai / total kriteria 
     * @param integer $n total kriteria atau subkriteria
     * @return integer nilai consistensi index
     */
    private function consistensi_index($eigen, $n)
    {
        $ci = ($eigen - $n) / ($n - 1);
        return $ci;
    }
    // End Function AHP

    public function index()
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Proses AHP';
        $data = [
            'spk' => 'prosesAhp',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($title),
        ];

        $kriteria = $this->model_kriteria->data_kriteria_on()->result_array();
        $cek_bobot = array();
        $i = 0;
        foreach ($kriteria as $kr) {
            $cek_bobot[$i++] = $kr['bobot'];
        }
        $data['cek'] = $cek_bobot;
        $data['kriteria'] = $kriteria;

		$data['title_page'] = 'Proses table | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


		
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/proses/proses_table', $data);
        $this->load->view('templates/footer');

        
    }

    public function proses_kriteria($accept = null)
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Proses AHP - Kriteria';
        $data = [
            'spk' => 'prosesAhp',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/proses') . '">Proses AHP</a> / ' . $title),
        ];

        // Ambil data dari model
        $kriteria = $this->model_kriteria->data_kriteria_on()->result_array();
        $nilai_perb = $this->model_kriteria->get_perbandingan_kriteria()->result_array();
        // end

        // Inisialisasi dan push to array kriteria array
        $kriteria_arr = array();
        foreach ($kriteria as $kr) {
            array_push($kriteria_arr, $kr['nama_kriteria']);
        }
        // end

        // Inisialisasi dan push to array nilai perbandingan array
        $nilai_perb_arr = array();
        $set_radio = array();
        foreach ($nilai_perb as $np) {
            array_push($nilai_perb_arr, $np['nilai_perband']);
            array_push($set_radio, $np['set_radio']);
        }
        // end

        $n = count($kriteria_arr);

        //** membuat matrik perbandingan
        $matrik_comp = $this->matrix_comparison($n, $set_radio, $nilai_perb_arr);
        //** end matrik perbandingan

        // ** matrik normalisasi
        $matrik_normalisasi = $this->matrik_normalisasi($n, $matrik_comp['matrik'], $matrik_comp['total']);
        // ** end normalisasi

        // ** Matrix penjumlahan tiap baris
        $matrik_ptb = $this->matrik_ptb($n, $matrik_comp['matrik'], $matrik_normalisasi['prioritas']);
        // ** end matrix penjumlahan tiap baris

        // ** Rasio konsistensi 
        // menghitung rasio
        $rasio_konsistensi = $this->consistensi_rasio($n, $matrik_ptb['jumlah_tiap_bar'], $matrik_normalisasi['prioritas']);
        // end menghitung rasio

        // Nilai eigen
        $eigen = $rasio_konsistensi['jumlah_nilai'] / $n;
        // end nilai eigen

        // Ambil dari db IR
        $cons_index = $this->consistensi_index($eigen, $n);
        $ir = $this->model_ir->get_ir($n)->row_array();
        $cons_rasio = $cons_index / $ir['nilai_ir'];

        // cek CR dibawah 0.1 adalah konsisten
        if ($cons_rasio < 0.1) {
            $data['pesan'] = '<div class="alert alert-success alert-dismissible fade show" role="alert"> Rasio Konsistensi dibawah 0.1 <br>Silahkan lanjut ke tahapan selanjutnya. 
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        } else {
            $data['pesan'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Rasio Konsistensi <strong>diatas 0.1</strong> ! <br> Silahkan kembali konfigurasi prioritas elemen kriteria.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        }

        // ** end Rasio konsistensi

        // Data bobot diinputkan ke tabel kriteria 
        if ($accept != null && $accept == 1) {
            for ($i = 0; $i < $n; $i++) {
                $update = array(
                    'bobot' => $matrik_normalisasi['prioritas'][$i]
                );

                $this->model_kriteria->update_bobot_kriteria($kriteria_arr[$i], $update);
            }

            redirect('manual/subkriteria');
        }
        // end tombol

        /** 
         * ===============================
         * Inisialisasi Variabel
         * ===============================
         */


        // Matrik comparison
        $data['kriteria_arr'] = $kriteria_arr;
        $data['matrik'] = $matrik_comp['matrik'];
        $data['total'] = $matrik_comp['total'];
        // end matrix comparison

        // Matrik normalisasi
        $data['normalisasi'] = $matrik_normalisasi['normalisasi'];
        $data['jumlah_normalisasi'] = $matrik_normalisasi['jumlah'];
        $data['prioritas'] = $matrik_normalisasi['prioritas'];
        $data['total_norm'] = $matrik_normalisasi['total_norm'];
        // End Matrik normalisasi

        // Matrix penjumlahan tiap baris
        $data['penjumlahan_tiap_baris'] = $matrik_ptb['penjuml_tiap_bar'];
        $data['jumlah_tiap_baris'] = $matrik_ptb['jumlah_tiap_bar'];
        // End matrix penjumlahan tiap baris

        // Rasio Konsistensi
        $data['data_ir'] = $this->model_ir->data_ir()->result_array();
        $data['nilai'] = $rasio_konsistensi['nilai'];
        $data['jumlah_nilai'] = $rasio_konsistensi['jumlah_nilai'];
        $data['eigen'] = $eigen;
        $data['cons_index'] = $cons_index;
        $data['ir'] = $ir['nilai_ir'];
        $data['cons_rasio'] = $cons_rasio;
        // End rasio konsistensi

     
		$data['title_page'] = 'Proses kriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/proses/proses_kriteria', $data);
        $this->load->view('templates/footer');
		
       
    }


    public function proses_subkriteria($id_krit, $accept = null)
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Proses AHP - SubKriteria';
        $data = [
            'spk' => 'prosesAhp',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi(' <a href="' . base_url('manual/proses') . '">Proses AHP</a> / ' . $title),
        ];

        // Ambil data dari model
        $sub_kriteria = $this->model_subkriteria->data_subkriteria($id_krit)->result_array();
        $nilai_perb = $this->model_subkriteria->get_perbandingan_subkrit($id_krit)->result_array();
        // end

        // Inisialisasi dan push to array kriteria array
        $subkrit_arr = array();
        $id_subkrit_arr = array();
        foreach ($sub_kriteria as $kr) {
            array_push($id_subkrit_arr, $kr['id_subkriteria']);
            array_push($subkrit_arr, $kr['nama_subkriteria']);
        }
        // end

        // Inisialisasi dan push to array nilai perbandingan array
        $nilai_perb_arr = array();
        $set_radio = array();
        foreach ($nilai_perb as $np) {
            array_push($nilai_perb_arr, $np['nilai_perband']);
            array_push($set_radio, $np['set_radio']);
        }
        // end

        $n = count($subkrit_arr);

        //** membuat matrik perbandingan
        $matrik_comp = $this->matrix_comparison($n, $set_radio, $nilai_perb_arr);
        //** end matrik perbandingan

        // ** matrik normalisasi
        $matrik_normalisasi = $this->matrik_normalisasi($n, $matrik_comp['matrik'], $matrik_comp['total']);
        // ** end normalisasi

        // ** Matrix penjumlahan tiap baris
        $matrik_ptb = $this->matrik_ptb($n, $matrik_comp['matrik'], $matrik_normalisasi['prioritas']);
        // ** end matrix penjumlahan tiap baris

        // ** Rasio konsistensi 
        // menghitung rasio
        $rasio_konsistensi = $this->consistensi_rasio($n, $matrik_ptb['jumlah_tiap_bar'], $matrik_normalisasi['prioritas']);
        // end menghitung rasio

        // Nilai eigen
        $eigen = $rasio_konsistensi['jumlah_nilai'] / $n;
        // end nilai eigen

        // Ambil dari db IR
        $cons_index = $this->consistensi_index($eigen, $n);
        $ir = $this->model_ir->get_ir($n)->row_array();

        if ($ir['nilai_ir'] == 0) {
            $cons_rasio = $cons_index / 10;
        } else {
            $cons_rasio = $cons_index / $ir['nilai_ir'];
        }


        // cek CR dibawah 0.1 adalah konsisten
        if ($cons_rasio < 0.1) {
            $data['pesan'] = '<div class="alert alert-success alert-dismissible fade show" role="alert"> Rasio Konsistensi dibawah 0.1 <br>Silahkan lanjut ke tahapan selanjutnya. 
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        } else {
            $data['pesan'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert"> Rasio Konsistensi <strong>diatas 0.1</strong> ! <br> Silahkan kembali konfigurasi prioritas elemen kriteria.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        }

        // ** end Rasio konsistensi

        // Data bobot diinputkan ke tabel kriteria 
        if ($accept != null && $accept == 1) {
            for ($i = 0; $i < $n; $i++) {
                $update = array(
                    'bobot' => $matrik_normalisasi['prioritas'][$i]
                );

                $this->model_subkriteria->update_bobot_kriteria($id_subkrit_arr[$i], $update);
            }

            redirect('manual/subkriteria');
        }
        // end tombol

        // Tambahan variable
        $data['id_krit'] = $id_krit;
        // End Tambahan
        // Matrik comparison
        $data['data_ir'] = $this->model_ir->data_ir()->result_array();
        $data['subkrit_arr'] = $subkrit_arr;
        $data['matrik'] = $matrik_comp['matrik'];
        $data['total'] = $matrik_comp['total'];
        // end matrix comparison

        // Matrik normalisasi
        $data['normalisasi'] = $matrik_normalisasi['normalisasi'];
        $data['jumlah_normalisasi'] = $matrik_normalisasi['jumlah'];
        $data['prioritas'] = $matrik_normalisasi['prioritas'];
        $data['total_norm'] = $matrik_normalisasi['total_norm'];
        // End Matrik normalisasi

        // Matrix penjumlahan tiap baris
        $data['penjumlahan_tiap_baris'] = $matrik_ptb['penjuml_tiap_bar'];
        $data['jumlah_tiap_baris'] = $matrik_ptb['jumlah_tiap_bar'];
        // End matrix penjumlahan tiap baris

        // Rasio Konsistensi
        $data['nilai'] = $rasio_konsistensi['nilai'];
        $data['jumlah_nilai'] = $rasio_konsistensi['jumlah_nilai'];
        $data['eigen'] = $eigen;
        $data['cons_index'] = $cons_index;
        $data['ir'] = $ir['nilai_ir'];
        $data['cons_rasio'] = $cons_rasio;
        // End rasio konsistensi

		$data['title_page'] = 'Proses subkriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('manual/proses/proses_subkriteria', $data);
        $this->load->view('templates/footer');

    }
}
