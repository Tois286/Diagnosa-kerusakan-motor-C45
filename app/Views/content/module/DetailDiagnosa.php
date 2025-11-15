<body>
    <h1 class="h3 mb-0 text-gray-800">Detail Analisis</h1><br>

    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rule C4.5</h6>
                </div>
                <div class="card-body">
                    <?php
                    $trace = session()->get('trace');
                    $tree = session()->get('tree');
                    $gejalaTerpilih = session()->get('gejalaTerpilih');
                    $hasil = session()->get('hasil');
                    $evaluasi = session()->get('evaluasi');
                    ?>

                    <!-- Akurasi -->
                    <?php if ($evaluasi): ?>
                        <div class="alert alert-info">
                            <b>Akurasi Model:</b> <?= esc($evaluasi['accuracy']) ?>% <br>
                            <small>Benar: <?= esc($evaluasi['correct']) ?> dari <?= esc($evaluasi['total']) ?> data</small>
                        </div>
                    <?php endif; ?>

                    <!-- Hasil diagnosa -->
                    <div class="mb-4">
                        <h4 class="text-primary">Hasil Diagnosa</h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item active">Gejala Terpilih:</li>
                            <?php if (!empty($gejalaTerpilih)): ?>
                                <?php foreach ($gejalaTerpilih as $g): ?>
                                    <li class="list-group-item"><?= esc($g) ?></li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-muted">Data belum terpilih</li>
                            <?php endif; ?>
                        </ul>
                        <p>
                            <b class="text-success">Kerusakan:</b>
                            <?= esc($hasil['nama_kerusakan'] ?? 'Tidak diketahui') ?>
                        </p>
                    </div>

                    <!-- Tabel entropy & gain -->
                    <?php if (!empty($trace['gain'])): ?>
                        <h4 class="text-primary">Perhitungan Entropy & Gain</h4>
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Atribut</th>
                                        <th>Entropy Sebelum</th>
                                        <th>Entropy Sesudah</th>
                                        <th>Gain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trace['gain'] as $g): ?>
                                        <tr>
                                            <td><?= esc($g['attribute']) ?></td>
                                            <td><?= round($g['entropy_before'], 4) ?></td>
                                            <td><?= round($g['entropy_after'], 4) ?></td>
                                            <td class="text-primary"><b><?= round($g['gain'], 4) ?></b></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <!-- Pohon Keputusan -->
                    <h4 class="text-primary">Pohon Keputusan</h4>
                    <div class="p-3 bg-light border rounded mb-4" style="max-height: 300px; overflow-y: auto;">
                        <?php if (!empty($trace['tree'])): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($trace['tree'] as $step): ?>
                                    <li><code><?= esc($step) ?></code></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Pohon keputusan belum terbentuk.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Evaluasi detail -->
                    <?php if ($evaluasi): ?>
                        <h4 class="text-primary">Evaluasi Detail</h4>
                        <div class="p-3 bg-light border rounded">
                            <pre><?= print_r($evaluasi, true) ?></pre>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</body>