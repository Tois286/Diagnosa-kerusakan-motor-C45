<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Data Gejala
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($gejala) ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <?php
                                    $total   = count($gejala);
                                    $target  = 100;                          // Ubah sesuai jumlah gejala ideal kamu
                                    $persen  = $target > 0 ? round(($total / $target) * 100) : 0;
                                    $persen  = min(100, $persen);           // Biar nggak lebih dari 100%
                                    ?>
                                    <div class="progress-bar bg-info"
                                        role="progressbar"
                                        style="width: <?= $persen ?>%"
                                        aria-valuenow="<?= $total ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= $persen ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Data Kerusakan
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($kerusakan) ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <?php
                                    $total   = count($kerusakan);
                                    $target  = 100;                          // Ubah sesuai jumlah keru$kerusakan ideal kamu
                                    $persen  = $target > 0 ? round(($total / $target) * 100) : 0;
                                    $persen  = min(100, $persen);           // Biar nggak lebih dari 100%
                                    ?>
                                    <div class="progress-bar bg-info"
                                        role="progressbar"
                                        style="width: <?= $persen ?>%"
                                        aria-valuenow="<?= $total ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= $persen ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Data Guest
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($guest) ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <?php
                                    $total   = count($guest);
                                    $target  = 100;                          // Ubah sesuai jumlah keru$kerusakan ideal kamu
                                    $persen  = $target > 0 ? round(($total / $target) * 100) : 0;
                                    $persen  = min(100, $persen);           // Biar nggak lebih dari 100%
                                    ?>
                                    <div class="progress-bar bg-info"
                                        role="progressbar"
                                        style="width: <?= $persen ?>%"
                                        aria-valuenow="<?= $total ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= $persen ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Data Karyawan
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= count($karyawan) ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <?php
                                    $total   = count($karyawan);
                                    $target  = 100;                          // Ubah sesuai jumlah keru$kerusakan ideal kamu
                                    $persen  = $target > 0 ? round(($total / $target) * 100) : 0;
                                    $persen  = min(100, $persen);           // Biar nggak lebih dari 100%
                                    ?>
                                    <div class="progress-bar bg-info"
                                        role="progressbar"
                                        style="width: <?= $persen ?>%"
                                        aria-valuenow="<?= $total ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= $persen ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <!-- Area Chart -->

</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">About</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h1>WELCOME TO UCN GARAGE</h1>
                    <img src="<?= base_url() ?>img/unpam.png" width="100px" style="padding: 10px;">
                    <img src="<?= base_url() ?>img/logoR.png" width="100px" style="padding: 10px;">
                </div>
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">UCN GARAGE</h1>
                    <p style="text-align: justify; color:black;">
                        Inovasi bengkel kami hadir melalui sebuah aplikasi pengecekan
                        kerusakan motor yang dikembangkan oleh mahasiswa Universitas Pamulang
                        sebagai bentuk kontribusi nyata terhadap perkembangan teknologi otomotif.
                        Aplikasi ini dirancang untuk membantu pelanggan melakukan identifikasi awal
                        terhadap kerusakan motor secara mudah, cepat, dan akurat. Melalui fitur analisis
                        gejala kerusakan yang interaktif, pelanggan dapat mengetahui kondisi motor mereka
                        sebelum datang ke bengkel. Dengan demikian, proses pemeriksaan dan perbaikan dapat
                        dilakukan dengan lebih efisien, karena mekanik telah mendapatkan gambaran awal
                        mengenai masalah yang terjadi. Inovasi ini tidak hanya mempersingkat waktu servis,
                        tetapi juga memberikan pengalaman yang lebih nyaman, transparan, dan terpercaya
                        bagi setiap pelanggan.</p>
                </div>
                <p>Dibuat Oleh : KUS JUNIAYANA</p>
            </div>
        </div>
    </div>
</div>