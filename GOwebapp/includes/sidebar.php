<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Safety<sup>FXU</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?php if ($page == 'dashboard') {echo 'active';};?>">
  <a class="nav-link" href="home.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<li class="nav-item <?php if ($page == 'profile') {echo 'active';};?>">
  <a class="nav-link" href="profile.php">
  <i class="fas fa-fw fa-id-card"></i>
    <span>Profile</span></a>
</li>

<li class="nav-item <?php if ($page == 'registersite') {echo 'active';};?>">
  <a class="nav-link" href="register-site.php">
  <i class="fas fa-fw fa-signature"></i>
    <span>Register Site</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="pdf.php">
  <i class="fas fa-fw fa-copy"></i>
    <span>Safety Documents</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->