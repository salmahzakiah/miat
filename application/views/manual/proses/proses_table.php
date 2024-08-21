<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="m-3"></div>
<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <table class="table table-bordered" style="max-width: 40rem;">
                <thead>
                    <tr style="background-color: #d9edf7; font-size: 13px;">
                        <th class="align-middle" style="width: 20px;">No</th>
                        <th class="align-middle">Kriteria</th>
                        <th class="align-middle text-center" style="width: 40px;">
                            <div class="d-flex flex-row">
                                <div>
                                    Bobot <br> Kriteria
                                </div>
                                <div class="ml-3 align-middle">
                                    <?php
                                    // buat cek bobot kosong tidak
                                    $cek = 0;
                                    foreach ($kriteria as $kr) :
                                        if ($kr['bobot'] == null) {
                                            $cek++;
                                        }
                                    endforeach;
                                    ?>
                                    <?php
                                    if ($cek != count($kriteria)) { ?>
                                        <a href="<?= base_url('spk/proses/proses_kriteria'); ?>" class="mt-2 btn btn-primary" style="font-size:11px;">Lanjut Step</a>
                                    <?php } else { ?>
                                        <a href="#" class="mt-2 btn btn-warning disabled" style="font-size:11px;"><i class="bi bi-exclamation-circle"></i></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </th>
                        <th class=" align-middle">Subkriteria
                        </th>
                        <th class="align-middle text-center" style="width: 100px;">Bobot<br> Subkriteria</th>
                        <th class="align-middle text-center" style="width: 40px;">Cek <br> Proses</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13px;">
                    <?php $i = 1; ?>
                    <?php $j = 0; ?>
                    <?php foreach ($kriteria as $kr) :  ?>
                        <?php
                        $subkriteria = $this->model_subkriteria->data_subkriteria($kr['id_kriteria']);
                        ?>
                        <tr>
                            <td rowspan="<?= count($subkriteria->result_array()); ?>" class="align-middle"><?= $i++; ?></td>
                            <td rowspan="<?= count($subkriteria->result_array()); ?>" class="align-middle"><?= $kr['nama_kriteria']; ?></td>
                            <td rowspan="<?= count($subkriteria->result_array()); ?>" class="align-middle"><?= round($kr['bobot'], 3); ?></td>

                            <?php
                            if (count($subkriteria->result_array()) == 0) {
                                echo "<td>-</td>";
                                echo "<td class='text-center'>-</td>";
                                echo '<td>-</td>';
                            } else {
                                $temp = 0;
                                foreach ($subkriteria->result_array() as $subkr) :
                                    if ($temp == 0) {
                                        echo "<td>" . $subkr['nama_subkriteria'] . "</td>";

                                        echo '<td class="text-center align-middle">' . round($subkr['bobot'], 3) . '
                                        </td>';

                                        if ($subkr['bobot'] != null) {
                                            echo "<td rowspan='" . count($subkriteria->result_array) . "' class='align-middle'><a href='" . base_url('spk/proses/proses_subkriteria/') . $subkr['id_kriteria'] . "' class='btn btn-primary' style='font-size:11px;'><i class='bi bi-arrow-right-square'></i></a></td>";
                                        } else {
                                            echo "<td rowspan='" . count($subkriteria->result_array) . "' class='align-middle'><a href='#' class='btn btn-warning disabled' style='font-size:11px;'><i class='bi bi-exclamation-circle'></i></a></td>";
                                        }
                                        echo "</tr>";
                                        $temp++;
                                    } else if ($temp != 0) {
                                        echo "<tr>";
                                        echo "<td>" . $subkr['nama_subkriteria'] . "</td>";

                                        echo '<td class="text-center align-middle">' . round($subkr['bobot'], 3) . '
                                        </td>';

                                        echo "</tr>";
                                        $temp++;
                                    }
                                endforeach;
                            }
                            ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
