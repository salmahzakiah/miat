<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subkriteria extends CI_Controller
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
        $nama_user = $this->session->userdata('nama');
        $title = 'Konfigurasi Sub Kriteria';
        $data = [
            'spk' => 'subkriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($title),
        ];

        $kriteria = $this->model_kriteria->data_kriteria_on()->result_array();


        $exist_or_not_priority = array();
        $temp = 0;
        foreach ($kriteria as $kr) {
            $exist_or_not_priority[$temp++] = $this->model_subkriteria->cek_data_perb($kr['id_kriteria']);
        }


        $data['kriteria'] = $kriteria;
        $data['exist_or_no'] = $exist_or_not_priority;

		$data['title_page'] = 'Konfigurasi Subkriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/subkriteria/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambahsub($kriteria)
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Tambah Sub Kriteria';
        $submenu = "<a href=" . base_url('spk/subkriteria') . ">Konfigurasi Sub Kriteria</a> /";
        $data = [
            'spk' => 'subkriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($submenu . $title),
        ];

        $cek = $this->model_kriteria->get_data_kriteria($kriteria)->row_array();

        if ($cek['nama_kriteria'] == "penghasilan"  || $cek['nama_kriteria'] == "tanggungan") {
            $data['sub'] = "angka";
        } else {
            $data['sub'] = "not_angka";
        }
        $data['id_kriteria'] = $kriteria;

		$data['title_page'] = 'Tambah Subkriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/subkriteria/tambah_subkriteria', $data);
        $this->load->view('templates/footer');
    }

    public function edit_sub($id_subkriteria)
    {
        $nama_user = $this->session->userdata('nama');
        $title = 'Edit Sub Kriteria';
        $submenu = "<a href=" . base_url('spk/subkriteria') . ">Konfigurasi Sub Kriteria</a> /";
        $data = [
            'spk' => 'subkriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($submenu . $title),
        ];

        $subkrit_sama = $this->bobot_sama->get_pekerjaan_sama($id_subkriteria);

        $sub_kriteria = $this->model_subkriteria->get_subkriteria($id_subkriteria);
        $cek_to = $sub_kriteria->row_array();
        $cek = $this->model_kriteria->get_data_kriteria($cek_to['id_kriteria'])->row_array();


        $subkriteria = $sub_kriteria->row_array();

        if ($cek['nama_kriteria'] == "penghasilan" || $cek['nama_kriteria'] == "tanggungan") {
            $data['sub'] = "angka";

            $pisah = explode(" ", $subkriteria['nama_subkriteria']);
            $data['sub_kriteria'] = $subkriteria;
            $data['nilai1'] = $pisah[0];
            $data['antara'] = $pisah[1];
            $data['nilai2'] = $pisah[2];
        } else {
            $data['id_subkrit'] = $id_subkriteria;
            $data['subkrit_sama'] = $subkrit_sama;
            $data['sub'] = "not_angka";
            $data['sub_kriteria'] = $subkriteria;
        }
		$data['title_page'] = 'Edit Subkriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/subkriteria/edit_subkriteria', $data);
        $this->load->view('templates/footer');
    }

    public function update_subKrit($id)
    {
        $subkriteria = htmlspecialchars($this->input->post('subkriteria'));

        $data = array(
            'nama_subkriteria' => $subkriteria
        );

        $this->model_subkriteria->update_subKrit($id, $data);
        $update = $this->db->affected_rows() != 1 ? false : true;

        if ($update == 1) {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil ubah Subkriteria</div>');
            redirect('spk/subkriteria');
        } else {
            redirect('spk/subkriteria');
        }
    }

    public function update_subKrit_angka($id)
    {
        $nilai1 = htmlspecialchars($this->input->post('nilai1'));
        $operator = htmlspecialchars($this->input->post('antara'));
        $nilai2 = htmlspecialchars($this->input->post('nilai2'));

        $string = $nilai1 . " " . $operator . " " . $nilai2;

        $data = array(
            'nama_subkriteria' => $string
        );

        $this->model_subkriteria->update_subKrit($id, $data);
        $update = $this->db->affected_rows() != 1 ? false : true;

        if ($update == 1) {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil ubah Subkriteria</div>');
            redirect('spk/subkriteria');
        } else {
            redirect('spk/subkriteria');
        }
    }

    public function insert_subKrit($kriteria)
    {
        $subkriteria = htmlspecialchars($this->input->post('subkriteria'));

        $data = array(
            'id_kriteria' => $kriteria,
            'nama_subkriteria' => $subkriteria
        );

        // delete bobot
        $this->model_subkriteria->update_all_subkrit_null($kriteria);
        // delete perbandingan sebelumnya
        $this->model_subkriteria->delete_perbandingan_subkrit($kriteria);

        $this->model_subkriteria->insert_subKrit($data);
        $insert = $this->db->affected_rows() != 1 ? false : true;

        if ($insert == 1) {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil Ditambahkan Subkriteria</div>');
            redirect('spk/subkriteria');
        } else {
            redirect('spk/subkriteria/tambahsub' . $kriteria);
        }
    }

    public function insert_subKrit_angka($kriteria)
    {
        $nilai1 = htmlspecialchars($this->input->post('nilai1'));
        $operator = htmlspecialchars($this->input->post('antara'));
        $nilai2 = htmlspecialchars($this->input->post('nilai2'));

        $string = $nilai1 . " " . $operator . " " . $nilai2;

        $data = array(
            'id_kriteria' => $kriteria,
            'nama_subkriteria' => $string
        );

        // delete bobot
        $this->model_subkriteria->update_all_subkrit_null($kriteria);
        // delete perbandingan sebelumnya
        $this->model_subkriteria->delete_perbandingan_subkrit($kriteria);

        // Insert
        $this->model_subkriteria->insert_subKrit($data);
        $insert = $this->db->affected_rows() != 1 ? false : true;

        if ($insert == 1) {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil Ditambahkan Subkriteria</div>');
            redirect('spk/subkriteria');
            redirect('spk/subkriteria');
        } else {
            redirect('spk/subkriteria/tambahsub' . $kriteria);
        }
    }

    public function hapus_sub($id_subkriteria, $kriteria)
    {
        $this->model_subkriteria->hapus_sub($id_subkriteria);

        // delete perbandingan sebelumnya
        $this->model_subkriteria->delete_perbandingan_subkrit($kriteria);
        $delete = $this->db->affected_rows() != 1 ? false : true;

        if ($delete == 1) {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil hapus Subkriteria</div>');
            redirect('spk/subkriteria');
        } else {
            $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Berhasil hapus Subkriteria</div>');
            redirect('spk/subkriteria');
        }
    }

    public function perband_sub($id_krit)
    {
        $nama_user = $this->session->userdata('nama');
        $kriteria = $this->model_kriteria->get_data_kriteria($id_krit)->row_array();

        $title = ' Perbandingan Sub Kriteria ' . "(" . $kriteria['nama_kriteria'] . ")";
        $submenu = "<a href=" . base_url('spk/subkriteria') . ">Konfigurasi Sub Kriteria</a> /";
        $data = [
            'spk' => 'subkriteria',
            'title' => $title,
            'nama_user' => $nama_user,
            'navigasi' => $this->navigasi($submenu . $title),
        ];

        $sub_kriteria = $this->model_subkriteria->data_subkriteria($id_krit);
        $perbandingan = $this->model_subkriteria->get_perbandingan_subkrit($id_krit)->result_array();

        // **Mencari jumlah pairwase comparasion
        $jumlah = $this->jum_perbandingan(count($sub_kriteria->result_array()));
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
        $id_sub_arr = array();
        $sub_arr = array();
        foreach ($sub_kriteria->result_array() as $subkr) {
            array_push($id_sub_arr, $subkr['id_subkriteria']);
            array_push($sub_arr, $subkr['nama_subkriteria']);
        }
        // End masukan array

        $data['db_set_radio'] = $set_radio;
        $data['nilai_perb'] = $nilai_perb;
        // db kriteria
        $data['id_krit'] =  $id_krit;
        $data['id_kriteria'] = $id_sub_arr;
        $data['kriteria_arr'] = $sub_arr;
        $data['jum_perbandingan'] = $jumlah;


		$data['title_page'] = 'perband Subkriteria | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('spk/subkriteria/perband_subkriteria', $data);
        $this->load->view('templates/footer');
    }

    public function subkriteria_masuk($jum, $id_kriteria)
    {
        // Inisialisasi data
        $nilai_elemen = array();
        $pilihan = array();
        $array_subkriteria1 = $this->input->post('subkriteria1');
        $array_subkriteria2 = $this->input->post('subkriteria2');
        // end 

        // Get data dari form dengan array
        for ($i = 0; $i < $jum; $i++) {
            array_push($pilihan, substr($this->input->post('nilaiElemen' . $i), -1)); // Untuk ambil nilai pilihan radio pertama atau kedua
            array_push($nilai_elemen, substr($this->input->post('nilaiElemen' . $i), 0, 1));
        }
        // end 

        //** input into database

        // * cek tb perbandingan ada tidak? 
        $cek_jumlah = $this->model_subkriteria->cek_data_perb($id_kriteria);

        if ($cek_jumlah == 0) {
            for ($i = 0; $i < $jum; $i++) {
                $data = [
                    'id_subkriteria1' => $array_subkriteria1[$i],
                    'id_subkriteria2' => $array_subkriteria2[$i],
                    'nilai_perband' => $nilai_elemen[$i],
                    'set_radio' => $pilihan[$i]
                ];

                // insert data to table perbandingan
                $this->model_subkriteria->insert_data_perb($data);
            }

            $insert = $this->db->affected_rows() != 1 ? false : true;

            if ($insert == 1) {
                echo "Sukses Insert";
                redirect('spk/proses/proses_subkriteria/' . $id_kriteria);
            } else {
                echo "Gagal Insert";
                redirect('spk/subkriteria/perband_sub/' . $id_kriteria);
            }
        } else {
            for ($i = 0; $i < $jum; $i++) {
                $data = [
                    'nilai_perband' => $nilai_elemen[$i],
                    'set_radio' => $pilihan[$i]
                ];

                $where = "id_subkriteria1 = " . $array_subkriteria1[$i] . " AND id_subkriteria2 = " . $array_subkriteria2[$i];

                $this->model_subkriteria->update_if_exist($data, $where);
            }

            redirect('spk/proses/proses_subkriteria/' . $id_kriteria);
        }
    }

    public function tambahpekerjaansama($id_subkrit)
    {
        $pekerjaan_sama = htmlspecialchars($this->input->post('pekerjaan_sama'));

        $data = array(
            'nama_pekerjaansama' => $pekerjaan_sama,
            'id_subkriteria' => $id_subkrit
        );

        $this->bobot_sama->set_pekerjaan_sama($data);

        $insert = $this->db->affected_rows() != 1 ? false : true;

        if ($insert == 1) {
            echo "Sukses Insert";

            $this->session->set_flashdata('message2', '<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">Berhasil Ditambahkan Pekerjaan Sama <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></div>');

            redirect('spk/subkriteria/edit_sub/' . $id_subkrit);
        } else {
            echo "Gagal Insert";
            $this->session->set_flashdata('message2', '<div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Gagal Ditambahkan Pekerjaan Sama <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></div>');

            redirect('spk/subkriteria/edit_sub/' . $id_subkrit);
        }
    }

    public function hapusPekerjaanSama($id_pekerjaansama, $id_subkrit)
    {
        $this->bobot_sama->delete_pekerjaan_sama($id_pekerjaansama);

        $delete = $this->db->affected_rows() != 1 ? false : true;

        if ($delete == 1) {
            $this->session->set_flashdata('message2', '<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">Berhasil Dihapus! <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></div>');

            redirect('spk/subkriteria/edit_sub/' . $id_subkrit);
        } else {
            $this->session->set_flashdata('success', '<div class="alert alert-warning mt-3">Gagal dihapus</div>');

            redirect('spk/subkriteria/edit_sub/' . $id_subkrit);
        }
    }
}
