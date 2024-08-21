<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="m-3"></div>
	
	<!-- Content -->
<div class="m-3">
    <div class="card rounded">

        <?= $this->session->flashdata('success'); ?>
        <div class="card-body">
            <table class="table table-bordered" style="max-width: 40rem;">
                <thead>
                    <tr style="background-color: #F9FAFB; font-size: 13px;">
                        <th class="align-middle" style="width: 20px;">No</th>
                        <th class="align-middle">Kriteria</th>
                        <th class="align-middle">Subkriteria</th>
                        <th class="align-middle text-center" style="width: 100px;">Edit &<br> Hapus</th>
                        <th class="align-middle text-center" style="width: 40px;">Aksi <br> Tambah</th>
                        <th class="align-middle text-center" style="width: 40px;">Prioritas <br> Elemen</th>
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

                            <?php
                            if (count($subkriteria->result_array()) == 0) {
                                echo "<td>-</td>";
                                echo "<td class='text-center'>-</td>";
                                echo '<td class="text-center align-middle" rowspan="' . count($subkriteria->result_array()) . '"><a href="' . base_url('spk/subkriteria/tambahsub/') . $kr['id_kriteria'] . '" class="btn btn-primary" style="font-size:19px;">Tambah Subkriteria</a></td>';
                            } else {
                                $temp = 0;
                                foreach ($subkriteria->result_array() as $subkr) :
                                    if ($temp == 0) {
                                        echo "<td>" . $subkr['nama_subkriteria'] . "</td>";

                                        echo '<td class="text-center align-middle">
                                        
                                        <a href="' . base_url('spk/subkriteria/edit_sub/') . $subkr['id_subkriteria'] . '" class="btn btn-warning" style="font-size:11px;"><i class="bi bi-pencil-square"></i></a>
                                         <div class="my-2"></div>
                                        <a href="' . base_url('spk/subkriteria/hapus_sub/') . $subkr['id_subkriteria'] . '/' . $kr['id_kriteria'] . '" class="btn btn-danger" style="font-size:11px;"><i class="bi bi-trash"></i></a>
                                        
                                        </td>';

                                        echo '<td class="text-center align-middle" rowspan="' . count($subkriteria->result_array()) . '"><a href="' . base_url('spk/subkriteria/tambahsub/') . $kr['id_kriteria'] . '" class="btn btn-primary" style="font-size:11px;"><i class="bi bi-plus"></i></a></td>';

                            ?>

                                        <td class="text-center align-middle" rowspan="<?= count($subkriteria->result_array()); ?>">
                                            <a href="<?= base_url('spk/subkriteria/perband_sub/') . $kr['id_kriteria']; ?>" class="btn <?php echo ($exist_or_no[$j] > 0) ? "btn-success" : "btn-secondary"; ?>" style="font-size:9px;">
                                                <?php if ($exist_or_no[$j++] > 0) { ?>
													Bobot Ada													
                                                <?php } else { ?>
													Bobot Tidak Ada
													<?php } ?>
                                            </a>
                                        </td>

                            <?php

                                        echo "</tr>";
                                        $temp++;
                                    } else if ($temp != 0) {
                                        echo "<tr>";
                                        echo "<td>" . $subkr['nama_subkriteria'] . "</td>";

                                        echo '<td class="text-center align-middle">

                                        <a href="' . base_url('spk/subkriteria/edit_sub/') . $subkr['id_subkriteria'] . '" class="btn btn-warning" style="font-size:11px;"><i class="bi bi-pencil-square"></i></a>
								        <div class="my-2"></div>
                                        <a href="' . base_url('spk/subkriteria/hapus_sub/') . $subkr['id_subkriteria'] . '/' . $kr['id_kriteria'] . '" class="btn btn-danger" style="font-size:11px;"><i class="bi bi-trash"></i></a>
                                        
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
