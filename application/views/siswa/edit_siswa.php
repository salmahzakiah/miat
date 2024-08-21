<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<div class="m-3">
	<div class="card-header py-3 d-flex justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Edit Siswa</h6>
    </div>
		
	</div>
<!-- Content -->
<div class="m-3">
    <?php if (count($pekerjaan) == 0) { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Subkriteria pekerjaan masih kosong, silahkan menambahkan subkriteria pekerjaan terlebih dahulu <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></div>
    <?php }
	 if (count($tanggungan) == 0) { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Subkriteria tanggungan masih kosong, silahkan menambahkan subkriteria tanggungan terlebih dahulu <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></div>
    <?php }
    if (count($status_siswa) == 0) { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Subkriteria status siswa masih kosong, silahkan menambahkan subkriteria status siswa terlebih dahulu <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></div>
    <?php }
	if (count($transportasi) == 0) { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Subkriteria transportasi siswa masih kosong, silahkan menambahkan subkriteria status siswa terlebih dahulu <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></div>
	<?php }
	if (count($tempat_tinggal) == 0) { ?>
        <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">Subkriteria tempat tinggal siswa masih kosong, silahkan menambahkan subkriteria status siswa terlebih dahulu <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></div>
    <?php } ?>
    <div class="card rounded">
	    <div class="card-body">
            <form class="mx-5 mt-3" method="post" action="<?= base_url('siswa/update/') . $siswa['id_siswa']; ?>">
                <div class="form-group">
                    <label for="InputNama">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" id="InputNama" placeholder="Masukan Nama" value="<?= $siswa['nama']; ?>">
                </div>
                <div class="form-group">
                    <label for="InputNik">NIK</label>
                    <input type="text" name="nik" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="exampleInputPassword1" placeholder="Masukan NIK" value="<?= $siswa['nik']; ?>">
                </div>
                <div class="form-group">
                    <label for="InputAlamat">Alamat</label>
                    <textarea name="alamat" class="form-control" id="InputAlamat" rows="3" placeholder="Masukan Alamat"><?= $siswa['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="InputKelas">Kelas</label>
                    <input type="text" name="kelas" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="kelas" style="width: 240px; " placeholder="Masukan Usia" value="<?= $siswa['kelas']; ?>">
                </div>
				<div class="form-group">
                    <label for="InputNama_Orangtua">Nama OrangTua</label>
                    <input type="text" name="nama_orangtua" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="nama_orangtua" style="width: 240px; " placeholder="Masukan Nama OrangTua" value="<?= $siswa['nama_orangtua']; ?>">
                </div>
                <div class="form-group">
                    <label for="InputPekerjaan">Pekerjaan</label>
                    <select name="pekerjaan" class="form-control" style="width: 240px;" id="InputPekerjaan" onchange="nochoice(this.value)">
                        <option value="" selected disabled>Pilih Pekerjaan</option>
                        <?php foreach ($pekerjaan as $p) : ?>
                            <option value="<?= $p['nama_subkriteria']; ?>" <?php if ($siswa['pekerjaan'] == $p['nama_subkriteria']) echo "selected" ?>><?= $p['nama_subkriteria']; ?></option>
                        <?php endforeach; ?>
                        <?php foreach ($pekerjaan_setara as $ps) : ?>
                            <option value="<?= $ps['nama_pekerjaansama']; ?>" <?php if ($ps['nama_pekerjaansama'] == $siswa['pekerjaan']) echo "selected"; ?>><?= $ps['nama_pekerjaansama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="InputPekerjaanText" id="textInputPekerjaan" style="display: none;">Masukan Pekerjaan</label>
                    <input type="text" name="pekerjaanInput" id="pekerjaan" class="form-control" style="display: none; width: 240px;">
                </div>
                <div class="form-group w-25">
                    <label for="InputPenghasilan">Penghasilan</label>
                    <input type="text" name="penghasilan" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" style="width: 240px;" id="exampleInputPassword1" placeholder="Masukan Angka" value="<?= $siswa['penghasilan']; ?>">
                </div>
                <div class="form-group">
                    <label for="InputTanggungan">Jumlah Saudara</label>
                    <input type="text" name="tanggungan" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" id="tanggungan" style="width: 240px; " placeholder="Masukan Jml Saudara" value="<?= $siswa['tanggungan']; ?>">
                </div>
                  <div class="form-group w-25">
                    <label for="InputStatus_Siswa">Status Siswa</label>
                    <select name="status_siswa" class="form-control" id="InputStatus_Siswa" style="width: 240px;">
                        <option value="" selected disabled>Pilih Status Siswa</option>
                        <?php foreach ($status_siswa as $sp) : ?>
                            <option value="<?= $sp['nama_subkriteria']; ?>" <?php if ($siswa['status_siswa'] == $sp['nama_subkriteria']) echo "selected"; ?>><?= $sp['nama_subkriteria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
				<div class="form-group w-25">
                    <label for="InputJarak_Rumah">Jarak Rumah-Madrasah</label>
                    <select name="jarak_rumah" class="form-control" id="InputJarak_Rumah" style="width: 240px;">
                        <option value="" selected disabled>Pilih Jarak Rumah</option>
                        <?php foreach ($jarak_rumah as $sp) : ?>
                            <option value="<?= $sp['nama_subkriteria']; ?>" <?php if ($siswa['jarak_rumah'] == $sp['nama_subkriteria']) echo "selected"; ?>><?= $sp['nama_subkriteria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
				<div class="form-group w-25">
                    <label for="InputTranportasi">Transportasi Rumah-Madrasah</label>
                    <select name="transportasi" class="form-control" id="InputTransportasi" style="width: 240px;">
                        <option value="" selected disabled>Pilih Transportasi</option>
                        <?php foreach ($transportasi as $sp) : ?>
                            <option value="<?= $sp['nama_subkriteria']; ?>" <?php if ($siswa['transportasi'] == $sp['nama_subkriteria']) echo "selected"; ?>><?= $sp['nama_subkriteria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
				<div class="form-group w-25">
                    <label for="InputTempat_Tinggal">Status Tempat Tinggal Siswa</label>
                    <select name="tempat_tinggal" class="form-control" id="InputTempat_Tinggal" style="width: 240px;">
                        <option value="" selected disabled>Pilih Tempat Tinggal</option>
                        <?php foreach ($tempat_tinggal as $sp) : ?>
                            <option value="<?= $sp['nama_subkriteria']; ?>" <?php if ($siswa['tempat_tinggal'] == $sp['nama_subkriteria']) echo "selected"; ?>><?= $sp['nama_subkriteria']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
				<?php
                // Validasi input
                $pekerjaan_valid = is_array($pekerjaan) || $pekerjaan instanceof Countable;
                $status_siswa_valid = is_array($status_siswa) || $status_siswa instanceof Countable;
                $jarak_rumah_valid = is_array($jarak_rumah) || $jarak_rumah instanceof Countable;
                $transportasi_valid = is_array($transportasi) || $transportasi instanceof Countable;
                $tempat_tinggal_valid = is_array($tempat_tinggal) || $tempat_tinggal instanceof Countable;

                // Set disabled jika salah satu variabel tidak valid atau kosong
                $disabled = !$pekerjaan_valid || !$status_siswa_valid || !$jarak_rumah_valid || !$transportasi_valid || !$tempat_tinggal_valid || count($pekerjaan) == 0 || count($status_siswa) == 0 || count($jarak_rumah) == 0 || count($transportasi) == 0 || count($tempat_tinggal) == 0;
                ?>
				<a href="<?= base_url('siswa'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
                <button type="submit" class="btn btn-primary float-right" <?php if ($disabled) echo "disabled"; ?>>
                    <i class="bi bi-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function nochoice(value) {
        let InputText = document.getElementById('pekerjaan');
        let LabelInput = document.getElementById('textInputPekerjaan');
        if (value == 'Tambah Pekerjaan') {
            InputText.style.display = 'block';
            LabelInput.style.display = 'block';
        } else {
            InputText.style.display = 'none';
            LabelInput.style.display = 'none';
        }
    }
</script>
