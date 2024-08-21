<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800"><?= $title_page; ?></h1>
<div class="card-header">

</div>


<!-- Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats mt-3">
                <div class="card-body" style="background: linear-gradient(to left, #ffcc00 0%, #ff9900 100%);">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <span style="font-size: 5em;" class="iconify text-white" data-icon="dashicons:clock"></span>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="text-right mt-3">
                                <span class="card-category text-white" style="font-size: 15px;">Total Periode</span>
                                <h3 class="card-title text-white" style="margin-bottom:-2px"><?= $total_periode; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-white" style="background: linear-gradient(to left, #ffcc00 0%, #ff9900 100%);">
                    <div class="stats">
                        <i class="bi bi-arrow-repeat text-white"></i><span style="font-size: 13px;" class="text-white"> Update terbaru</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats mt-3">
                <div class="card-body " style="background: linear-gradient(to left, #ffcc66 0%, #ff3300 100%);">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <span class="iconify" data-icon="academicons:open-data" style="color: white; font-size:5em;"></span>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers text-right mt-3">
                                <span class="card-category text-white">Total Kriteria</span>
                                <h4 class="card-title text-white"><?= $total_kriteria; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-white" style="background: linear-gradient(to left, #ffcc66 0%, #ff3300 100%);">
                    <div class="stats">
                        <i class="bi bi-bezier2 text-white"></i> <span class="text-white" style="font-size: 13px;"> Kriteria AHP</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats mt-3">
                <div class="card-body " style="background: linear-gradient(to left, #33cccc 0%, #0066ff 100%);">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <span class="iconify" data-icon="fluent:people-checkmark-16-filled" style="color: white; font-size: 5em;"></span>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="numbers text-white text-right mt-3">
                                <span class="card-category text-white">Total Data</span>
                                <h4 class="card-title"><?= $total_data; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-white" style="background: linear-gradient(to left, #33cccc 0%, #0066ff 100%);">
                    <div class="stats">
                        <i class="bi bi-bar-chart text-white"></i> <span style="font-size: 13px;" class="text-white"> Total Data Siswa</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card card-stats mt-3">
                <div class="card-body " style="background: linear-gradient(to left, #99cc00 0%, #336600 100%);">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center icon-warning">
                                <span class="iconify" data-icon="ion:analytics-sharp" style="color: white; font-size:5em;"></span>
                            </div>
                        </div>
                        <div class="col-7 mt-2">
                            <div class="numbers text-right mt-3">
                                <h5 class="card-title text-white">Metode AHP</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top border-white" style="background: linear-gradient(to left, #99cc00 0%, #336600 100%);">
                    <div class="stats">
                        <span class="iconify" data-icon="icon-park-outline:market-analysis" style="color: white;"></span> <span class="text-white" style="font-size: 13px;"> Analytics Hierarchy Process</span>
                    </div>
                </div>
            </div>
        </div>
		<div class="card mt-3">
		<div class="card-body" style="font-size: 16px;">
		Metode AHP atau <i>Analythical Hierarci Process</i> adalah model sistem pendukung keputusan dimana menguraikan masalah multi faktor atau multi kriteria yang kompleks menjadi sebuah hierarki dimana struktur dalam hirarki direpresesntasikan dengan struktur multilevel dengan level pertama adalah goal atau tujuan, yang diikuti kriteria, subkriteria, dan paling akhir adalah alternatif.
                </a>
                </>
            </div>
    </div>
</div>
