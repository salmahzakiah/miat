<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="mr-auto bd-highlight">
                    <a href="<?= base_url('manual/hasil/implementWBobot/') . $id_periode . "/" . 1; ?>" class="btn btn-primary"> <span>Cek Score Tertinggi <i class="bi bi-arrow-right"></i></span></a>
                </div>
                <div class="">
                    <div class="input-icons">
                        <i class="bi bi-search icon"></i>
                        <input type="text" name="search" id="myInputSearch" class="input-field" placeholder="search...">
                    </div>
                </div>
            </div>

            <hr>
            <div class="table-responsive">
                <table id="example" class="table table-bordered" style="max-width: 40rem;">
                    <thead>
                        <tr style="background-color: #d9edf7; font-size: 13px;">
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">No</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">Nama</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">jarak_rumah</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">tanggungan</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">pekerjaan</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">penghasilan</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">transportasi</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">tempat_tinggal</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">status_siswa</th>
						<th scope="col" class="align-middle" style="border: 1px solid #d5d5db;">Total</th>
                        </tr>
                    </thead>
					<tbody style="font-size: 13px;">
    <?php $no = 1; ?>
    <?php $i = 0; ?>
    <?php foreach ($siswa as $p) : ?>
        <tr>
            <th scope="row" style="width: 30px;"><?= $no++; ?></th>
            <td class="text-left" style="width: 250px;"><?= $p['nama']; ?></td>
            <?php for ($j = 0; $j < count($column); $j++) { ?>
                <td class="text-left" style="width: 250px;"><?= round($score[$i][$j], 4); ?></td>
            <?php } ?>
            <td class="text-left" style="width: 250px;"><?= round($total[$i]['total'], 4); ?></td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
</tbody>




                </table>
            </div>
        </div>
    </div>
</div>
