<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="ml-auto">
                    <div class="input-icons">
                        <i class="bi bi-search icon"></i>
                        <input type="text" name="search" id="myInputSearch" class="input-field" placeholder="search...">
                    </div>
                </div>
            </div>
            <hr>
            <?php $button = 0; ?>
            <?php echo $cek_kriteria ?>
            <?php foreach ($kriteria as $kr) : ?>
                <?php if ($cek_subkriteria[$kr['nama_kriteria']] == $total_subkr[$kr['nama_kriteria']]) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"> SubKriteria <?= $kr['nama_kriteria']; ?> masih belum ada bobot!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php $button++; ?>
                <?php } ?>
            <?php endforeach; ?>
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-center">
                    <thead style="font-size: 13px;background-color: #d9edf7;">
                        <tr>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">No</th>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Nama Periode</th>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Tanggal Periode</th>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Kuota</th>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Keterangan</th>
                            <th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Implementasi AHP</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px; border: 1px solid #858796;">
                        <?php $no = 1; ?>
                        <?php foreach ($periode as $p) : ?>
                            <tr>
                                <th scope="row" style="width: 30px;"><?= $no++; ?></th>
                                <td class="text-left" style="width: 250px;"><?= $p['nama_periode']; ?></td>
                                <td><?php
                                    $date_awal = date_create($p['tanggal_awal']);
                                    $date_akhir = date_create($p['tanggal_akhir']);?>
                                    <?= date_format($date_awal, "d, M Y"); ?> - <?= date_format($date_akhir, "d, M Y"); ?>
                                </td>
                                <td><?= $p['kuota']; ?> Orang</td>
                                <td><?= $p['keterangan']; ?></td>
                                <td style="width:30px;">
								<a href="<?= base_url('manual/hasil/cek_implementasi/') . $p['id_periode']; ?>" class="btn btn-primary <?php if ($button != 0) echo "disabled"; ?>">
   												 <i class="bi bi-arrow-right-square"></i>
									</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
