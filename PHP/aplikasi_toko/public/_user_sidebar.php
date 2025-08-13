<?php
// toko/public/_user_sidebar.php

$site_root = $_SESSION['site_root'] ?? '';

function isUserPageActive($page_name) {
    if (basename($_SERVER['PHP_SELF']) == $page_name) {
        return 'active';
    }
    return '';
}
?>
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="<?= $site_root ?>/public/index.php" class="text-white text-decoration-none">
            <h5><i class="fas fa-user-circle"></i> Panel</h5>
        </a>
    </div>
    <ul class="list-unstyled">
        <li><a href="user_dashboard.php" class="<?= isUserPageActive('user_dashboard.php') ?>"><i class="fas fa-tachometer-alt fa-fw me-2"></i>Dashboard</a></li>
        <li><a href="profile.php" class="<?= isUserPageActive('profile.php') ?>"><i class="fas fa-user-edit fa-fw me-2"></i>Ubah Profil</a></li>
        <li><a href="auth/logout.php"><i class="fas fa-sign-out-alt fa-fw me-2"></i>Logout</a></li>
    </ul>
</nav>