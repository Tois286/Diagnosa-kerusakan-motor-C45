<body>
    <h1 class="h3 mb-0 text-gray-800">Setting Gejala</h1><br>
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
                    <form style="padding-bottom:20px;" action="<?= base_url('gejala/save') ?>" method="post">
                        <div class="row">
                            <div class="col">
                                <input type="text" name="kode_gejala" class="form-control" placeholder="Kode Gejala">
                            </div>
                            <div class="col">
                                <input type="text" name="nama_gejala" class="form-control" placeholder="Nama Gejala">
                            </div>
                            <div class="col">
                                <button class="form-control btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive" style="max-height: 300px;">
                        <table class="table">
                            <tr>
                                <th>No.</th>
                                <th>Kode Gejala</th>
                                <th>Nama Gejala</th>
                                <th>Action</th>
                            </tr>
                            <?php if (!empty($gejala)): ?>
                                <?php $no = 1;
                                foreach ($gejala as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($row['kode_gejala']) ?></td>
                                        <td><?= esc($row['nama_gejala']) ?></td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-warning btn-sm btn-edit-gejala"

                                                data-id="<?= $row['id_gejala'] ?>"
                                                data-kode="<?= $row['kode_gejala'] ?>"
                                                data-nama="<?= $row['nama_gejala'] ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditGejala">
                                                Edit
                                            </button>
                                            <a href="/gejala/delete/<?= $row['id_gejala'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
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
                    <!-- Modal Edit Gejala -->
                    <div class="modal fade" id="modalEditGejala" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Gejala</h5>
                                    <button type="button" class="btn btn-close btn-danger btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                                </div>

                                <div class="modal-body">
                                    <form id="formEditGejala" method="POST" action="<?= base_url('gejala/edit') ?>">

                                        <input type="hidden" name="id_gejala" id="id_gejala">

                                        <div class="mb-3">
                                            <label>Kode Gejala</label>
                                            <input type="text" class="form-control" name="kode_gejala" id="kode_gejala">
                                        </div>

                                        <div class="mb-3">
                                            <label>Nama Gejala</label>
                                            <input type="text" class="form-control" name="nama_gejala" id="nama_gejala">
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
    document.querySelectorAll('.btn-edit-gejala').forEach(btn => {
        btn.addEventListener('click', function() {

            // Ambil data dari tombol
            const id = this.dataset.id;
            const kode = this.dataset.kode;
            const nama = this.dataset.nama;

            // Isi ke form modal
            document.getElementById('id_gejala').value = id;
            document.getElementById('kode_gejala').value = kode;
            document.getElementById('nama_gejala').value = nama;
        });
    });
</script>