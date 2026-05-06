<body>

    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <td>Foto</td>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Nama</th>
                                <th>Tempat Tinggal</th>
                                <th>Tgl Lahir</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sesUser as $user): ?>
                                <tr>
                                    <td>
                                        <img src="<?= base_url('uploads/' . $user['foto']) ?>" width="80">
                                    </td>
                                    <td><?= $user['id_user'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['role'] ?></td>
                                    <td><?= $user['nama_user'] ?></td>
                                    <td><?= $user['t_tinggal'] ?></td>
                                    <td><?= $user['tgl_lahir'] ?></td>
                                    <td><?= $user['status_pengguna'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>