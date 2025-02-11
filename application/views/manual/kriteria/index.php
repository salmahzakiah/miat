<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

 
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">

            <form action="<?= base_url('spk/kriteria/kriteria_masuk/') . $jum_perbandingan; ?>" method="POST">
                <button type="submit" class="btn btn-primary" <?php if (count($kriteria_arr) <= 2) echo "disabled" ?>>Simpan</button>

                <a href="<?= base_url('spk/kriteria/config/'); ?>" class="btn btn-warning">Config Kriteria</a>

                <?php if (count($kriteria_arr) <= 2) { ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" style="font-size: 12px;" role="alert">
                        Minimal Harus Terdapat <strong>3 Kriteria</strong> Yang di Aktifkan, Silahkan konfigurasi kriteria kembali.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>

                <hr>
                <table class="table table-bordered" style="max-width: 40rem;">
                    <thead>
                        <tr style="font-size: 13px; background-color: #d9edf7;">
                            <th >Kriteria 1</th>
                            <th style="text-align: center;">Nilai perbandingan</th>
                            <th>Kriteria 2</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;background-color: #d9edf7;">
                        <?php
                        $var = 0;
                        $temp = 0;
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
                                            <input type="text" name="kriteria1[]" value="<?= $id_kriteria[$i]; ?>" hidden>


                                            <?php if (count($db_set_radio) != 0) { ?>
                                                <?php if ($db_set_radio[$var] == 1) { ?>
                                                    <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$i]; ?></label>
                                                <?php } else { ?>
                                                    <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$start + $i]; ?></label>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$i]; ?></label>
                                            <?php } ?>


                                        </td>
                                        <td>
                                            <select class="custom-select" style="font-size: 12px;" id="nilaiElemen<?= $var; ?>" onchange="exchange(<?= $var; ?>, <?= $temp++; ?>)" name="nilaiElemen<?= $var; ?>">
                                                <option value="" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 0 || $nilai_perb[$var] == null) echo "selected"; ?>>Pilih tingkat kepentingan</option>

                                                <optgroup label="Kriteria 1 dan Kriteria 2 Sama Penting">
                                                    <option value="1_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 1 && $db_set_radio[$var] == 1) echo "selected"; ?>>1: Kedua kriteria elemen sama penting </option>
                                                </optgroup>

                                                <optgroup label="Kriteria <?= $kriteria_arr[$i]; ?>">

                                                    <option value="2_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 2 && $db_set_radio[$var] == 1) echo "selected"; ?>>2: Kriteria <?= $kriteria_arr[$i]; ?> dan <?= $kriteria_arr[$i + $start]; ?> setara, tapi kriteria <?= $kriteria_arr[$i]; ?> cukup diutamakan </option>

                                                    <option value="3_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 3 && $db_set_radio[$var] == 1) echo "selected"; ?>>3: Kriteria <?= $kriteria_arr[$i]; ?> cukup diutamakan </option>

                                                    <option value="4_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 4 && $db_set_radio[$var] == 1) echo "selected"; ?>>4: Kriteria <?= $kriteria_arr[$i]; ?> dan <?= $kriteria_arr[$i + $start]; ?> cukup diutamakan, tapi kriteria <?= $kriteria_arr[$i]; ?> sedikit diutamakan </option>

                                                    <option value="5_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 5 && $db_set_radio[$var] == 1) echo "selected"; ?>>5: Kriteria <?= $kriteria_arr[$i]; ?> diutamakan </option>

                                                    <option value="6_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 6 && $db_set_radio[$var] == 1) echo "selected"; ?>>6: Kriteria <?= $kriteria_arr[$i]; ?> dan <?= $kriteria_arr[$i + $start]; ?> diutamakan, tapi kriteria <?= $kriteria_arr[$i]; ?> sedikit lebih diutamakan </option>

                                                    <option value="7_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 7 && $db_set_radio[$var] == 1) echo "selected"; ?>>7: Kriteria <?= $kriteria_arr[$i]; ?> lebih diutamakan </option>

                                                    <option value="8_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 8 && $db_set_radio[$var] == 1) echo "selected"; ?>>6: Kriteria <?= $kriteria_arr[$i]; ?> dan <?= $kriteria_arr[$i + $start]; ?>lebih diutamakan, tapi kriteria <?= $kriteria_arr[$i]; ?> sedikit sangat diutamakan </option>

                                                    <option value="9_1" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 9 && $db_set_radio[$var] == 1) echo "selected"; ?>>9: Kriteria <label class="me-text-bold"><?= $kriteria_arr[$i]; ?></label> sangat diutamakan </option>

                                                </optgroup>


                                                <!-- Kriteria 1 dan 2 setara, tapi kriteria 1 lebih diutamakan -->
                                                <!-- <option value="0_1">0; Elemen 0</option> -->

                                                <optgroup label="Kriteria <?= $kriteria_arr[$start + $i]; ?>">
                                                    <option value="2_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 2 && $db_set_radio[$var] == 2) echo "selected"; ?>>2: Kriteria <?= $kriteria_arr[$start + $i]; ?> dan <?= $kriteria_arr[$i]; ?> setara, tapi kriteria <?= $kriteria_arr[$start + $i]; ?> cukup diutamakan </option>

                                                    <option value="3_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 3 && $db_set_radio[$var] == 2) echo 'selected'; ?>>3: Kriteria <?= $kriteria_arr[$start + $i]; ?> cukup diutamakan </option>

                                                    <option value="4_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 4 && $db_set_radio[$var] == 2) echo "selected"; ?>>4: Kriteria <?= $kriteria_arr[$start + $i]; ?> dan <?= $kriteria_arr[$i]; ?> cukup diutamakan, tapi kriteria <?= $kriteria_arr[$start + $i]; ?> sedikit diutamakan </option>

                                                    <option value="5_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 5 && $db_set_radio[$var] == 2) echo "selected"; ?>>5: Kriteria <?= $kriteria_arr[$start + $i]; ?> diutamakan </option>

                                                    <option value="6_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 6 && $db_set_radio[$var] == 2) echo "selected"; ?>>6: Kriteria <?= $kriteria_arr[$start + $i]; ?> dan <?= $kriteria_arr[$i]; ?> diutamakan, tapi kriteria <?= $kriteria_arr[$start + $i]; ?> sedikit lebih diutamakan </option>

                                                    <option value="7_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 7 && $db_set_radio[$var] == 2) echo "selected"; ?>>7: Kriteria <?= $kriteria_arr[$start + $i]; ?> lebih diutamakan </option>

                                                    <option value="8_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 8 && $db_set_radio[$var] == 2) echo "selected"; ?>>6: Kriteria <?= $kriteria_arr[$start + $i]; ?> dan <?= $kriteria_arr[$i]; ?>lebih diutamakan, tapi kriteria <?= $kriteria_arr[$start + $i]; ?> sedikit sangat diutamakan </option>

                                                    <option value="9_2" <?php if (count($db_set_radio) != 0) if ($nilai_perb[$var] == 9 && $db_set_radio[$var] == 2) echo "selected"; ?>>9: Kriteria <?= $kriteria_arr[$start + $i]; ?> sangat diutamakan </option>
                                                </optgroup>


                                            </select>
                                        </td>
                                        <td>
                                            <div>
                                                <input type="text" name="kriteria2[]" value="<?= $id_kriteria[$start + $i]; ?>" hidden>
                                                <?php if (count($db_set_radio) != 0) { ?>
                                                    <?php if ($db_set_radio[$var] == 1) { ?>
                                                        <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$start + $i]; ?></label>
                                                    <?php } else { ?>
                                                        <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$i]; ?></label>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <label id="kriteria<?= $temp; ?>"><?= $kriteria_arr[$start + $i]; ?></label>
                                                <?php } ?>
                                                <?php $temp++; ?>
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

<script>
    function exchange(select, krit) {
        let selectElemen = document.getElementById('nilaiElemen' + select);
        const namaKrit1 = document.getElementById('kriteria' + krit).innerText;
        console.log(namaKrit1);
        let krit2 = krit + 1;
        const namaKrit2 = document.getElementById('kriteria' + krit2).innerText;


        // console.log('Punya nilaiElemen' + select);
        // console.log(valSelect);

        let valSelect = selectElemen.value;
        let lastChar = valSelect.substr(valSelect.length - 1);
        let valOption = selectElemen.options[selectElemen.selectedIndex].text;
        const myArray = valOption.split(" ");

        // console.log(myArray[2]);

        if (namaKrit1 !== myArray[2] && myArray[2] !== "kriteria" && myArray[2] !== "kepentingan") {
            document.getElementById('kriteria' + krit).innerText = namaKrit2;
            document.getElementById('kriteria' + krit2).innerText = namaKrit1;
        }
    }
</script>
