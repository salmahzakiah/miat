<?php
defined('BASEPATH') or exit('No direct script access allowed');

class periode extends CI_Controller
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

    public function index()
    {
        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');
        $title = 'Tahun Periode';

        $data = [
            'data_master' => 'periode',
            'title' => $title,
            'nama_user' => $nama_user,
        ];

        $data['navigasi'] = $this->navigasi($title);
        $data['periode'] = $this->model_periode->tahun_periode();

		$data['title_page'] = 'Tahun Periode | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('periode/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_periode()
    {
        $nama_user = $this->session->userdata('nama');
        $title = '<a href="' . base_url('tahunperiode') . '">Tahun Periode</a> / ' . 'Tambah Periode';

        $data = [
            'data_master' => 'periode',
            'title' => 'Tambah Periode',
            'nama_user' => $nama_user
        ];

        $data['navigasi'] = $this->navigasi($title);

		$data['title_page'] = 'Tambah Periode | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('periode/tambah_periode', $data);
        $this->load->view('templates/footer');
    }

    public function edit_periode($id)
    {
        $nama_user = $this->session->userdata('nama');
        $title = '<a href="' . base_url('periode') . '">Tahun Periode</a> / ' . 'Edit Periode';

        $data = [
            'data_master' => 'periode',
            'title' => 'Edit Periode',
            'nama_user' => $nama_user
        ];

        $where = array('id_periode' => $id);
        $data['periode'] = $this->model_periode->get_periode($where)->row_array();
        $data['navigasi'] = $this->navigasi($title);

		$data['title_page'] = 'Edit Periode | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('periode/edit_periode', $data);
        $this->load->view('templates/footer');
    
    }

    public function edit($id)

    {
        $nama_periode = htmlspecialchars($this->input->post('nama'));
        $tgl_awal = htmlspecialchars($this->input->post('tanggal_awal'));
        $tgl_akhir = htmlspecialchars($this->input->post('tanggal_akhir'));
        $kuota = htmlspecialchars($this->input->post('kuota'));
        $keterangan = htmlspecialchars($this->input->post('keterangan'));

        $where = array('id_periode' => $id);
        $data = [
            'nama_periode' => $nama_periode,
            'tanggal_awal' => $tgl_awal,
            'tanggal_akhir' => $tgl_akhir,
            'kuota' => $kuota,
            'keterangan' => $keterangan
        ];

        $this->model_periode->update_periode($where, $data);

        $update = $this->db->affected_rows() != 1 ? false : true;

        if ($update > 0) {
            $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissible fade show" role="alert"> Berhasil edit data dengan nama periode: ' . $nama_periode . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
            redirect('periode');
        } else {
            redirect('periode/edit_periode/' . $id);
        }
    }

    public function input()
    {
        $nama_periode = htmlspecialchars($this->input->post('nama'));
        $tgl_awal = htmlspecialchars($this->input->post('tanggal_awal'));
        $tgl_akhir = htmlspecialchars($this->input->post('tanggal_akhir'));
        $kuota = htmlspecialchars($this->input->post('kuota'));
        $keterangan = htmlspecialchars($this->input->post('keterangan'));

        $data = [
            'nama_periode' => $nama_periode,
            'tanggal_awal' => $tgl_awal,
            'tanggal_akhir' => $tgl_akhir,
            'kuota' => $kuota,
            'keterangan' => $keterangan
        ];

        $this->model_periode->insert_periode($data);
        $insert = $this->db->affected_rows() != 1 ? false : true;

        if ($insert) {
            $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissible fade show" role="alert"> Berhasil ditambahkan dengan nama periode: ' . $nama_periode . ' 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
            redirect('periode');
        } else {
            redirect('periode/tambah_periode');
        }
    }

    public function hapus($id)
    {
        $where = array('id_periode' => $id);

        $this->model_periode->delete_periode($where);
        $delete = $this->db->affected_rows() != 1 ? false : true;

        $this->session->set_flashdata('success', '<div class="alert alert-success alert-dismissible fade show" role="alert"> Data Berhasil di Hapus 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');

        redirect('periode');
    }
}



