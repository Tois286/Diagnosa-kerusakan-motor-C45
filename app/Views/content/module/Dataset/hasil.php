<body>
    <h1 class="h3 mb-0 text-gray-800">Setting DataSet</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link active m-0 font-weight-bold text-primary"
                                onclick="showTab('training')">Table Data Training</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link  m-0 font-weight-bold text-primary"
                                onclick="showTab('testing')">Kelola Data Training</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <!-- TAB TESTING -->
                    <div id="tab-testing" class="tab-content" style="display: none;">
                        <!-- Tambahkan CSS & JS Select2 di head atau sebelum </body> -->
                        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

                        <form action="<?= base_url('diagnosa/proses') ?>" method="post">
                            <div class="mb-3">
                                <label for="kerusakan_select2" class="form-label fw-bold">
                                    Pilih Kerusakan yang Dialami
                                </label>

                                <?php if (!empty($kerusakan)): ?>
                                    <select class="form-select select2 form-control"
                                        id="kerusakan_select2"
                                        name="kerusakan[]"
                                        multiple="multiple"
                                        style="width: 100%;"
                                        required>
                                        <?php foreach ($kerusakan as $row): ?>
                                            <option value="<?= esc($row['kode_kerusakan']) ?>">
                                                <?= esc($row['kode_kerusakan']) ?> - <?= esc($row['nama_kerusakan']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        Tidak ada data kerusakan.
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="table-responsive" style="max-height: 200px;">
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

                            <button type="submit" class="btn btn-primary">Update Diagnosa</button>
                        </form>

                        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $('.select2').select2({
                                    theme: 'bootstrap-5',
                                    placeholder: "Ketik atau pilih kerusakan...",
                                    allowClear: true
                                });
                            });
                        </script>
                    </div>

                    <!-- TAB TRAINING -->
                    <?php
                    $total_gejala = isset($total_gejala) && is_numeric($total_gejala) ? (int)$total_gejala : 0;
                    ?>

                    <div id="tab-training" class="tab-content active">

                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>

                                        <?php if ($total_gejala > 0): ?>
                                            <?php for ($i = 1; $i <= $total_gejala; $i++): ?>
                                                <th>G<?= $i ?></th>
                                            <?php endfor; ?>
                                        <?php endif; ?>

                                        <th>Hasil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($training)): ?>
                                        <?php foreach ($training as $row): ?>
                                            <tr>
                                                <td><?= $row['id_training']; ?></td>

                                                <?php if ($total_gejala > 0): ?>
                                                    <?php for ($i = 1; $i <= $total_gejala; $i++): ?>
                                                        <td><?= isset($row['G' . $i]) ? $row['G' . $i] : '-'; ?></td>
                                                    <?php endfor; ?>
                                                <?php endif; ?>

                                                <td><?= $row['hasil']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('/dataSet/lihat/' . $row['id_training']) ?>"
                                                        class="btn btn-success btn-sm"> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="<?= $total_gejala + 3 ?>" class="text-center">
                                                Data tidak tersedia
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <?php
                    $training       = session()->getFlashdata('training') ?? [];
                    $kerusakan      = session()->getFlashdata('kerusakan') ?? [];
                    $gejalaAda = session()->getFlashdata('gejalaAda') ?? [];
                    ?>

                    <!-- ====== Tampilkan Data Kerusakan ====== -->
                    <?php if (!empty($kerusakan) && is_array($kerusakan)): ?>
                        <div class="card p-3 mb-3">
                            <h4>Hasil Kerusakan</h4>
                            <p><b>Kode:</b> <?= esc($kerusakan['kode_kerusakan'] ?? '-') ?></p>
                            <p><b>Nama Kerusakan:</b> <?= esc($kerusakan['nama_kerusakan'] ?? '-') ?></p>
                            <p><b>Solusi:</b> <?= esc($kerusakan['solusi'] ?? '-') ?></p>
                        </div>
                    <?php endif; ?>


                    <!-- ====== Tampilkan Daftar Gejala ====== -->
                    <?php if (!empty($gejalaAda) && is_array($gejalaAda)): ?>
                        <ul class="list-group">
                            <?php foreach ($gejalaAda as $g): ?>
                                <li class="list-group-item">
                                    <?php
                                    if (is_array($g)) {
                                        // Jika $g berupa array, tampilkan field yang umum
                                        echo esc($g['kode_gejala'] ?? ($g['kode'] ?? '-'))
                                            . ' — '
                                            . esc($g['nama_gejala'] ?? ($g['nama'] ?? '-'));
                                    } elseif (is_object($g)) {
                                        // Jika $g berupa object (entity), gunakan ->property
                                        echo esc($g->kode_gejala ?? ($g->kode ?? '-'))
                                            . ' — '
                                            . esc($g->nama_gejala ?? ($g->nama ?? '-'));
                                    } else {
                                        // Jika memang scalar (string/int), tampilkan langsung
                                        echo esc((string) $g);
                                    }
                                    ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Tidak ada gejala terpilih.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            // sembunyikan semua tab
            document.getElementById("tab-testing").style.display = "none";
            document.getElementById("tab-training").style.display = "none";

            // hapus active class dari semua nav-link
            let navLinks = document.querySelectorAll(".nav-link");
            navLinks.forEach(link => link.classList.remove("active"));

            // tampilkan tab yang dipilih
            document.getElementById("tab-" + tab).style.display = "block";

            // tambahkan active class ke tab yang diklik
            event.target.classList.add("active");
        }
    </script>


</body>