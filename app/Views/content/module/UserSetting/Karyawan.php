<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<body>
    <h1 class="h3 mb-0 text-gray-800">Data Karyawan</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#" class="nav-link active m-0 font-weight-bold text-primary" id="tbkaryawan" onclick="showKaryawanSection('table')">Table Karyawan</a>
                        </li>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link m-0 font-weight-bold text-primary" id="tamkaryawan" onclick="showKaryawanSection('form')">Tambah Karyawan</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <div class="card-body">
                    <!-- Form Karyawan -->
                    <div id="form-karyawan" style="display: none;">
                        <form style="padding-bottom: 20px;" action="<?= base_url('user/save') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email Address..." required>
                                    <br>
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" placeholder="Input Nama Lengkap" required>
                                    <br>
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                    <br>
                                    <label for="status_karyawan">Status Karyawan</label>
                                    <input type="text" name="status_karyawan" class="form-control" placeholder="Memegang Posisi Sebagai Apa?" required>
                                    <br>
                                </div>
                                <div class="col">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Input Password" required>
                                    <br>
                                    <label for="t_tinggal">Alamat Tinggal</label>
                                    <input type="text" name="t_tinggal" class="form-control" placeholder="Alamat Tinggal Sesuai KTP" required>
                                    <br>
                                    <label for="role">Berikan Akses</label>
                                    <select name="role" class="form-control">
                                        <option value="karyawan">Karyawan</option>
                                        <option value="pelanggan">Pelanggan</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                    <br>
                                    <label for="foto">Upload Foto</label>
                                    <input type="file" class="form-control" name="foto">
                                    <br>
                                    <label for="simpan">Pastikan semua data sudah benar!</label>
                                    <button class="form-control btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tabel Karyawan -->
                    <div id="table-karyawan">
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Nama</th>
                                    <th>Tempat Tinggal</th>
                                    <th>Tgl Lahir</th>
                                    <th>Status</th>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($karyawan as $user): ?>
                                    <tr>
                                        <td><?= $user['id_user'] ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td><?= $user['role'] ?></td>
                                        <td><?= $user['nama_user'] ?></td>
                                        <td><?= $user['t_tinggal'] ?></td>
                                        <td><?= $user['tgl_lahir'] ?></td>
                                        <td><?= $user['status_pengguna'] ?></td>
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                            <td>
                                                <a href="/admin/edit/<?= $user['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="/admin/delete/<?= $user['id_user'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
                                            </td>
                                        <?php endif; ?>
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
        function showKaryawanSection(section) {
            const formSection = document.getElementById('form-karyawan');
            const tableSection = document.getElementById('table-karyawan');
            const tbkaryawan = document.getElementById('tbkaryawan');
            const tamkaryawan = document.getElementById('tamkaryawan');

            if (section === 'form') {
                formSection.style.display = 'block';
                tableSection.style.display = 'none';
                tbkaryawan.classList.remove('active');
                tamkaryawan.classList.add('active');
            } else {
                formSection.style.display = 'none';
                tableSection.style.display = 'block';
                tbkaryawan.classList.add('active');
                tamkaryawan.classList.remove('active');
            }
        }

        // Show the table section by default
        showKaryawanSection('table');
    </script>
</body>