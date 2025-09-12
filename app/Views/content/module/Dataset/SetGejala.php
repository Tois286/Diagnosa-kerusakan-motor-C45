<body>
    <h1 class="h3 mb-0 text-gray-800">Diagnosa Gejala</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Checklist Gejala Jika Sesuai</h6>
                </div>

                <div class="card-body">
                    <!-- form diagnosa -->
                    <form action="<?= base_url('diagnosa/proses') ?>" method="post">
                        <div class="table-responsive" style="max-height: 200px;">
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

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Proses Diagnosa</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>