<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends CI_Controller {

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
        $total = 1;
        for ($i = 1; $i <= $digit; $i++) {
            $total = $total * $i;
        }
        return $total;
    }

    private function jum_perbandingan($angka)
    {
        // Rumus pairwise comparasion
        $rumus = $this->faktorial($angka) / ($this->faktorial(2) * $this->faktorial(($angka - 2)));
        return $rumus;
    }

    public function index()
    {

		$data['title'] = 'Prioritas Elemen Kriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $nama_user = $this->session->userdata('nama');
        $title = 'Perbandigan Kriteria';
        $data = [
            'spk' => 'kriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($title),
        ];

        $kriteria = $this->model_kriteria->data_kriteria_on();
        $perbandingan = $this->model_kriteria->get_perbandingan_kriteria()->result_array();

        // **Mencari jumlah pairwase comparasion
        $jumlah = $this->jum_perbandingan(count($kriteria->result_array()));
        // **End 

        // Masukan array untuk dilihat kembali konfigurasi
        $nilai_perb = array();
        $set_radio = array();
        foreach ($perbandingan as $per) {
            array_push($nilai_perb, $per['nilai_perband']);
            array_push($set_radio, $per['set_radio']);
        }
        // end

        // Masukan array untuk membuat perbandingan
        $id_kriteria_arr = array();
        $kriteria_arr = array();
        foreach ($kriteria->result_array() as $p) {
            array_push($id_kriteria_arr, $p['id_kriteria']);
            array_push($kriteria_arr, $p['nama_kriteria']);
        }
        // End masukan array

        // Safe to variabel array 
        // db perbandingan kriteria
        $data['db_set_radio'] = $set_radio;
        $data['nilai_perb'] = $nilai_perb;

        // db kriteria
        $data['id_kriteria'] = $id_kriteria_arr;
        $data['kriteria_arr'] = $kriteria_arr;
        $data['jum_perbandingan'] = $jumlah;

		$data['title_page'] = 'Perbandingan Kriteria';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
       
		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/kriteria/index', $data);
        $this->load->view('templates/footer');
    }

    public function kriteria_masuk($jum)
    {
        // Inisialisasi data
        $nilai_elemen = array();
        $pilihan = array();
        $array_kriteria1 = $this->input->post('kriteria1');
        $array_kriteria2 = $this->input->post('kriteria2');
        // end 

        // Get data dari form
        for ($i = 0; $i < $jum; $i++) {
            array_push($pilihan, substr($this->input->post('nilaiElemen' . $i), -1));
            array_push($nilai_elemen, substr($this->input->post('nilaiElemen' . $i), 0, 1));
        }
        // end         

        //** input into database

        // * cek tb perbandingan ada tidak? 
        $cek_jumlah = $this->model_kriteria->cek_data_perb();

        if ($cek_jumlah == 0) {
            for ($i = 0; $i < $jum; $i++) {
                $data = [
                    'id_kriteria1' => $array_kriteria1[$i],
                    'id_kriteria2' => $array_kriteria2[$i],
                    'nilai_perband' => $nilai_elemen[$i],
                    'set_radio' => $pilihan[$i]
                ];

                // insert data to table perbandingan
                $this->model_kriteria->insert_data_perb($data);
            }

            $insert = $this->db->affected_rows() != 1 ? false : true;

            if ($insert == 1) {
                echo "Sukses Insert";
                $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Nilai Perbandingan Berhasil Di-input</div>');

                redirect('spk/proses/proses_kriteria');
            } else {
                echo "Gagal Insert";
                redirect('spk/kriteria');
            }
        } else {
            for ($i = 0; $i < $jum; $i++) {
                $data = [
                    'nilai_perband' => $nilai_elemen[$i],
                    'set_radio' => $pilihan[$i]
                ];

                $where = "id_kriteria1 = " . $array_kriteria1[$i] . " AND id_kriteria2 = " . $array_kriteria2[$i];
                $this->model_kriteria->update_if_exist($data, $where);
            }

            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Nilai Perbandingan Berhasil Di-input</div>');
            redirect('spk/proses/proses_kriteria');
        }
        // * end cek 
        //** end input database
    }

    public function config()
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Konfigurasi Kriteria';
        $data = [
            'spk' => 'kriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi('<a href="' . base_url('spk/kriteria') . '">Perbandingan Kriteria</a> / ' . $title),
        ];

        $data['kriteria'] = $this->model_kriteria->data_kriteria()->result_array();

		$data['title_page'] = 'Config Kriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
       

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/kriteria/config_kriteria', $data);
        $this->load->view('templates/footer');
        
    }

    public function config_input()
    {
        $kriteria = $this->model_kriteria->data_kriteria()->result_array();
        $toggle = $this->input->post('toggle');

        // untuk setting toggle 
        if (!empty($toggle)) {
            foreach ($kriteria as $kr) {
                $acc = 0;
                $updt_tggl = array();

                foreach ($toggle as $tg) {
                    if ($kr['id_kriteria'] == $tg) {
                        $acc = 1;
                    }
                }

                if ($acc == 1) {
                    $updt_tggl = array(
                        'toggle' => 1
                    );
                } else {
                    $updt_tggl = array(
                        'toggle' => 0
                    );
                }

                $this->model_kriteria->update_toggle($updt_tggl, $kr['id_kriteria']);
            }
        } else {
            foreach ($kriteria as $kr) {
                $updt_tggl = array(
                    'toggle' => 0
                );
                $this->model_kriteria->update_toggle($updt_tggl, $kr['id_kriteria']);
            }
        }
        // End untuk setting toggle

        // Hapus bobot tiap kriteria
        foreach ($kriteria as $kr) {
            $data = array(
                'bobot' => 0
            );

            $this->model_kriteria->update_bobot_kriteria($kr['nama_kriteria'], $data);
        }
        // end hapus bobot tiap kriteria

        $this->reset_perbandingan();
        redirect('spk/kriteria');
    }

    public function reset_perbandingan()
    {
        $this->model_kriteria->reset();
    }
}
