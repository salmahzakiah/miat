<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="mr-auto bd-highlight">
                    <a href="<?= base_url('spk/hasil/implementWBobot/') . $id_periode . "/" . 1; ?>" class="btn btn-primary"> <span>Cek Score Tertinggi <i class="bi bi-arrow-right"></i></span></a>
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
                        <tr style="background-color: #F9FAFB; font-size: 13px;">
                            <th scope="col" class="align-middle">No</th>
                            <th scope="col" class="align-middle">Nama</th>
                            <?php
                            for ($i = 0; $i < count($column); $i++) {
                                echo '<th scope="col" class="align-middle">' . $column[$i] . '</th>';
                            } ?>
                            <th scope="col" class="align-middle">Total</th>
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
                                    <td class="text-left" style="width: 250px;"><?= round($score[$i][4], 4); ?></td>
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
