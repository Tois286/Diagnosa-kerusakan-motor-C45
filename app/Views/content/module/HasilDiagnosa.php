<?php
$trace = session()->get('trace');
$tree = session()->get('tree');
$gejalaTerpilih = session()->get('gejalaTerpilih');
$hasil = session()->get('hasil');
?>

<body>
    <h1 class="h3 mb-0 text-gray-800">Hasil Kerusakan</h1><br>

    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hasil Analisis</h6>
                </div>
                <div class="card-body">
                    <?php if ($hasil): ?>

                        <h5>Gejala yang dipilih:</h5>
                        <ul>
                            <?php foreach ($gejalaTerpilih as $g): ?>
                                <li><?= esc($g) ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="alert alert-success">
                            Hasil Diagnosa: <b><?= esc($hasil['nama_kerusakan']) ?></b><br>
                            Solusi: <?= esc($hasil['solusi']) ?>
                        </div>


                    <?php else: ?>
                        <p>Belum ada data diagnosa.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>