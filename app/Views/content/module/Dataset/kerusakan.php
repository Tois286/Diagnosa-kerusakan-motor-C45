<body>
    <h1 class="h3 mb-0 text-gray-800">Setting Kerusakan</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Kerusakan</h6>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <div class="card-body">
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
                            <tr>
                                <th>No.</th>
                                <th>Kode Kerusakan</th>
                                <th>Nama Kerusakan</th>
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
                                        <td class="d-flex gap-4">
                                            <button type="button"
                                                class="btn btn-warning btn-sm btn-edit-kerusakan"
                                                style="margin-right: 5px;"
                                                data-id="<?= $row['id_kerusakan'] ?>"
                                                data-kode="<?= $row['kode_kerusakan'] ?>"
                                                data-nama="<?= $row['nama_kerusakan'] ?>"
                                                data-solusi="<?= $row['solusi'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditkerusakan">
                                                Edit
                                            </button>
                                            <a href="/kerusakan/delete/<?= $row['id_kerusakan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
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
                    <div class="modal fade" id="modalEditkerusakan" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit kerusakan</h5>
                                    <button type="button" class="btn btn-close btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                                </div>

                                <div class="modal-body">
                                    <form id="formEditkerusakan" method="POST" action="<?= base_url('kerusakan/edit') ?>">

                                        <input type="hidden" name="id_kerusakan" id="id_kerusakan">

                                        <div class="mb-3">
                                            <label>Kode kerusakan</label>
                                            <input type="text" class="form-control" name="kode_kerusakan" id="kode_kerusakan">
                                        </div>

                                        <div class="mb-3">
                                            <label>Nama kerusakan</label>
                                            <input type="text" class="form-control" name="nama_kerusakan" id="nama_kerusakan">
                                        </div>

                                        <div class="mb-3">
                                            <label>Solusi</label>
                                            <input type="text" class="form-control" name="solusi" id="solusi">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<script>
    document.querySelectorAll('.btn-edit-kerusakan').forEach(btn => {
        btn.addEventListener('click', function() {

            // Ambil data dari tombol
            const id = this.dataset.id;
            const kode = this.dataset.kode;
            const nama = this.dataset.nama;
            const solusi = this.dataset.solusi;

            // Isi ke form modal
            document.getElementById('id_kerusakan').value = id;
            document.getElementById('kode_kerusakan').value = kode;
            document.getElementById('nama_kerusakan').value = nama;
            document.getElementById('solusi').value = solusi;
        });
    });
</script>