<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    
    <div class="m-3">
        <?= $this->session->flashdata('success'); ?>
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="mr-auto bd-highlight">
                        <a href="<?= base_url('Periode/tambah_periode'); ?>" class="btn btn-success"><i class="bi bi-plus-lg"></i>
                            <span>Tambah</span>
                        </a>
                    </div>
                    <div class=""></div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="example" class="table table-bordered text-center">
					<thead style="font-size: 13px;background-color: #d9edf7;">
					<tr>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">No</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Nama Periode</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Tanggal Periode</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Kuota</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Keterangan</th>
                                <th scope="col" class="align-middle" style="border: 1px solid #d5d5db;text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px; border: 1px solid #858796; ">
                            <?php $no = 1; ?>
                            <?php foreach ($periode as $p) : ?>
                                <tr>
                                    <th scope="row" style="width: 30px; border: 1px solid #d5d5db;"><?= $no++; ?></th>
                                    <td class="text-left" style="width: 250px;  border: 1px solid #d5d5db;"><?= $p['nama_periode']; ?></td>
                                    <td style=" border: 1px solid #d5d5db;">
                                        <?php
                                        $date_awal = date_create($p['tanggal_awal']);
                                        $date_akhir = date_create($p['tanggal_akhir']); ?>
                                        <?= date_format($date_awal, "d, M Y"); ?> - <?= date_format($date_akhir, "d, M Y"); ?>
                                    </td>
                                    <td style=" border: 1px solid #d5d5db;"><?= $p['kuota']; ?> Orang</td>
                                    <td style=" border: 1px solid #d5d5db;"><?= $p['keterangan']; ?></td>
                                    <td style="width: 60px;  border: 1px solid #d5d5db;">
                                        <a href="<?= base_url('periode/hapus/') . $p['id_periode']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                        <div class="my-2"></div>
                                        <a href="<?= base_url('periode/edit_periode/') . $p['id_periode']; ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

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
            "autoWidth": false, 
            "language": {
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });
    });
</script>
