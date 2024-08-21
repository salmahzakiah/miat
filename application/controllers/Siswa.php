<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Siswa extends CI_Controller
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
	public function __construct()
    {
        parent::__construct();
        $this->load->model('model_siswa'); // Pastikan model_siswa dimuat
        $this->load->model('model_hasil'); // Pastikan model_hasil dimuat
        // Tambahkan model lain jika diperlukan
    }

    public function index()
    {
        $username = $this->session->userdata('username');
        $data['data_master'] = 'siswa';
        $data['nama_user'] = $this->session->userdata('nama');
        // Buat tampilan periode terbaru
        $cek_periode = $this->model_periode->get_new_periode()->num_rows();
        $data_periode = $this->model_periode->get_new_periode()->row_array();

        // Susun Tanggal
        $periode_name = $this->pick_three_word($data_periode['nama_periode']);
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);


        if ($cek_periode > 0) {
            $title = 'Data Siswa ' . $periode_name . ' (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';
            $data['title'] = $title;
            $data['navigasi'] = $this->navigasi($title);
        } else {
            $title = 'Data Siswa Periode (Belum Ada Data Periode)';
            $data['title'] = $title;
            $data['navigasi'] = $this->navigasi($title);
        }

        $data['siswa'] = $this->model_siswa->siswa_periode($data_periode['id_periode'])->result_array();

        // Buat dropdown
        $periode_all = $this->model_periode->tahun_periode();


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

        // Buat tambah data / import
        $data['id_periode'] = $data_periode['id_periode'];
        // =========================

        // Cek periode
        $data['cek_periode'] = $cek_periode;
        // =========================

       
        $data['title_page'] = 'Data Siswa | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/index', $data);
        $this->load->view('templates/footer');
    
    }

    public function periode($id_periode)
    {

        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');
        $data['data_master'] = 'siswa';
        $data['nama_user'] = $nama_user;

        $cek_periode = $this->model_periode->get_new_periode()->num_rows();
        $data['siswa'] = $this->model_siswa->siswa_periode($id_periode)->result_array();


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


        $where = array('id_periode' => $id_periode);
        $data_periode = $this->model_periode->get_periode($where)->row_array();

        // Susun Tanggal
        $periode_name = $this->pick_three_word($data_periode['nama_periode']);
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);

        if ($cek_periode > 0) {
            $title = 'Data Siswa ' . $periode_name . ' (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';
            $data['title'] = $title;
            $data['navigasi'] = $this->navigasi($title);
        } else {
            $title = 'Data Siswa Periode (Belum Ada Data Periode)';
            $data['title'] = $title;
            $data['navigasi'] = $this->navigasi($title);
        }

        // Untuk Proses Tambah Data
        $data['id_periode'] = $id_periode;
		
        // ========================

        // Cek periode
        $data['cek_periode'] = $cek_periode;
        // =========================

		$data['title_page'] = 'Siswa | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_siswa($id_periode)
    {
        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');

        $where = array('id_periode' => $id_periode);
        $data_periode = $this->model_periode->get_periode($where)->row_array();

        // Susun Tanggal
        $tanggal_awal = date_create($data_periode['tanggal_awal']);
        $tanggal_akhir = date_create($data_periode['tanggal_akhir']);

        $title = 'Periode (' . date_format($tanggal_awal, "d M Y") . ' - ' . date_format($tanggal_akhir, "d M Y") . ')';


        $title_all = '<a href="' . base_url('siswa') . '">Data Siswa</a> / ' . 'Tambah Data Siswa ' . $title;

        $data = [
            'data_master' => 'siswa',
            'title' => 'Tambah Data Siswa ' . $title,
            'nama_user' => $nama_user
        ];

		
        $data['tempat_tinggal'] = $this->model_subkriteria->get_subkriteria_withName('tempat_tinggal')->result_array();
        $data['transportasi'] = $this->model_subkriteria->get_subkriteria_withName('transportasi')->result_array();
		$data['jarak_rumah'] = $this->model_subkriteria->get_subkriteria_withName('jarak_rumah')->result_array();
        $data['status_siswa'] = $this->model_subkriteria->get_subkriteria_withName('status_siswa')->result_array();
        $data['jumlah_tanggungan'] = $this->model_subkriteria->get_subkriteria_withName('jumlah_tanggungan')->result_array();
        $data['navigasi'] = $this->navigasi($title_all);
        $data['id_periode'] = $id_periode;
        $data['pekerjaan'] = $this->model_subkriteria->get_subkriteria_pekerjaan()->result_array();
        $data['pekerjaan_setara'] = $this->bobot_sama->get_all_pekerjaan_sama()->result_array();

        // print_r($data['pekerjaan_setara']);

		$data['title_page'] = 'Tambah Siswa | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('siswa/tambah_siswa', $data);
        $this->load->view('templates/footer');
    }
    public function edit_siswa($id)
    {
        $username = $this->session->userdata('username');
        $nama_user = $this->session->userdata('nama');
        $title = '<a href="' . base_url('siswa') . '">Data Siswa</a> / ' . 'Edit Data Siswa';


        $data = [
            'title' => 'Edit Data Siswa',
            'nama_user' => $nama_user
        ];

        $where = array('id_siswa' => $id);
        $data['navigasi'] = $this->navigasi($title);
        $data['siswa'] = $this->model_siswa->get_siswa($where)->row_array();
        $data['status_siswa'] = $this->model_subkriteria->get_subkriteria_withName('status_siswa')->result_array();
        $data['jarak_rumah'] = $this->model_subkriteria->get_subkriteria_withName('jarak_rumah')->result_array();
        $data['transportasi'] = $this->model_subkriteria->get_subkriteria_withName('transportasi')->result_array();
		$data['tempat_tinggal'] = $this->model_subkriteria->get_subkriteria_withName('tempat_tinggal')->result_array();
        $data['tanggungan'] = $this->model_subkriteria->get_subkriteria_withName('tanggungan')->result_array();
        $data['pekerjaan'] = $this->model_subkriteria->get_subkriteria_pekerjaan()->result_array();
        $data['pekerjaan_setara'] = $this->bobot_sama->get_all_pekerjaan_sama()->result_array();

		$data['title_page'] = 'Edit Siswa | SPK-AHP AT-TAUBAH';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
        $this->load->view('siswa/edit_siswa', $data);
        $this->load->view('templates/footer');
    }
	public function input($id_periode)
{
    // Ambil data dari form
    $nama = htmlspecialchars($this->input->post('nama'));
    $nik = htmlspecialchars($this->input->post('nik'));
    $alamat = htmlspecialchars($this->input->post('alamat'));
    $kelas = htmlspecialchars($this->input->post('kelas'));
    $pekerjaanSelect = htmlspecialchars($this->input->post('pekerjaan'));
    $pekerjaanInput = htmlspecialchars($this->input->post('pekerjaanInput'));
    $nama_orangtua = htmlspecialchars($this->input->post('nama_orangtua'));
    $penghasilan = htmlspecialchars($this->input->post('penghasilan'));
    $tanggungan = htmlspecialchars($this->input->post('tanggungan'));
    $status_siswa = htmlspecialchars($this->input->post('status_siswa'));
    $jarak_rumah = htmlspecialchars($this->input->post('jarak_rumah'));
    $transportasi = htmlspecialchars($this->input->post('transportasi'));
    $tempat_tinggal = htmlspecialchars($this->input->post('tempat_tinggal'));

    // Cek Inputan Pekerjaan 
    if ($pekerjaanSelect == "Tambah Pekerjaan") {
        $pekerjaan = $pekerjaanInput;
    } else {
        $pekerjaan = $pekerjaanSelect;
    }

    // Data siswa yang akan ditambahkan
    $data = [
        'nama' => $nama,
        'nik' => $nik,
        'alamat' => $alamat,
        'kelas' => $kelas,
        'nama_orangtua' => $nama_orangtua,
        'pekerjaan' => $pekerjaan,
        'penghasilan' => $penghasilan,
        'tanggungan' => $tanggungan,
        'status_siswa' => $status_siswa,
        'jarak_rumah' => $jarak_rumah,
        'transportasi' => $transportasi,
        'tempat_tinggal' => $tempat_tinggal,
        'id_periode' => $id_periode
    ];

    // Tambahkan siswa ke database
    $this->model_siswa->tambah_siswa($data);
    $insert = $this->db->affected_rows() != 1 ? false : true;

    if ($insert) {
        // Panggil fungsi implementWBobot dari model_hasil untuk menghitung scoring
        $this->model_hasil->implementWBobot($id_periode, 1);

        // Tampilkan pesan sukses dan tetap berada di halaman siswa
        $this->session->set_flashdata('import', '<div class="alert alert-success mt-3">Tambah data telah berhasil</div>');
        redirect('siswa/index');  // Mengarahkan ke halaman index siswa
    } else {
        // Jika gagal, redirect kembali ke halaman tambah siswa
        $this->session->set_flashdata('import', '<div class="alert alert-danger mt-3">Gagal menambahkan data.</div>');
        redirect('siswa/tambah_siswa/' . $id_periode);
    }
}


    public function update($id)
    {
		
        $nama = htmlspecialchars($this->input->post('nama'));
        $nik = htmlspecialchars($this->input->post('nik'));
        $alamat = htmlspecialchars($this->input->post('alamat'));
        $kelas = htmlspecialchars($this->input->post('kelas'));
        $pekerjaanSelect = htmlspecialchars($this->input->post('pekerjaan'));
        $pekerjaanInput = htmlspecialchars($this->input->post('pekerjaanInput'));
		$nama_orangtua= htmlspecialchars($this->input->post('nama_orangtua'));
        $penghasilan = htmlspecialchars($this->input->post('penghasilan'));
		$tanggungan = htmlspecialchars($this->input->post('tanggungan'));
        $status_siswa = htmlspecialchars($this->input->post('status_siswa'));
		$jarak_rumah = htmlspecialchars($this->input->post('jarak_rumah'));
        $transportasi = htmlspecialchars($this->input->post('transportasi'));
		$tempat_tinggal = htmlspecialchars($this->input->post('tempat_tinggal'));

        // Cek Inputan Pekerjaan 
        if ($pekerjaanSelect == "Tambah Pekerjaan") {
            $pekerjaan = $pekerjaanInput;
        } else {
            $pekerjaan = $pekerjaanSelect;
        }

        $where = [
            'id_siswa' => $id,
        ];

        $data = [

			'nama' => $nama,
			'nik' => $nik,
			'alamat' => $alamat,
			'kelas' => $kelas,
			'nama_orangtua' => $nama_orangtua,
			'pekerjaan' => $pekerjaan,
			'penghasilan' => $penghasilan,
			'tanggungan' => $tanggungan,
			'status_siswa' => $status_siswa,
			'jarak_rumah' => $jarak_rumah,
			'transportasi' => $transportasi,
			'tempat_tinggal' => $tempat_tinggal
        ];

        $this->model_siswa->update_siswa($where, $data);

        $update = $this->db->affected_rows() != 1 ? false : true;

        if ($update > 0) {
            $this->session->set_flashdata('import', '<div class="alert alert-success mt-3">Edit data telah berhasil</div>');
            redirect('siswa');
        } else {
            redirect('siswa/edit_siswa/' . $id);
        }
    }

    public function hapus($id)
    {
        $where = [
            'id_siswa' => $id,
        ];
        $this->model_siswa->delete_siswa($where);

        $delete = $this->db->affected_rows();

        if ($delete > 0) {
            redirect('siswa');
        } else {
            redirect('siswa');
        }
    }
}


