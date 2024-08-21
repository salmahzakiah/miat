<!-- Content -->
<div class="m-3">
    <?php if ($sub != "angka") { ?>
        <div class="alert alert-warning mt-3"><i class="bi bi-info-circle"></i> Memasukan form hanya dapat 2 kata</div>
    <?php } ?>
    <div class="card rounded">
        <div class="card-body">
            <?php if ($sub == "angka") { ?>
                <form action="<?= base_url('spk/subkriteria/insert_subKrit_angka/') . $id_kriteria; ?>" method="POST">
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label" id="label1">Nilai 1</label>
                        <div class="col-sm-10">
                            <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control w-25" style="font-size: 12px;" name="nilai1" id="inputSub1" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label">Operator</label>
                        <div class="col-sm-10">
                            <select name="antara" id="operator" onchange="setInput()" class="form-control w-25" style="font-size: 12px;">
                                <option value="" disabled selected>Pilih Operator</option>
                                <option value="-">Diantara Keduanya</option>
                                <option value="<">Lebih Kecil (<) </option>
                                <option value=">">Lebih Besar (>)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label" id="label2">Nilai 2</label>
                        <div class="col-sm-10">
                            <input type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control w-25" style="font-size: 12px;" name="nilai2" id="inputSub2" value="">
                        </div>
                    </div>
					<a href="<?= base_url('spk/subkriteria/index'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>
            <?php } else { ?>
                <form action="<?= base_url('spk/subkriteria/insert_subKrit/') . $id_kriteria; ?>" method="POST">
                    <div class="form-group row">
                        <label for="inputSub" class="col-sm-2 col-form-label">Sub Kriteria</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control w-25" name="subkriteria" id="inputSub" value="">
                        </div>
                    </div>
					<a href="<?= base_url('spk/subkriteria/index'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>
            <?php } ?>
        </div>
    </div>
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
</script>
