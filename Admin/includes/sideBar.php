<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">LOGELITE NEWS</span><br>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['name']; ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php if ($_SESSION['role'] == 'admin') {

          ?>
          <li class="nav-item menu-open">
            <a href="" class="nav-link active">
              <i class="fas fa-solid fa-layer-group nav-icon"></i>
              <p>
                CATEGORIES
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Admin/categoriesTable.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Category</p>
                </a>
              </li>
            </ul>

          </li>
        <?php } ?>
        <li class="nav-item menu-open">
          <a href="" class="nav-link active">
            <i class="fas fa-solid fa-layer-group nav-icon"></i>
            <p>
              NEWS
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../Admin/addNewsBlog.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Posts</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../Admin/manageNewsBlog.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Posts</p>
              </a>
            </li>
          </ul>
          <?php if ($_SESSION['role'] == 'admin') {

            ?>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Admin/manageNewsTags.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Tags</p>
                </a>
              </li>
            </ul>
          <?php } ?>
        </li>
        <?php if ($_SESSION['role'] == 'admin') {

          ?>
          <li class="nav-item menu-open">
            <a href="" class="nav-link active">
              <i class=""></i>
              <i class="nav-icon fas fa-solid fa-link"></i>
              <p>
                PAGES
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Admin/userListTable.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Users</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../Admin/profile.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin Profile</p>
                </a>
              </li>
            </ul>
        </ul>
      <?php } ?>
      </li>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>