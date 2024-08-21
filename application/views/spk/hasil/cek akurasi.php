<!-- Content -->
<div class="m-3">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="mr-auto bd-highlight">
                    <a href="<?= base_url('spk/hasil/scoring/') . $id_periode; ?>" class="btn btn-warning"><span><i class="bi bi-arrow-left"></i> Kembali</span> </a>
                </div>
                <div class="">
                    <div class="input-icons">
                        <i class="bi bi-search icon"></i>
                        <input type="text" name="search" id="myInputSearch" class="input-field" placeholder="search...">
                    </div>
                </div>
            </div>
            <hr>
            <div>
                <h6>Input Data untuk Akurasi</h6>
                <form method="POST" action="<?= base_url('spk/hasil/cek_akurasi/') . $id_periode; ?>" enctype="multipart/form-data">
                    <div class="input-group" style="width: 20rem;">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" onchange="pressed()" name="file" id="inputFile" aria-describedby="inputGroupFileAddon01" accept=".xls, .xlsx" required>
                            <label for="inputFile" class="custom-file-label" id="fileLabel">Choose file</label>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary ml-3">Upload</button>

                    </div>
                    <div class="input-group mb-2">
                        <span class="text-danger font-italic" style="font-size: 12px;"><?= $this->session->flashdata('import_validation'); ?></span>
                    </div>

                </form>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-center">
                    <thead style="font-size: 13px;">
                        <tr>
                            <th scope="col" colspan="3" class="align-middle">Hasil AHP</th>
                            <th scope="col" colspan="3" class="align-middle">Hasil Sebenarnya</th>
                        </tr>
                        <tr>
                            <th scope="col" class="align-middle">No</th>
                            <th scope="col" class="align-middle">Nama</th>
                            <th scope="col" class="align-middle">Status</th>
                            <th scope="col" class="align-middle">No</th>
                            <th scope="col" class="align-middle">Nama</th>
                            <th scope="col" class="align-middle">Status</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px;">
                        <tr>
                            <td>1</td>
                            <td>-</td>
                            <td>-</td>
                            <td>1</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
