<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<body>
    <h1 class="h3 mb-0 text-gray-800">Data Pelanggan</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active m-0 font-weight-bold text-primary" id="tbpelanggan" onclick="showSection('table')">Table Pelanggan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link m-0 font-weight-bold text-primary" id="tpelanggan" onclick="showSection('form')">Tambah Pelanggan</a>
                        </li>
                    </ul>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <div class="card-body">
                    <!-- Form Pelanggan -->
                    <div id="form-pelanggan" style="display: none;">
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
                        </form>
                    </div>
                    <!-- Tabel Pelanggan -->
                    <div id="table-pelanggan">
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Nama</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Merek Kendaraan</th>
                                    <th>Gejala / Keluhan</th>
                                    <th>Kerusakan & Solusi</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach ($guest as $user): ?>
                                    <tr>
                                        <td><?= $user['id_guest'] ?></td>
                                        <td><?= $user['email_guest'] ?></td>
                                        <td><?= $user['nama_guest'] ?></td>
                                        <td><?= $user['jenis_motor'] ?></td>
                                        <td><?= $user['merek_motor'] ?></td>
                                        <td><?= $user['gejala'] ?></td>
                                        <td><?= $user['kerusakan'] ?></td>
                                        <td>
                                            <a href="/admin/edit/<?= $user['id_guest'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="/admin/delete/<?= $user['id_guest'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            const formSection = document.getElementById('form-pelanggan');
            const tableSection = document.getElementById('table-pelanggan');
            const tbpelanggan = document.getElementById('tbpelanggan');
            const tpelanggan = document.getElementById('tpelanggan');

            if (section === 'form') {
                formSection.style.display = 'block';
                tableSection.style.display = 'none';
                tbpelanggan.classList.remove('active');
                tpelanggan.classList.add('active');
            } else {
                formSection.style.display = 'none';
                tableSection.style.display = 'block';
                tbpelanggan.classList.add('active');
                tpelanggan.classList.remove('active');
            }
        }

        // Default tampilkan tabel
        showSection('table');
    </script>
</body>