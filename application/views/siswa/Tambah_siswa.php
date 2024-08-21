<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="m-3">
        <div class="card-header py-3 d-flex justify-content-between"></div>

        <?php if (count($pekerjaan) == 0) { ?>
            <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
                Subkriteria pekerjaan masih kosong, silahkan menambahkan subkriteria pekerjaan terlebih dahulu 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <?php if (count($status_siswa) == 0) { ?>
            <div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
                Subkriteria status siswa masih kosong, silahkan menambahkan subkriteria status siswa terlebih dahulu 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <!-- Omitted code for other alerts and form elements -->

        <div class="card rounded">
            <div class="card-body">
                <form class="mx-5 mt-3" id="form_siswa" method="post" action="<?= base_url('siswa/input/') . $id_periode; ?>">
                    <!-- Form fields -->
                    <div class="form-group">
                        <label for="InputNama">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="InputNama" placeholder="Masukan Nama" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="InputNik">NIK</label>
                        <input type="text" name="nik" class="form-control" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))" id="InputNik" placeholder="Masukan NIK" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="InputAlamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="InputAlamat" rows="3" placeholder="Masukan Alamat" autocomplete="off"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" name="kelas" class="form-control" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))" id="kelas" style="width: 240px;" placeholder="Masukan Kelas" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama_orangtua">Nama OrangTua</label>
                        <input type="text" name="nama_orangtua" class="form-control" id="nama_orangtua" style="width: 240px;" placeholder="Masukan Nama Ayah/Ibu" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="InputPekerjaan">Pekerjaan</label>
                        <select name="pekerjaan" class="form-control" style="width: 240px;" id="InputPekerjaan" required>
                            <option value="" selected disabled>Pilih Pekerjaan</option>
                            <?php foreach ($pekerjaan as $p) : ?>
                                <option value="<?= $p['nama_subkriteria']; ?>"><?= $p['nama_subkriteria']; ?></option>
                            <?php endforeach; ?>
                            <?php foreach ($pekerjaan_setara as $ps) : ?>
                                <option value="<?= $ps['nama_pekerjaansama']; ?>"><?= $ps['nama_pekerjaansama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" id="textInputPekerjaan" style="display: none;">
                        <label for="InputPekerjaanText">Masukan Pekerjaan</label>
                        <input type="text" name="pekerjaanInput" id="pekerjaan" class="form-control" style="width: 240px;">
                    </div>
                    <div class="form-group w-25">
                        <label for="InputPenghasilan">Penghasilan</label>
                        <input type="text" name="penghasilan" class="form-control" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))" style="width: 240px;" id="InputPenghasilan" placeholder="Masukan Angka" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="tanggungan">Jumlah Saudara</label>
                        <input type="text" onkeypress="return (event.charCode != 8 && event.charCode == 0 || (event.charCode >= 48 && event.charCode <= 57))" name="tanggungan" class="form-control" id="tanggungan" style="width: 240px;" placeholder="Masukan Jumlah Saudara" autocomplete="off">
                    </div>
                    <div class="form-group w-25">
                        <label for="InputStatus_Siswa">Status Siswa</label>
                        <select name="status_siswa" class="form-control" id="InputStatus_Siswa" style="width: 240px;" required>
                            <option value="" selected disabled>Pilih Status Siswa</option>
                            <?php foreach ($status_siswa as $sp) : ?>
                                <option value="<?= $sp['nama_subkriteria']; ?>"><?= $sp['nama_subkriteria']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group w-25">
                        <label for="InputJarak_Rumah">Jarak Rumah-Madrasah</label>
                        <select name="jarak_rumah" class="form-control" id="InputJarak_Rumah" style="width: 240px;" required>
                            <option value="" selected disabled>Pilih Jarak Rumah</option>
                            <?php foreach ($jarak_rumah as $sp) : ?>
                                <option value="<?= $sp['nama_subkriteria']; ?>"><?= $sp['nama_subkriteria']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group w-25">
                        <label for="InputTransportasi">Transportasi Rumah-Madrasah</label>
                        <select name="transportasi" class="form-control" id="InputTransportasi" style="width: 240px;" required>
                            <option value="" selected disabled>Pilih Transportasi</option>
                            <?php foreach ($transportasi as $sp) : ?>
                                <option value="<?= $sp['nama_subkriteria']; ?>"><?= $sp['nama_subkriteria']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group w-25">
                        <label for="InputTempat_Tinggal">Status Tempat Tinggal Siswa</label>
                        <select name="tempat_tinggal" class="form-control" id="InputTempat_Tinggal" style="width: 240px;" required>
                            <option value="" selected disabled>Pilih Tempat Tinggal</option>
                            <?php foreach ($tempat_tinggal as $sp) : ?>
                                <option value="<?= $sp['nama_subkriteria']; ?>"><?= $sp['nama_subkriteria']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <a href="<?= base_url('siswa'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
					<button type="submit" class="btn btn-primary float-right">
    <i class="bi bi-save"></i> Simpan
</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->

<!-- Include jQuery and AJAX script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        console.log('jQuery is loaded');

        $('#form_siswa').submit(function(e) {
            e.preventDefault();
            console.log('Form submitted');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log('Success', response);
                    alert('Tambah data telah berhasil');
                    window.location.href = '<?= base_url("siswa/index"); ?>';
                },
                error: function(xhr, status, error) {
                    console.error('Error', xhr, status, error);
                    alert('Gagal menambahkan data.');
                }
            });
        });
    });
</script>
