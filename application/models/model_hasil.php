<?php
class model_hasil extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        // Inisialisasi jika diperlukan
    }

	public function implementWBobot($id_periode, $accept = null, $export = null)
    {
        // Hapus semua data alternatif untuk periode tersebut sebelum menambahkan yang baru
        $this->model_alternatif->delete_exist_alternatif($id_periode);

        // Lanjutkan dengan proses perhitungan dan penyimpanan data
        $data_siswa = $this->model_siswa->siswa_periode($id_periode);
        $kr_bobot = $this->model_kriteria->data_kriteria_on()->result_array();

        // Proses substitusi bobot
        $column = $this->getColumns();
        $score = $this->subtitusiBobot($column, $data_siswa, $kr_bobot);
        $total = $this->jumTotalBobot($score);

        // Simpan hasil skor ke tabel alternatif jika accept diatur
        if ($accept != null && $accept == 1) {
            foreach ($total as $ahp) {
                // Periksa apakah data sudah ada sebelum menambahkannya
                $existing = $this->model_alternatif->get_alternatif($id_periode)->result_array();
                $exists = false;
                foreach ($existing as $item) {
                    if ($item['id_siswa'] == $ahp['id_siswa']) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $this->model_alternatif->insert_alternatif([
                        'id_siswa' => $ahp['id_siswa'],
                        'skor' => $ahp['total']
                    ]);
                }
            }

            // Proses scoring secara otomatis
            $this->scoring($id_periode);

            // Redirect ke halaman scoring setelah proses selesai
            redirect('spk/hasil/scoring/' . $id_periode);
        }

        // Proses export ke Excel, jika diperlukan
        if ($export != null && $export == 1) {
            $this->exportToExcel($data_siswa, $kr_bobot, $score, $total);
        }

        // Setelah proses selesai, arahkan ke halaman hasil
        redirect('spk/hasil');
    }

    // Fungsi tambahan lain yang dibutuhkan
    private function getColumns() {
        $nm_column = $this->model_siswa->get_column_name()->result_array();
        $column = [];
        for ($i = 5; $i < count($nm_column); $i++) {
            if ($i != 20) {
                $column[] = $nm_column[$i]['Field'];
            }
        }
        return $column;
    }

    private function subtitusiBobot($column, $data_siswa, $kr_bobot)
    {
        $column2 = $column;
        $column2[5] = "status_siswa";

        $no_p = 0;
        $score = array();
        foreach ($data_siswa->result_array() as $dp) {
            for ($i = 0; $i < count($column); $i++) {

                $j = 0;

                foreach ($kr_bobot as $kr) {
                    if ($column2[$i] == $kr['nama_kriteria']) {
                        $score[$no_p]['id_siswa'] = $dp['id_siswa'];

                        $subkr_bobot = $this->model_subkriteria->data_subkriteria($kr['id_kriteria'])->result_array();

                        foreach ($subkr_bobot as $sbb) {

                            $operator = "";
                            $pieces = explode(" ", $sbb['nama_subkriteria']);

                            if (count($pieces) == 3) {
                                if ($pieces[1] == "-") {
                                    if ($pieces[0] <= $dp[$column[$i]] && $dp[$column[$i]] <= $pieces[2]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == "&lt;") {
                                    if ($dp[$column[$i]] <= $pieces[2]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                } elseif ($pieces[1] == "&gt;") {
                                    if ($pieces[2] <= $dp[$column[$i]]) {
                                        $score[$no_p][$j] = $kr['bobot'] * $sbb['bobot'];
                                    }
                                }
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
            if (isset($sc['id_siswa'])) {
                $temp = 0;

                foreach ($sc as $key => $value) {
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

    private function scoring($id_periode) {
        // Implementasi fungsi scoring
    }

    private function exportToExcel($data_siswa, $kr_bobot, $score, $total) {
        // Implementasi fungsi exportToExcel
    }
}
