<body>
    <h1 class="h3 mb-0 text-gray-800">Detail Analisis</h1><br>

    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rule C4.5 </h6>
                </div>
                <div class="card-body">
                    <?php
                    $trace = session()->get('trace');
                    $tree = session()->get('tree');
                    $gejalaTerpilih = session()->get('gejalaTerpilih');
                    $hasil = session()->get('hasil');
                    ?>

                    <?php $evaluasi = session()->get('evaluasi'); ?>

                    <?php if ($evaluasi): ?>
                        <div class="alert alert-info">
                            <b>Akurasi Model:</b> <?= esc($evaluasi['accuracy']) ?>% <br>
                            Jumlah prediksi benar: <?= esc($evaluasi['correct']) ?> dari <?= esc($evaluasi['total']) ?> data
                        </div>
                    <?php endif; ?>

                    <?php if ($hasil): ?>

                        <!-- Tabel entropy & gain -->
                        <?php if (!empty($trace['gain'])): ?>
                            <h5>Perhitungan Entropy & Gain</h5>
                            <div class="table-responsive mb-4" style="max-height: 200px;">
                                <table class="table table-bordered">
                                    <thead>
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
                                                <td><?= round($g['gain'], 4) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <!-- Pohon Keputusan -->
                        <h5>Pohon Keputusan</h5>
                        <div class="card-body shadow">
                            <?php if (!empty($trace['tree'])): ?>

                                <pre>
     <?php foreach ($trace['tree'] as $step): ?>
     <?= $step . "\n" ?>
     <?php endforeach; ?>
             </pre>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>
                        <p>Belum ada data diagnosa.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>