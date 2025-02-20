<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="../admin/dashboard.php" class="brand-link">
    <img src="../dist/img/bgcarmona.png" alt="Carmona Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">MTOPS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 mb-3 d-flex">
      <div class="image">
        <img src="../dist/img/bgcarmona.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <p class="d-block text-white"><?php echo $_SESSION['fullname']; ?></p>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <!--<div class="form-inline">-->
    <!--  <div class="input-group" data-widget="sidebar-search">-->
    <!--    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">-->
    <!--    <div class="input-group-append">-->
    <!--      <button class="btn btn-sidebar">-->
    <!--        <i class="fas fa-search fa-fw"></i>-->
    <!--      </button>-->
    <!--    </div>-->
    <!--  </div>-->
    <!--</div>-->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item" id="application-menu">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Application Menu
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="franchise-table.php" id="franchise-table" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tricycle Franchise</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="changemotor-table.php" id="changemotor-table" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Motor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="changeownership-table.php" id="changeownership-table" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Ownership</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="changedriver-table.php" id="changeownership-table" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Driver</p>
              </a>
            </li>
            <!-- <li class="nav-item">
                <a href="driverspermit-table.php" id="driverspermit-table" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Driver's Permit</p>
                </a>
              </li> -->
            <li class="nav-item">
              <a href="dropping-table.php" id="dropping-table" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dropping</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item" id="settings-menu">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="settings-operator.php" id="settings-operator-nav" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Operator/Driver</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="settings-motor.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Motors</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="settings-references.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>References</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="settings-toda.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TODA</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="settings-changestatus.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Status</p>
              </a>
            </li>
             <li class="nav-item">
              <a href="settings-changestatus.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Driver</p>
              </a>
            </li>
             

            <!-- <li class="nav-item">
              <a href="settings-franpertoda.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Franchise per TODA</p>
              </a>
            </li> -->
            <!--<li class="nav-item">-->
            <!--  <a id="open-signatories" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Signatories</p>-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li class="nav-item">-->
            <!--  <a id="open-fees" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Fees</p>-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li class="nav-item">-->
            <!--  <a href="settings-requirements.php" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Requirements</p>-->
            <!--  </a>-->
            <!--</li>-->
            <!--<li class="nav-item">-->
            <!--  <a id="open-fran-exp" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Franchise Expiry</p>-->
            <!--  </a>-->
            <!--</li>-->
            <li class="nav-item">
              <a href="user-management.php" id="open-user-management" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>User Management</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="report-masterlist-franchise.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New/Renew Application Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-changemotor.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Motor Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-changeownership.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Ownership Report</p>
              </a>
            </li>
            <!--<li class="nav-item">-->
            <!--  <a href="report-masterlist-tdp.php" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Masterlist TDP</p>-->
            <!--  </a>-->
            <!--</li>-->
            <li class="nav-item">
              <a href="report-masterlist-drop.php" id="open-signatories" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dropping Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-masterlist-toda.php" id="open-signatories" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>TODA Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-expired-franchise.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expired Franchise</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-expiring.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expiring Franchise</p>
              </a>
            </li>
            <!--<li class="nav-item">-->
            <!--  <a href="report-expired-tdp.php" class="nav-link">-->
            <!--    <i class="far fa-circle nav-icon"></i>-->
            <!--    <p>Expired TDP</p>-->
            <!--  </a>-->
            <!--</li>-->
            <li class="nav-item">
              <a href="report-collection.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Collection Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report-abstract.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Abstract Collection</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="report-ownership-residency.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ownership Residency</p>
              </a>
            </li> -->
            <li class="nav-item">
              <a href="activity-logs.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Activity Logs</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>