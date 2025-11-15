<?= $this->include('content/layout/header') ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?= $this->include('content/layout/sidebar') ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <?= $this->include('content/layout/topbar') ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div id="Dashboard">
                        <?= $this->include('content/layout/row') ?>
                    </div>

                    <div id="Profile" hidden>
                        <?= $this->include('content/Profile') ?>
                    </div>

                    <div id="Gejala" hidden>
                        <?= $this->include('content/module/Dataset/gejala') ?>
                    </div>

                    <div id="Kerusakan" hidden>
                        <?= $this->include('content/module/Dataset/kerusakan') ?>
                    </div>

                    <div id="Hasil" hidden>
                        <?= $this->include('content/module/Dataset/hasil') ?>
                    </div>

                    <div id="Admin" hidden>
                        <?= $this->include('content/module/UserSetting/AdminSet') ?>
                    </div>
                    <div id="Karyawan" hidden>
                        <?= $this->include('content/module/UserSetting/Karyawan') ?>
                    </div>
                    <div id="Pelanggan" hidden>
                        <?= $this->include('content/module/UserSetting/Pelanggan') ?>
                    </div>

                    <div id="SetGejala" hidden>
                        <?= $this->include('content/module/Dataset/SetGejala') ?>
                    </div>
                    <div id="HasilDiagnosa" hidden>
                        <?= $this->include('content/module/HasilDiagnosa') ?>
                    </div>
                    <div id="DetailDiagnosa" hidden>
                        <?= $this->include('content/module/DetailDiagnosa') ?>
                    </div>


                    <!-- Content Row -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('/auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url() ?>vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url() ?>js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url() ?>js/demo/chart-pie-demo.js"></script>
    <script>
        document.querySelectorAll(".nav-btn").forEach(item => {
            item.addEventListener("click", () => {
                // sembunyikan semua section
                document.querySelectorAll(".container-fluid > div").forEach(sec => sec.hidden = true);

                // tampilkan sesuai data-target
                let target = item.getAttribute("data-target");
                document.getElementById(target).hidden = false;

                // highlight aktif
                document.querySelectorAll(".nav-btn").forEach(btn => btn.classList.remove("active"));
                item.classList.add("active");
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            if (tab) {
                // sembunyikan semua section
                document.querySelectorAll(".container-fluid > div").forEach(sec => sec.hidden = true);

                // tampilkan section sesuai tab
                let target = document.getElementById(tab);
                if (target) {
                    target.hidden = false;
                }

                // kalau mau highlight menu aktif
                document.querySelectorAll(".nav-btn").forEach(btn => {
                    btn.classList.remove("active");
                    if (btn.getAttribute("data-target") === tab) {
                        btn.classList.add("active");
                    }
                });
            }
        });
    </script>



</body>

</html>