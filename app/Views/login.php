<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Welcome to UCN Garage</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .bg-gradient-primary {
        background-image: url('<?= base_url() ?>img/bgPabrik.jpg') !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        /* agar background tidak scroll */
    }

    .card-transparent {
        background: rgba(255, 255, 255, 0.7) !important;
        /* 0.7 = 70% opacity */
        backdrop-filter: blur(5px);
        /* opsional, efek kaca */
    }
</style>


<body class="bg-gradient-primary">
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card bg-gradient-light o-hidden border-0 shadow-lg my-5 card-transparent">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <!-- box login -->
                        <div id="diagnosaBox" style="display:none;">
                            <div class="row">
                                <div class="col-lg-2 d-none d-lg-block bg-login-image">
                                    <img src="<?= base_url() ?>img/logoR.png" width="100%" style="padding: 10px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-2">
                                        <h1 class="text-gray-900 mb-2" style="font-size: 2.5rem; padding-top:10px;">Check Kerusakan</h1>
                                        <p>Isi form dan pilih gejala kerusakan atau keluhan anda!!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <form action="<?= base_url('/diagnosa/check') ?>" method="post">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            placeholder="Enter Email pengguna">
                                    </div>
                                    <div class="form-group">
                                        <input type="nama" name="nama" class="form-control form-control-user"
                                            placeholder="Nama Pengguna">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="jenis" class="form-control form-control-user"
                                            placeholder="Input Jenis Motor" oninput="this.value = this.value.toUpperCase();">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="merek" class="form-control form-control-user"
                                            placeholder="Input Merek Motor" oninput="this.value = this.value.toUpperCase();">
                                    </div>

                                    <div class="form-group">
                                        <div class="table-responsive" style="max-height: 200px; margin: 10px;">
                                            <table class="table">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Kode Gejala</th>
                                                    <th>Nama Gejala</th>
                                                    <th>Pilih (YA)</th>
                                                </tr>
                                                <?php if (!empty($gejala)): ?>
                                                    <?php $no = 1;
                                                    foreach ($gejala as $row): ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= esc($row['kode_gejala']) ?></td>
                                                            <td><?= esc($row['nama_gejala']) ?></td>
                                                            <td>
                                                                <!-- Checkbox untuk YA -->
                                                                <input type="checkbox"
                                                                    name="gejala[]"
                                                                    value="<?= $row['kode_gejala'] ?>">
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">Data tidak ada</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        Check
                                    </button>
                                    <hr>
                                    <div class="text-center row">
                                        <div class="col">
                                            <a class="btn btn-primary btn-user btn-block show-login" href="#" id="showLogin">Login</a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-info btn-user btn-block show-register" href="#" id="showRegister">About</a>
                                        </div>
                                        <div class="col">
                                            <a class="btn btn-warning btn-user btn-block show-Result" href="#" id="showResult">Hasil</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div id="HasilCheck" style="display: none;">
                            <div class="card-body">
                                <div class="text-center">
                                    <a class="btn btn-primary btn-block show-diagnosa" href="#" id="showDiagnosa">Check Kerusakan!</a>
                                </div>
                                <hr>
                                <?php
                                $trace = session()->get('trace');
                                $tree = session()->get('tree');
                                $gejalaTerpilih = session()->get('gejalaTerpilih');
                                $hasil = session()->get('hasil');
                                $evaluasi = session()->get('evaluasi');
                                ?>

                                <!-- Akurasi -->
                                <?php if ($evaluasi): ?>
                                    <div class="alert alert-info">
                                        <b>Akurasi Model:</b> <?= esc($evaluasi['accuracy']) ?>% <br>
                                        <small>Benar: <?= esc($evaluasi['correct']) ?> dari <?= esc($evaluasi['total']) ?> data</small>
                                    </div>
                                <?php endif; ?>

                                <!-- Hasil diagnosa -->
                                <div class="mb-4">
                                    <h4 class="text-primary">Hasil Diagnosa</h4>
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item active">Gejala Terpilih:</li>
                                        <?php if (!empty($gejalaTerpilih)): ?>
                                            <?php foreach ($gejalaTerpilih as $g): ?>
                                                <li class="list-group-item"><?= esc($g) ?></li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="list-group-item text-muted">Data belum terpilih</li>
                                        <?php endif; ?>
                                    </ul>
                                    <p>
                                        <b class="text-success">Kerusakan:</b>
                                        <?= esc($hasil['nama_kerusakan'] ?? 'Tidak diketahui') ?>
                                    </p>
                                </div>

                                <!-- Tabel entropy & gain -->
                                <?php if (!empty($trace['gain'])): ?>
                                    <h4 class="text-primary">Perhitungan Entropy & Gain</h4>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-bordered table-striped">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Atribut</th>
                                                    <th>Entropy Sebelum</th>
                                                    <th>Entropy Sesudah</th>
                                                    <th>Gain</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($trace['gain'] as $g): ?>
                                                    <tr>
                                                        <td><?= esc($g['attribute']) ?></td>
                                                        <td><?= round($g['entropy_before'], 4) ?></td>
                                                        <td><?= round($g['entropy_after'], 4) ?></td>
                                                        <td class="text-primary"><b><?= round($g['gain'], 4) ?></b></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>

                                <!-- Pohon Keputusan -->
                                <h4 class="text-primary">Pohon Keputusan</h4>
                                <div class="p-3 bg-light border rounded mb-4" style="max-height: 300px; overflow-y: auto;">
                                    <?php if (!empty($trace['tree'])): ?>
                                        <ul class="list-unstyled">
                                            <?php foreach ($trace['tree'] as $step): ?>
                                                <li><code><?= esc($step) ?></code></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-muted">Pohon keputusan belum terbentuk.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Evaluasi detail -->
                                <?php if ($evaluasi): ?>
                                    <h4 class="text-primary">Evaluasi Detail</h4>
                                    <div class="p-3 bg-light border rounded">
                                        <pre><?= print_r($evaluasi, true) ?></pre>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <!-- box login -->
                        <div id="loginBox" class="row" style="display:none;">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="<?= base_url() ?>img/logoR.png" width="100%" style="padding: 20px;">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        <?php if (session()->getFlashdata('error')): ?>
                                            <p style="color:red"><?= session()->getFlashdata('error') ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" method="post" action="<?= base_url('/auth/loginProcess') ?>">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small show-register" href="#" id="showRegister">Buat Akun!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small show-diagnosa" href="#" id="showDiagnosa">Check Kerusakan!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- box register -->
                        <div id="registerBox" class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
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

                                    <hr>
                                    <div class="text-center">
                                        <a class="small show-login" href="#" id="showLogin">Login!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small show-diagnosa" href="#" id="showDiagnosa">Check Kerusakan Motor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script>
        // Tampilkan Register
        document.querySelectorAll(".show-register").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("loginBox").style.display = "none";
                document.getElementById("diagnosaBox").style.display = "none";
                document.getElementById("registerBox").style.display = "flex";
            });
        });

        // Tampilkan Login
        document.querySelectorAll(".show-login").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("registerBox").style.display = "none";
                document.getElementById("diagnosaBox").style.display = "none";
                document.getElementById("loginBox").style.display = "flex";
            });
        });

        // Tampilkan Diagnosa
        document.querySelectorAll(".show-diagnosa").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("registerBox").style.display = "none";
                document.getElementById("loginBox").style.display = "none";
                document.getElementById("HasilCheck").style.display = "none";
                document.getElementById("diagnosaBox").style.display = "block";
            });
        });

        document.querySelectorAll(".show-Result").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                document.getElementById("registerBox").style.display = "none";
                document.getElementById("loginBox").style.display = "none";
                document.getElementById("HasilCheck").style.display = "block";
                document.getElementById("diagnosaBox").style.display = "none";
            });
        });
    </script>
    <?php if (session()->get('showResult')): ?>
        <script>
            document.getElementById('HasilCheck').style.display = 'block';
            document.getElementById("registerBox").style.display = "none";
            document.getElementById("loginBox").style.display = "none";
            document.getElementById("diagnosaBox").style.display = "none";
        </script>
    <?php endif; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>