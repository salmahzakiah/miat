<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <style>
        .tabelAtas {
            text-align: center;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>
    <div align="center">
        <h2>Laporan Penerimaan Dana Bantuan Pendidikan</h2>

        <table class="tabelAtas mt-5">
            <tr>
                <th rowspan="5">
                    <img src="<?= base_url('assets/img/profile/logo.jpeg'); ?>" height="100px">
                </th>
                <td style="font-size: 28px;">MADRASAH IBTIDAIYAH AT-TAUBAH</td>
            </tr>
            <tr>
                <td style="font-size: 28px;">(MIAT)</td>
            </tr>
            <tr>
                <td>NOTARIS : YUNITA ARISTINA, SH. M.Kn No.AHU-006.AH.O2.O2-Th.2013</td>
            </tr>
            <tr>
                <td>Sekretariat : Jl Kemakmuran No.7 Kel.Margajaya Bekasi Selatan Telp.(021)8896 4612</td>
            </tr>
        </table>
        <hr>

        <br>
        <!-- Mulai Tabel Data -->
        <div class="card-body">
            <?php if (!empty($data_scroring)) : ?>
                <table style="width: 100%; text-align: center;" class="mt-5">
                    <thead>
                        <tr>
                            <th scope="col" class="align-middle">NO</th>
                            <th scope="col" class="align-middle">NAMA</th>
                            <th scope="col" class="align-middle">NIK</th>
                            <th scope="col" class="align-middle">ALAMAT</th>
                            <th scope="col" class="align-middle">SCORE</th>
                            <th scope="col" class="align-middle">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data_scroring as $scr) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $scr['nama']; ?></td>
                                <td><?= $scr['nik']; ?></td>
                                <td><?= $scr['alamat']; ?></td>
                                <td><?= $scr['score']; ?></td>
                                <td><?= $scr['status']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Data scoring tidak tersedia.</p>
            <?php endif; ?>
        </div>
        <!-- Akhir Tabel Data -->

        <br><br>
        <div align="Right" class="mt-5">
            <table>
                <tr>
                    <td>Bekasi, <?= date("d M Y") ?></td>
                </tr>
                <tr>
                    <td>Kepala MI AT-TAUBAH</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><?= $nama_terang; ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
