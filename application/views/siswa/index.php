<!-- DataTales Example -->
<div class="container mt-3">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="m-3">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="mr-1">
                        <a href="<?= base_url('siswa/tambah_siswa/') . $id_periode; ?>" class="btn btn-success <?php if ($cek_periode == 0) echo "disabled"; ?>"><i class="bi bi-plus-lg"></i> Tambah</a>
                    </div>
                    <div class="dropdown mr-auto">
                        <button class="btn btn-warning <?php if ($cek_periode == 0) echo "disabled"; ?>" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-clock"></i> Periode <i class="bi bi-caret-down-fill"></i>
                        </button>
                        <div class="dropdown-menu scrollable-menu" aria-labelledby="dropdownMenuButton">
                            <?php foreach ($periode as $p) : ?>
                                <a class="dropdown-item" href="<?php echo base_url('siswa/periode/') . $p['id_periode'] ?>">
                                    <?php
                                    $tgl_awal = date_create($p['tanggal_awal']);
                                    $tgl_akhir = date_create($p['tanggal_akhir']);
                                    echo $p['nama_periode'] . " (" . date_format($tgl_awal, 'd M Y') . ' - ' . date_format($tgl_akhir, 'd M Y') . ")";
                                    ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <?= $this->session->flashdata('import'); ?>

                <hr>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered text-center">
                        <thead style="font-size: 11px;background-color: #d9edf7;">
                            <tr>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">No</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Nama</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">NIK</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Alamat</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Kelas</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Nama <br> Ortu</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Pekerjaan <br>Ortu</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Penghasilan <br> Ortu</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Jumlah<br> Saudara <br></th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Status <br> Siswa</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Jarak Rumah -<br>Madrasah</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Transportasi</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Status Tempat<br> Tinggal</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody style="font-size: 11px; border: 1px solid #d5d5db;">
                            <?php $no = 1; ?>
                            <?php foreach ($siswa as $p) : ?>
                                <tr>
                                    <th scope="row" style="border: 1px solid #d5d5db;"><?= $no++; ?></th>
                                    <td class="text-left" style="border: 1px solid #d5d5db;"><?= $p['nama']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['nik']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['alamat']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['kelas']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['nama_orangtua']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['pekerjaan']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['penghasilan']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['tanggungan']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['status_siswa']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['jarak_rumah']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['transportasi']; ?></td>
                                    <td style="border: 1px solid #d5d5db;"><?= $p['tempat_tinggal']; ?></td>
                                    <td style="border: 1px solid #d5d5db; width:20px;">
                                        <a href="<?= base_url('siswa/hapus/') . $p['id_siswa']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        <div class="my-2"></div>
                                        <a href="<?= base_url('siswa/edit_siswa/') . $p['id_siswa']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "autoWidth": false, // Tambahkan ini
            "language": {
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });
    });
</script>
