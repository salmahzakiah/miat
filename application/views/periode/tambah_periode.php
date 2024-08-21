<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
	
            <form class="mx-5 mt-3" method="post" action="<?= base_url('periode/input'); ?>">
                <div class="form-group">
                    <label for="InputNamaPeriode">Nama Periode</label>
                    <input type="text" name="nama" class="form-control w-50" id="InputNama" placeholder="Masukan Nama Periode..." autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="inputTanggalAwal">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control w-25" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="inputTanggalAkhir">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control w-25" autocomplete="off" required>
                </div>

                <label for="InputNamaPeriode">Kuota Diterima</label>
                <div class="input-group mb-3 w-50">
                    <input type="text" name="kuota" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="Masukan jumlah kuota..." aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">Orang</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputKeterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control w-50" id="InputAlamat" rows="3" placeholder="Masukan Keterangan..." autocomplete="off" required></textarea>
                </div>
				<a href="<?= base_url('periode'); ?>" class="btn btn-warning mr-2"><i class="bi bi-arrow-left-short"></i>Kembali</a>
                <button type="submit" class="btn btn-primary float-right"><i class="bi bi-save"></i> Simpan</button>
            </form>
        </div>
    </div>
</div>
</div>
