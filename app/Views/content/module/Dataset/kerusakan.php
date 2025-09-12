<body>
    <h1 class="h3 mb-0 text-gray-800">Setting Kerusakan</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Gejala</h6>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <div class="card-body">
                    <form style="padding-bottom:20px;" action="<?= base_url('kerusakan/save') ?>" method="post">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="kode_kerusakan" class="form-control" placeholder="Kode Gejala">
                            </div>
                            <div class="col">
                                <input type="text" name="nama_kerusakan" class="form-control" placeholder="Nama Gejala">
                            </div>
                            <div class="col">
                                <button class="form-control btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>No.</th>
                                <th>Kode Gejala</th>
                                <th>Nama Gejala</th>
                                <th>Solusi</th>
                                <th>Action</th>
                            </tr>
                            <?php if (!empty($kerusakan)): ?>
                                <?php $no = 1;
                                foreach ($kerusakan as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($row['kode_kerusakan']) ?></td>
                                        <td><?= esc($row['nama_kerusakan']) ?></td>
                                        <td><?= esc($row['solusi']) ?></td>
                                        <td>
                                            <a href="/admin/edit/<?= $row['id_kerusakan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="/admin/delete/<?= $row['id_kerusakan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
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
            </div>
        </div>
    </div>
</body>