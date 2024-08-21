<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <form action="<?= base_url('spk/kriteria/config_input'); ?>" method="POST">
			<a href="<?= base_url('spk/kriteria'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <hr>
                <table class="table table-bordered" style="max-width: 15rem;">
                    <thead>
                        <tr style="background-color: #d9edf7; font-size: 13px;">
						<th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Kriteria</th>
							<th scope="col" class="align-middle"style="border: 1px solid #d5d5db;text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        <?php
                        $temp = 0;
                        foreach ($kriteria as $kr) : ?>
                            <tr>
                                <td>
                                    <?= $kr['nama_kriteria']; ?>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="toggle[]" class="custom-control-input" id="customSwitch<?= $temp; ?>" <?php if ($kr['toggle'] == 1) echo "checked"; ?> value="<?= $kr['id_kriteria']; ?>">

                                        <label class="custom-control-label" for="customSwitch<?= $temp++; ?>"></label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
