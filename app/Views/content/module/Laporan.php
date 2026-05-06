<body>
    <h1 class="h3 mb-0 text-gray-800">Laporan</h1><br>

    <div class="row">
        <div class="col-lg mb-4">
            <div class="card shadow mb-4">

                <!-- HEADER -->
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Laporan Kerja Karyawan
                            </h6>
                        </div>

                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <button id="btnPrint" class="form-control btn btn-warning">
                                        Print
                                    </button>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="filter">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div id="table-pelanggan">
                    <div class="table-responsive" style="max-height: 300px;">
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>ID Story</th>
                                    <th>ID User</th>
                                    <th>ID Guest</th>
                                    <th>Nama Guest</th>
                                    <th>Gejala</th>
                                    <th>Hasil Kerusakan</th>
                                    <th>Solusi</th>
                                    <th>Nama Karyawan</th>
                                    <th>Tanggal Pekerjaan</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($history)): ?>
                                    <?php foreach ($history as $hst): ?>
                                        <tr>
                                            <td><?= $hst['id_story'] ?></td>
                                            <td><?= $hst['id_dataUser'] ?></td>
                                            <td><?= $hst['id_guest'] ?></td>
                                            <td><?= $hst['nama_guest'] ?></td>
                                            <td><?= $hst['gejala'] ?></td>
                                            <td><?= $hst['hasil_kerusakan'] ?></td>
                                            <td><?= $hst['solusi'] ?></td>
                                            <td><?= $hst['nama_karyawan'] ?></td>
                                            <td class="tanggal"><?= $hst['created_at'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Data tidak ada</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // ======================
        // PRINT (FIX)
        // ======================
        document.getElementById("btnPrint").addEventListener("click", function() {
            let rows = document.querySelectorAll("#myTable tbody tr");

            let tableHTML = `
        <table border="1" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID Story</th>
                    <th>ID User</th>
                    <th>ID Guest</th>
                    <th>Nama Guest</th>
                    <th>Gejala</th>
                    <th>Hasil Kerusakan</th>
                    <th>Solusi</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
    `;

            rows.forEach(row => {
                // HANYA ambil yang terlihat
                if (row.style.display !== "none") {
                    tableHTML += "<tr>" + row.innerHTML + "</tr>";
                }
            });

            tableHTML += "</tbody></table>";

            let printWindow = window.open('', '', 'width=900,height=700');

            printWindow.document.write(`
        <html>
        <head>
            <title>Print</title>
        </head>
        <body>
            <h3 style="text-align:center;">Laporan Kerja Karyawan</h3>
            ${tableHTML}
        </body>
        </html>
    `);

            printWindow.document.close();
            printWindow.focus();

            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        });
        // ======================
        // FILTER TANGGAL (FIX)
        // ======================
        document.getElementById("filter").addEventListener("change", function() {
            let selectedDate = this.value;
            let rows = document.querySelectorAll("#myTable tbody tr");

            rows.forEach(row => {
                let tanggalCell = row.querySelector(".tanggal");

                if (!tanggalCell) return;

                let rawDate = tanggalCell.textContent.trim();

                // ambil YYYY-MM-DD dari datetime
                let rowDate = rawDate.substring(0, 10);

                if (selectedDate === "" || rowDate === selectedDate) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>

</body>