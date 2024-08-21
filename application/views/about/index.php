<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title_page; ?></title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="container">
        <h2><?php echo $title_page; ?></h2>
        
        <?php if (!empty($data_scoring)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Status Penerima</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data_scoring as $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['nik']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['score']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo isset($row['status_penerima']) ? $row['status_penerima'] : 'Belum diproses'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Tidak ada data untuk ditampilkan.</p>
        <?php endif; ?>
    </div>
</body>
</html>
