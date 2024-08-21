<!-- Content -->
<div class="m-3">
    <?php if ($sub != "angka") { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert"><i class="bi bi-info-circle"></i> Memasukan form hanya dapat 2 kata
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </div>
    <?php } ?>
    <div class="card rounded">
        <div class="card-body">
            <?php if ($sub == "angka") { ?>
                <form action="<?= base_url('spk/subkriteria/update_subKrit_angka/') . $sub_kriteria['id_subkriteria']; ?>" method="POST">
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label" id="label1">Nilai 1</label>
                        <div class="col-sm-10">
                            <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control w-25" style="font-size: 12px;" name="nilai1" id="inputSub1" value="<?= $nilai1; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label">Operator</label>
                        <div class="col-sm-10">
                            <select name="antara" id="operator" onchange="setInput()" style="font-size: 12px;" class="form-control w-25">
                                <option value="" disabled selected>Pilih Operator</option>
                                <option value="-" <?php if ($antara == "-") echo "selected"; ?>>Diantara Keduanya</option>
                                <option value="<" <?php if ($antara == "&lt;") echo "selected"; ?>>Lebih Kecil (<) </option>
                                <option value=">" <?php if ($antara == "&gt;") echo   "selected"; ?>>Lebih Besar (>)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label" id="label2">Nilai 2</label>
                        <div class="col-sm-10">
                            <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control w-25" style="font-size: 12px;" name="nilai2" id="inputSub2" value="<?= $nilai2; ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>
            <?php } else { ?>
                <form action="<?= base_url('spk/subkriteria/update_subKrit/') . $sub_kriteria['id_subkriteria']; ?>" method="POST">
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label">Sub Kriteria</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-25" name="subkriteria" required="required" id="inputSub" value="<?= $sub_kriteria['nama_subkriteria']; ?>">
                            <label id="alert-word"><i class="text-danger" hidden>*Hanya dua kata saja yang bisa dimasukan</i></label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>

        </div>
    </div>

    <?= $this->session->flashdata('message2'); ?>

    <div class="card mt-3">
        <div class="card-body">
            <h6>Daftar subkriteria yang setara dengan <strong> <?= $sub_kriteria['nama_subkriteria']; ?> </strong></h6>
            <hr>
            <form action="<?= base_url('spk/subkriteria/tambahpekerjaansama/' . $id_subkrit); ?>" method="POST">
                <div class="form-row align-items-center">
                    <div class="col-sm-2 my-1">
                        <label for="inlineFormInputName">Subkriteria Setara</label>
                    </div>
                    <div class="col-sm-3 my-1">
                        <label class="sr-only" for="inlineFormInputName">Name</label>
                        <input type="text" name="pekerjaan_sama" class="form-control" id="inlineFormInputName" placeholder="Cth: Buruh Harian" required>
                    </div>
                    <div class="col-auto my-1">
                        <button type="submit" class="btn btn-success">Tambahkan</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered" style="max-width: 30rem;">
                <thead>
                    <tr style="background-color: #F9FAFB; font-size: 13px;">
                        <th>No</th>
                        <th>Nama Subkriteria</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13px;">
                    <?php


                    $no = 1;
                    if (count($subkrit_sama) == 0) { ?>
                        <tr>
                            <td colspan="3" style="text-align: center;">Belum ada subkriteria sama</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($subkrit_sama as $ss) : ?>

                            <tr>
                                <td>
                                    <?= $no++; ?>
                                </td>
                                <td>
                                    <?= $ss['nama_pekerjaansama']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="<?= base_url('spk/subkriteria/hapusPekerjaanSama/' . $ss['id_pekerjaansama'] . '/' . $id_subkrit); ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                    <?php
                        endforeach;
                    } ?>
                </tbody>
            </table>
			<a href="<?= base_url('spk/subkriteria/index'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>

        </div>
    </div>
<?php } ?>
</div>
<script>
    function setInput() {
        const operator = document.getElementById('operator');
        const input1 = document.getElementById('inputSub1');
        const input2 = document.getElementById('inputSUb2');
        const label1 = document.getElementById('label1');
        const label2 = document.getElementById('label2');

        let value = operator.options[operator.selectedIndex].value;

        console.log(value);

        if (value == '<' || value == '>') {
            input1.setAttribute("disabled", "true");
            label1.innerText = "#";
            label2.innerText = "Nilai";

        } else {
            input1.removeAttribute("disabled");
            label1.innerText = "Nilai 1";
            label2.innerText = "Nilai 2";
        }
    }

    const input = document.getElementById('inputSub');
    const warning = document.getElementById('alert-word');
    const textContent = [];
    let maxWords = 2;

    function separateWords(text, e) {
        let words = text.split(" ");

        if (words.length >= maxWords + 1) {
            input.setAttribute('maxLength', words.join(" ").length - 1);
            return words.join(" ").trim();
        } else {
            return words.join(" ");
        }
    };

    input.addEventListener('input', function() {
        separateWords(input.value);

    });
</script>
