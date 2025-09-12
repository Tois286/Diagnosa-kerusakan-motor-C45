<body>
    <h1 class="h3 mb-0 text-gray-800">Profile</h1><br>
    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
                </div>
                <?php
                $session = session();
                ?>

                <h1>Profile User</h1>

                <?php if (isset($session->logged_in) && $session->logged_in === true): ?>
                    <p>Email: <?= esc($session->email) ?></p>
                    <p>Role: <?= esc($session->role) ?></p>
                <?php else: ?>
                    <p>User belum login.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>