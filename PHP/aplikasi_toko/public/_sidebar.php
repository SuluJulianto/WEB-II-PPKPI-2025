<?php
// toko/public/_sidebar.php

$user_role = $_SESSION['auth_role'] ?? '';
$site_root = $_SESSION['site_root'] ?? '';

// Fungsi untuk menandai menu yang sedang aktif
function isActive($page_name) {
    if (basename($_SERVER['PHP_SELF']) == $page_name) {
        return 'active';
    }
    return '';
}
?>
<nav class="sidebar">
    <div class="sidebar-header">
        <h5><i class="fas fa-store"></i> Admin Panel</h5>
        <small><?= htmlspecialchars($user_role) ?></small>
    </div>
    <ul class="list-unstyled">
        <li><a href="<?= $site_root ?>/public/admin_dashboard.php" class="<?= isActive('admin_dashboard.php') ?>"><i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard</a></li>
        
        <?php if (in_array($user_role, ['Manager', 'Admin'])): ?>
            <li><a href="<?= $site_root ?>/public/pageSales.php" class="<?= isActive('pageSales.php') ?>"><i class="fas fa-chart-line fa-fw me-2"></i>Penjualan</a></li>
            <li><a href="<?= $site_root ?>/public/purchase.php" class="<?= isActive('purchase.php') ?>"><i class="fas fa-shopping-cart fa-fw me-2"></i>Pembelian</a></li>
            <li><a href="<?= $site_root ?>/public/pageCustomers.php" class="<?= isActive('pageCustomers.php') ?>"><i class="fas fa-address-book fa-fw me-2"></i>Customer</a></li>
        <?php endif; ?>

        <?php if ($user_role == 'Manager'): ?>
             <li><a href="<?= $site_root ?>/public/pageSuppliers.php" class="<?= isActive('pageSuppliers.php') ?>"><i class="fas fa-truck fa-fw me-2"></i>Supplier</a></li>
        <?php endif; ?>

        <?php if (in_array($user_role, ['Manager', 'Staf Gudang'])): ?>
            <li><a href="<?= $site_root ?>/public/pageInventory.php" class="<?= isActive('pageInventory.php') ?>"><i class="fas fa-box-open fa-fw me-2"></i>Inventori</a></li>
        <?php endif; ?>
        
        <?php if ($user_role == 'Manager'): ?>
            <li><a href="<?= $site_root ?>/public/pageUsers.php" class="<?= isActive('pageUsers.php') ?>"><i class="fas fa-users-cog fa-fw me-2"></i>Manajemen User</a></li>
        <?php endif; ?>

        <li><a href="<?= $site_root ?>/public/auth/logout.php"><i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout</a></li>
    </ul>
</nav>