<body>
    <h1 class="h3 mb-0 text-gray-800">Profile</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Gejala</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($sesUser as $user): ?>
                        <tr>
                            <td><?= $user['id_user'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['role'] ?></td>
                            <td><?= $user['nama_user'] ?></td>
                            <td><?= $user['t_tinggal'] ?></td>
                            <td><?= $user['tgl_lahir'] ?></td>
                            <td><?= $user['status_pengguna'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>