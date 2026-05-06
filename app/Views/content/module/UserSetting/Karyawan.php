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
                        <form style="padding-bottom: 20px;"
                            action="<?= base_url('AdminSet/save') ?>"
                            method="post"
                            enctype="multipart/form-data">
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
                    <div class="modal fade" id="modalEditKaryawan" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form method="POST" action="<?= base_url('AdminSet/edit') ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>

                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="id_user" id="edit-idKaryawan">

                                        <div class="mb-2">
                                            <label>Email</label>
                                            <input type="text" name="email" id="edit-emailKaryawan" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Input Password">
                                        </div>
                                        <div class="mb-2">
                                            <label>Role</label>
                                            <input type="text" name="role" id="edit-roleKaryawan" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Nama</label>
                                            <input type="text" name="nama" id="edit-namaKaryawan" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Tempat Tinggal</label>
                                            <input type="text" name="t_tinggal" id="edit-tinggalKaryawan" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" id="edit-tglKaryawan" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Status</label>
                                            <input type="text" name="status_karyawan" id="edit-statusKaryawan" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label for="foto">Upload Foto</label>
                                            <input type="file" class="form-control" name="foto">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
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
                                                <button
                                                    class="btn btn-warning btn-sm btn-editKaryawan"
                                                    data-idkaryawan="<?= $user['id_user'] ?>"
                                                    data-emailkaryawan="<?= $user['email'] ?>"
                                                    data-rolekaryawan="<?= $user['role'] ?>"
                                                    data-namaKaryawan="<?= $user['nama_user'] ?>"
                                                    data-tinggalkaryawan="<?= $user['t_tinggal'] ?>"
                                                    data-tglkaryawan="<?= $user['tgl_lahir'] ?>"
                                                    data-statuskaryawan="<?= $user['status_pengguna'] ?>">
                                                    Edit
                                                </button>

                                                <a href="/AdminSet/delete/<?= $user['id_user'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin hapus?')">Delete</a>
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
        document.querySelectorAll('.btn-editKaryawan').forEach(button => {
            button.addEventListener('click', function() {

                document.getElementById('edit-idKaryawan').value = this.dataset.idkaryawan;
                document.getElementById('edit-emailKaryawan').value = this.dataset.emailkaryawan;
                document.getElementById('edit-roleKaryawan').value = this.dataset.rolekaryawan;
                document.getElementById('edit-namaKaryawan').value = this.dataset.namaKaryawan;
                document.getElementById('edit-tinggalKaryawan').value = this.dataset.tinggalkaryawan;
                document.getElementById('edit-tglKaryawan').value = this.dataset.tglkaryawan;
                document.getElementById('edit-statusKaryawan').value = this.dataset.statuskaryawan;

                let modal = new bootstrap.Modal(document.getElementById('modalEditKaryawan'));
                modal.show();
            });
        });
    </script>
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