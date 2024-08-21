<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <form action="<?= base_url('spk/kriteria/kriteria_masuk/') . $jum_perbandingan; ?>" method="POST">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <hr>
                <table class="table table-bordered" style="max-width: 40rem;">
                    <thead>
                        <tr style="background-color: #F9FAFB; font-size: 13px;">
                            <th>Kriteria 1</th>
                            <th>Nilai perbandingan</th>
                            <th>Kriteria 2</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        <?php
                        $var = 0;
                        $akhir = count($kriteria_arr);
                        $jum_perbandingan = 0;
                        for ($i = 0; $i < count($kriteria_arr); $i++) {
                            $start = 0;

                            while ($start < $akhir) {
                                if ($kriteria_arr[$i] != $kriteria_arr[$start + $i]) {
                        ?>
                                    <div>
                                    </div>
                                    <tr>
                                        <td>
                                            <div class=" form-check">
                                                <div>
                                                    <input type="text" name="kriteria1[]" value="<?= $id_kriteria[$i]; ?>" hidden>
                                                </div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="elemen<?= $var; ?>" value="<?= $id_kriteria[$i]; ?>_1" <?php if ($db_set_radio[$var] == 1) echo "checked"; ?>><?= $kriteria_arr[$i]; ?>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="custom-select" name="nilaiElemen<?= $var; ?>">
                                                <option value="" <?php if ($nilai_perb[$var] == 0 || $nilai_perb[$var] == null) echo "selected"; ?>>Pilih tingkat kepentingan</option>
                                                <option value="1" <?php if ($nilai_perb[$var] == 1) echo "selected"; ?>>1 ; Kedua elemen sama penting</option>
                                                <option value="2" <?php if ($nilai_perb[$var] == 2) echo "selected"; ?>>2 ; Setara menuju cukup diutamakan</option>
                                                <option value="3" <?php if ($nilai_perb[$var] == 3) echo "selected"; ?>>3 ; Cukup diutamakan</option>
                                                <option value="4" <?php if ($nilai_perb[$var] == 4) echo "selected"; ?>>4 ; Cukup diutamakan menuju diutamakan</option>
                                                <option value="5" <?php if ($nilai_perb[$var] == 5) echo "selected"; ?>>5 ; Diutamakan</option>
                                                <option value="6" <?php if ($nilai_perb[$var] == 6) echo "selected"; ?>>6 ; Diutamakan menuju lebih diutamakan</option>
                                                <option value="7" <?php if ($nilai_perb[$var] == 7) echo "selected"; ?>>7 ; Lebih diutamakan</option>
                                                <option value="8" <?php if ($nilai_perb[$var] == 8) echo "selected"; ?>>8 ; Lebih diutamakan menuju sangat diutamakan</option>
                                                <option value="9" <?php if ($nilai_perb[$var] == 9) echo "selected"; ?>>9 ; Sangat diutamakan</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <div>
                                                    <input type="text" name="kriteria2[]" value="<?= $id_kriteria[$start + $i]; ?>" hidden>
                                                </div>
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="elemen<?= $var; ?>" value="<?= $id_kriteria[$start + $i]; ?>_2" <?php if ($db_set_radio[$var] == 2) echo "checked"; ?>><?= $kriteria_arr[$start + $i]; ?>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                        <?php
                                    $jum_perbandingan++;
                                    $var++;
                                }
                                $start++;
                            }
                            $akhir--;
                        } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
