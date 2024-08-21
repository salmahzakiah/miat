
<!-- Content -->
<div class="m-3">
<div class="card-body">

                            
<?php if (!empty($data_scroring)) : ?>
    <table class="table">
        <thead style="font-size: 13px;background-color: #d9edf7;">
            <tr>
			<th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">NO</th>
            <th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">NAMA</th>
            <th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">NIK</th>
            <th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">ALAMAT</th>
            <th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">SCORE</th>
            <th scope="col" class="align-middle" style="border: 1px solid #858796;text-align: center;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_scroring as $scr) : ?>
                <tr>
				<td style="border: 1px solid #858796;"><?= $no++; ?></td>
                <td style="border: 1px solid #858796;"><?= $scr['nama']; ?></td>
                <td style="border: 1px solid #858796;"><?= $scr['nik']; ?></td>
                <td style="border: 1px solid #858796;"><?= $scr['alamat'];  ?></td>
                <td style="border: 1px solid #858796;"><?= $scr['score']; ?></td>
                <td style="border: 1px solid #858796;"><?= $scr['status'];  ?></td>
				
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Data scoring tidak tersedia.</p>
<?php endif; ?>
</div>
<div 

