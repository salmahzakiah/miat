<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerima extends CI_Controller
{

    private function navigasi($title)
    {
        $navigasi = '<a href="' . base_url('admin/dashboard') . '">Dashboard</a> / ' . $title;
        return $navigasi;
    }

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

    public function index()
    {
        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');
        $title = "";
        $title_all = "";

        // Cari data periode terbaru 
        $cek_periode = $this->model_periode->get_new_periode()->num_rows();
        $data_periode = $this->model_periode->get_new_periode()->row_array();

        $where = array('id_periode' => $data_periode['id_periode']);
        $data_periode = $this->model_periode->get_periode($where)->row_array();

        // Susun Tanggal
        $periode_name = $this->pick_three_word($data_periode['nama_periode']);
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);

        if ($cek_periode > 0) {
            $title = $periode_name . ' (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';
            $title_all = 'Data Penerima Bantuan ';
        } else {
            $title = '(Data Periode Belum Ada)';
            $title_all = 'Data Penerima Bantuan ';
        }

        $data = [
            'data_master' => 'penerima',
            'title' => $title_all . $title,
            'nama_user' => $nama_user,
        ];

        $data['navigasi'] = $this->navigasi($title_all . $title);
        // $data['penerima'] = $this->model_penerima->siswa_wstatus()->result_array();

        // Buat dropdown
        $periode_all = $this->model_periode->tahun_periode()->result_array();


        // Buat Dropdown - Ambil 3 kata didepan
        $name_periode = array();

        for ($i = 0; $i < count($periode_all); $i++) {

            /** explode beberapa bagian string, jika lebih dari 3 terdapat "..." */
            $name_str = $this->pick_three_word($periode_all[$i]['nama_periode']);

            // Insert into array
            $nama_periode[$i] = array(
                'id_periode' => $periode_all[$i]['id_periode'],
                'tanggal_awal' => $periode_all[$i]['tanggal_awal'],
                'tanggal_akhir' => $periode_all[$i]['tanggal_akhir'],
                'nama_periode' => $name_str
            );
        }
        $data['periode'] = $nama_periode;
        // =============


        $data['penerima'] = $this->model_penerima->siswa_status_periode($data_periode['id_periode'])->result_array();
        $data['id_periode'] = $data_periode['id_periode'];

        // Cek periode
        $data['cek_periode'] = $cek_periode;
        // =========================
		{
			$data['title_page'] = 'Penerima Dana Bantuan Pendidikan';
			$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
	
			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('penerima/index', $data);
			$this->load->view('templates/footer');
		}
    }

    public function periode($id_periode)
    {
        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');
        $title_all = 'Data Penerima Bantuan ';


        // Cari data periode terbaru 
        $cek_periode = $this->model_periode->get_new_periode()->num_rows();
        $where = array('id_periode' => $id_periode);
        $data_periode = $this->model_periode->get_periode($where)->row_array();

        // Susun Tanggal
        $periode_name = $this->pick_three_word($data_periode['nama_periode']);
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);

        if ($cek_periode > 0) {
            $title = $periode_name . ' (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';
            $title_all = 'Data Penerima Bantuan ';
        } else {
            $title = '(Data Periode Belum Ada)';
            $title_all = 'Data Penerima Bantuan ';
        }

        $data = [
            'data_master' => 'penerima',
            'title' => $title_all . $title,
            'nama_user' => $nama_user,
        ];

        $data['navigasi'] = $this->navigasi($title_all . $title);
        $data['penerima'] = $this->model_penerima->siswa_status_periode($data_periode['id_periode'])->result_array();

        // Buat dropdown
        $periode_all = $this->model_periode->tahun_periode()->result_array();


        // Buat Dropdown - Ambil 3 kata didepan
        $name_periode = array();

        for ($i = 0; $i < count($periode_all); $i++) {

            /** explode beberapa bagian string, jika lebih dari 3 terdapat "..." */
            $name_str = $this->pick_three_word($periode_all[$i]['nama_periode']);

            // Insert into array
            $nama_periode[$i] = array(
                'id_periode' => $periode_all[$i]['id_periode'],
                'tanggal_awal' => $periode_all[$i]['tanggal_awal'],
                'tanggal_akhir' => $periode_all[$i]['tanggal_akhir'],
                'nama_periode' => $name_str
            );
        }
        $data['periode'] = $nama_periode;
        // =============

        $data['id_periode'] = $data_periode['id_periode'];

        // Cek periode
        $data['cek_periode'] = $cek_periode;
        // =========================

		$data['title_page'] = 'Penerima | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('penerima/index', $data);
		$this->load->view('templates/footer');
    }

    public function tambah_penerima($id_periode)
    {
        $username = $this->session->userdata('username');
        $data['data_master'] = 'penerima';
        $data['nama_user'] = $this->session->userdata('nama');
        $data['penerima'] = $this->model_penerima->siswa($id_periode)->result_array();

        $where = array('id_periode' => $id_periode);
        $data_periode = $this->model_periode->get_periode($where)->row_array();

        // Susun Tanggal
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);

        $title = 'Periode (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';


        $data['title'] = 'Tambah Penerima Bantuan ' . $title;
        $title_all = '<a href="' . base_url('penerima') . '">Data Penerima Bantuan</a> / ' . $data['title'];
        $data['navigasi'] = $this->navigasi($title_all);
        $data['id_periode'] = $id_periode;

        // print_r($data['penerima']);

		$data['title_page'] = 'Tambah Penerima | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        	$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar', $data);
			$this->load->view('templates/topbar', $data);
			$this->load->view('penerima/tambah_penerima', $data);
			$this->load->view('templates/footer');
    }

    public function hapus_penerima( $id)
    {
			$where = [
				'id_penerima' => $id,
			];
			$this->model_penerima->hapus_penerima($where);
	
			$delete = $this->db->affected_rows();
	
			if ($delete > 0) {
				redirect('penerima');
			} else {
				redirect('penerima');
			}
		
    }

    public function status_accept($id, $status, $id_periode)
    {
        $this->load->helper('date');
        $format = "%Y-%m-%d";
        // echo $id, $status;
        // Cek apakah ada data atau belum? 

        // Ambil data siswa penerima
        $jumlah = $this->model_penerima->siswa_cstatus($id)->num_rows();
        // print_r($data['penerima']);
        echo $jumlah;

        if ($jumlah > 0) {
            $data = [
                'tgl_penerima' => mdate($format),
                'status' => $status
            ];

            $this->model_penerima->update_status($id, $data);
            $update = $this->db->affected_rows() != 1 ? false : true;

            if ($update > 0) {
                echo "Sukses Diupdate";
                $this->session->set_flashdata('failed', '<div class="alert alert-success mt-3">Status Penerima berhasil diubah dengan: ' . $status . '</div>');
                redirect('penerima/tambah_penerima/' . $id_periode);
            } else {
                echo "Gagal Update";
                redirect('penerima/tambah_penerima/' . $id_periode);
            }
        } else {
            $data = [
                'tgl_penerima' => mdate($format),
                'id_siswa' => $id,
                'status' => $status
            ];

            $this->model_penerima->insert_status($data);
            $insert = $this->db->affected_rows() != 1 ? false : true;

            if ($insert > 0) {
                echo "Sukses Insert";
                $this->session->set_flashdata('success', '<div class="alert alert-success mt-3">Status Penerima berhasil dipilih dengan status: ' . $status . '</div>');
                redirect('penerima');
            } else {
                echo "Gagal Insert";
                redirect('penerima/tambah_penerima/' . $id_periode);
            }
        }
    }
	

    public function simpan($id_periode)
    {
        $this->load->helper('date');
        $data = $this->input->post('checked');
        $status = $this->input->post('status_penerima');
        $format = "%Y-%m-%d";

        if (empty($status)) {
            $this->session->set_flashdata('failed', '<div class="alert alert-danger mt-3">Status Penerima belum dipilih</div>');

            redirect('tambah_penerima/' . $id_periode);
        } else {
            foreach ($data as $d) {
                $data = $this->model_penerima->cek_status($d);

                echo "Data: " . $data->num_rows();
                if ($data->num_rows() != 0) {
                    $update = array(
                        'tgl_penerima' => mdate($format),
                        'status' => $status
                    );
                    $this->model_penerima->update_status($d, $update);
                } else {
                    $insert = array(
                        'tgl_penerima' => mdate($format),
                        'id_siswa' => $d,
                        'status' => $status
                    );
                    $this->model_penerima->insert_status($insert);
                }
                echo "<br>";
            }
            $input = $this->db->affected_rows() != 1 ? false : true;
            if ($input > 0) {
                echo "Sukses Insert";
                redirect('penerima');
            } else {
                echo "Gagal Insert";
                redirect('penerima/tambah_penerima/' . $id_periode);
            }
        }
    }
}


