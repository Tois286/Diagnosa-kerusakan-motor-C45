 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
         <div class="sidebar-brand-icon">
             <img src="<?= base_url() ?>img/logoR.png" height="50px" alt="">
         </div>
         <div class="sidebar-brand-text mx-2">UCN Garage</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <li class="nav-item active">
         <a class="nav-link nav-btn" type="button" data-target="Dashboard">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span>
         </a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         setting C4.5
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
             aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-file"></i>
             <span>Dataset C4.5</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Custom Dataset:</h6>
                 <a class="collapse-item nav-btn" type="button" data-target="Gejala">Gejala</a>
                 <a class="collapse-item nav-btn" type="button" data-target="Kerusakan">Kerusakan</a>
                 <a class="collapse-item nav-btn" type="button" data-target="Hasil">Hasil DataSet</a>
                 <a class="collapse-item nav-btn" type="button" data-target="Penyebab">Penyebab</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Utilities Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
             aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-users"></i>
             <span>Users</span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Manage Users:</h6>
                 <a class="collapse-item nav-btn" type="button" data-target="Admin">Admin</a>
                 <a class="collapse-item nav-btn" type="button" data-target="Karyawan">Karyawan</a>
                 <a class="collapse-item nav-btn" type="button" data-target="Pelanggan">Pelanggan</a>
             </div>
         </div>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Testing C4.5
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
             aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-fw fa-folder"></i>
             <span>Check Troble</span>
         </a>
         <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Input Troble:</h6>
                 <a class="collapse-item nav-btn" type="button" data-target="SetGejala">Input Gejala</a>
                 <a class="collapse-item nav-btn" type="button" data-target="HasilDiagnosa">Hasil Kerusakan</a>
                 <div class="collapse-divider"></div>
                 <h6 class="collapse-header">Kinerja C4.5:</h6>
                 <a class="collapse-item nav-btn" type="button" data-target="DetailDiagnosa">Detail Analisis</a>
                 <a class="collapse-item" href="blank.html">Laporan</a>
             </div>
         </div>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

     <!-- Sidebar Message -->
     <div class="sidebar-card d-none d-lg-flex">
         <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
         <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
         <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
     </div>

 </ul>
 <!-- End of Sidebar -->