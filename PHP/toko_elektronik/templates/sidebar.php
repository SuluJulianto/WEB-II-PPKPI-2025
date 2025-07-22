<?php
// /templates/sidebar.php

// Dapatkan nama file saat ini untuk menandai menu aktif
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
        <div class="sidebar-brand-text mx-3">ADMIN PANEL</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>

    <div class="sidebar-heading">Manajemen Toko</div>
    <li class="nav-item <?php echo in_array($currentPage, ['produk_manajemen.php', 'produk_tambah.php', 'produk_edit.php']) ? 'active' : ''; ?>">
        <a class="nav-link" href="produk_manajemen.php"><i class="fas fa-fw fa-box"></i><span>Manajemen Produk</span></a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'penjualan_catat.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="penjualan_catat.php"><i class="fas fa-fw fa-dollar-sign"></i><span>Catat Penjualan</span></a>
    </li>
    <li class="nav-item <?php echo ($currentPage == 'penjualan_laporan.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="penjualan_laporan.php"><i class="fas fa-fw fa-table"></i><span>Laporan Penjualan</span></a>
    </li>
    <hr class="sidebar-divider">
    
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'superadmin'): ?>
    <div class="sidebar-heading">Administrasi</div>
    <li class="nav-item <?php echo ($currentPage == 'admin_manajemen.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="admin_manajemen.php"><i class="fas fa-fw fa-users-cog"></i><span>Manajemen Admin</span></a>
    </li>
    <hr class="sidebar-divider">
    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link" href="../core/proses_logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')"><i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span></a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline"><button class="rounded-circle border-0" id="sidebarToggle"></button></div>
</ul>