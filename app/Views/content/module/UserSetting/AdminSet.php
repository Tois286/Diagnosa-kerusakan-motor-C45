<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<body>
    <h1 class="h3 mb-0 text-gray-800">Data Admin</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link active m-0 font-weight-bold text-primary" id="tbadmin" onclick="showSectionAdmin('table')">Table Admin</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link m-0 font-weight-bold text-primary" id="tadmin" onclick="showSectionAdmin('form')">Tambah Admin</a>
                        </li>
                    </ul>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>

                <div class="card-body">
                    <!-- Form Admin -->
                    <div id="form-admin" style="display: none;">
                        <form style="padding-bottom: 20px;"
                            action="<?= base_url('AdminSet/save') ?>"
                            method="post"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter Email Address..." required>
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
                                        <option value="admin">Admin</option>
                                        <option value="karyawan">Karyawan</option>
                                        <option value="pelanggan">Pelanggan</option>
                                    </select>
                                    <br>
                                    <label for="foto">Upload Foto</label>
                                    <input type="file" class="form-control" name="foto">
                                    <br>
                                    <button type="submit" class="form-control btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- form modal edit data user -->
                    <div class="modal fade" id="modalEdit" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form method="POST" action="<?= base_url('AdminSet/edit') ?>" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User</h5>

                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="id_user" id="edit-id">

                                        <div class="mb-2">
                                            <label>Email</label>
                                            <input type="text" name="email" id="edit-email" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label for="passwoord">Password</label>
                                            <input type="password" name="password" id="" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Role</label>
                                            <input type="text" name="role" id="edit-role" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Nama</label>
                                            <input type="text" name="nama" id="edit-nama" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Tempat Tinggal</label>
                                            <input type="text" name="t_tinggal" id="edit-tinggal" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" id="edit-tgl" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label>Status</label>
                                            <input type="text" name="status_karyawan" id="edit-status" class="form-control">
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
                    <!-- Tabel Admin -->
                    <div id="table-admin">
                        <div class="table-responsive" style="max-height: 300px;">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Nama</th>
                                        <th>Tempat Tinggal</th>
                                        <th>Tgl Lahir</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($admin as $user): ?>
                                        <tr>
                                            <td><?= $user['id_user'] ?></td>
                                            <td><?= $user['email'] ?></td>
                                            <td><?= $user['role'] ?></td>
                                            <td><?= $user['nama_user'] ?></td>
                                            <td><?= $user['t_tinggal'] ?></td>
                                            <td><?= $user['tgl_lahir'] ?></td>
                                            <td><?= $user['status_pengguna'] ?></td>
                                            <td>
                                                <button
                                                    class="btn btn-warning btn-sm btn-edit"
                                                    data-id="<?= $user['id_user'] ?>"
                                                    data-email="<?= $user['email'] ?>"
                                                    data-role="<?= $user['role'] ?>"
                                                    data-nama="<?= $user['nama_user'] ?>"
                                                    data-tinggal="<?= $user['t_tinggal'] ?>"
                                                    data-tgl="<?= $user['tgl_lahir'] ?>"
                                                    data-status="<?= $user['status_pengguna'] ?>">
                                                    Edit
                                                </button>

                                                <a href="/AdminSet/delete/<?= $user['id_user'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin hapus?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {

                document.getElementById('edit-id').value = this.dataset.id;
                document.getElementById('edit-email').value = this.dataset.email;
                document.getElementById('edit-role').value = this.dataset.role;
                document.getElementById('edit-nama').value = this.dataset.nama;
                document.getElementById('edit-tinggal').value = this.dataset.tinggal;
                document.getElementById('edit-tgl').value = this.dataset.tgl;
                document.getElementById('edit-status').value = this.dataset.status;

                let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
                modal.show();
            });
        });
    </script>
    <!-- Script -->
    <script>
        function showSectionAdmin(section) {
            const formSection = document.getElementById('form-admin');
            const tableSection = document.getElementById('table-admin');
            const tbadmin = document.getElementById('tbadmin');
            const tadmin = document.getElementById('tadmin');

            if (section === 'form') {
                formSection.style.display = 'block';
                tableSection.style.display = 'none';

                tbadmin.classList.remove('active');
                tadmin.classList.add('active');
            } else {
                formSection.style.display = 'none';
                tableSection.style.display = 'block';

                tbadmin.classList.add('active');
                tadmin.classList.remove('active');
            }
        }

        // Default tampilkan tabel
        document.addEventListener("DOMContentLoaded", function() {
            showSectionAdmin('table');
        });
    </script>
</body>