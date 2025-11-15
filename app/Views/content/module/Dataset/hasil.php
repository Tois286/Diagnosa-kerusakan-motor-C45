<body>
    <h1 class="h3 mb-0 text-gray-800">Setting DataSet</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link active m-0 font-weight-bold text-primary"
                                onclick="showTab('testing')">Table Data Testing</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link m-0 font-weight-bold text-primary"
                                onclick="showTab('training')">Table Data Training</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <!-- TAB TESTING -->
                    <div id="tab-testing" class="tab-content active">
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <?php for ($i = 1; $i <= 20; $i++): ?>
                                            <th>G<?= $i ?></th>
                                        <?php endfor; ?>
                                        <th>Hasil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($testing)): ?>
                                        <?php foreach ($testing as $row): ?>
                                            <tr>
                                                <td><?= $row['id_training']; ?></td>
                                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                                    <td><?= $row['G' . $i]; ?></td>
                                                <?php endfor; ?>
                                                <td><?= $row['hasil']; ?></td>
                                                <td>
                                                    <a href="/admin/edit/<?= $row['id_training'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="/admin/view/<?= $row['id_training'] ?>" class="btn btn-success btn-sm">Lihat</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="22" class="text-center">Data tidak tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB TRAINING -->
                    <div id="tab-training" class="tab-content" style="display: none;">
                        <form style="padding-bottom:20px;" action="<?= base_url('kerusakan/save') ?>" method="post">
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="kode_kerusakan" class="form-control" placeholder="Kode Kerusakan"><br>
                                    <input type="text" name="nama_kerusakan" class="form-control" placeholder="Nama Kerusakan">
                                </div>
                                <div class="col">
                                    <input type="text" name="solusi" class="form-control" placeholder="Solusi"><br>
                                    <button class="form-control btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <?php for ($i = 1; $i <= 20; $i++): ?>
                                            <th>G<?= $i ?></th>
                                        <?php endfor; ?>
                                        <th>Hasil</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($training)): ?>
                                        <?php foreach ($training as $row): ?>
                                            <tr>
                                                <td><?= $row['id_training']; ?></td>
                                                <?php for ($i = 1; $i <= 20; $i++): ?>
                                                    <td><?= $row['G' . $i]; ?></td>
                                                <?php endfor; ?>
                                                <td><?= $row['hasil']; ?></td>
                                                <td>
                                                    <a href="/admin/edit/<?= $row['id_training'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="/admin/view/<?= $row['id_training'] ?>" class="btn btn-success btn-sm">Lihat</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="22" class="text-center">Data tidak tersedia</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

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