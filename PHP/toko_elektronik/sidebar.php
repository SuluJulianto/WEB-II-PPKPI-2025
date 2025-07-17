<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
        <div class="sidebar-brand-text mx-3">SB ADMIN</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>

    <div class="sidebar-heading">Manajemen Toko</div>
    <li class="nav-item <?php echo ($currentPage == 'index.php' || $currentPage == 'tambah.php' || $currentPage == 'edit.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php"><i class="fas fa-fw fa-box"></i><span>Produk</span></a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'tambah_penjualan.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="tambah_penjualan.php"><i class="fas fa-fw fa-dollar-sign"></i><span>Catat Penjualan</span></a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'laporan_penjualan.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="laporan_penjualan.php"><i class="fas fa-fw fa-table"></i><span>Laporan Penjualan</span></a>
    </li>
    <hr class="sidebar-divider">
    
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'superadmin'): ?>
    <div class="sidebar-heading">Administrasi</div>
    <li class="nav-item <?php echo ($currentPage == 'manajemen_admin.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="manajemen_admin.php"><i class="fas fa-fw fa-users-cog"></i><span>Manajemen Admin</span></a>
    </li>
    <hr class="sidebar-divider">
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')"><i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0" id="sidebarToggle"></button></div>
</ul>