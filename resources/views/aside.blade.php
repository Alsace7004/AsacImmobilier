<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AsacImmobilier</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/" class="d-block">Damilola Ola</a>
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
          <li class="nav-item menu-open">
            <router-link to="/dashboard" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
          </li>
          <li class="nav-header">PERSONNELS</li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </router-link>
          </li>
          <li class="nav-header">ADMINISTRATION</li>
          <li class="nav-item">
            <router-link to="/immeubles" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Immeubles
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/appartements" class="nav-link">
              <i class="nav-icon fas fa-house-user"></i>
              <p>
                Appartements
                <span class="badge badge-info right">6</span>
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/clients" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clients
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/visites" class="nav-link">
              <i class="nav-icon fas fa-search-location"></i>
              <p>
                Visites
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/promesseVentes" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Promesse de ventes
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link  to="/avocats" class="nav-link">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Avocats
              </p>
            </router-link >
          </li>

          <li class="nav-header">MODULES</li>
          <li class="nav-item">
            <router-link  to="/signatures" class="nav-link">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>
                Signatures
                <span class="badge badge-info right">2</span>
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/desistements" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Desistements
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/payements" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Payements
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/contratVenteDefinitifs" class="nav-link">
              <i class="nav-icon far fa-sticky-note"></i>
              <p>
                Contrat de vente definitif
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/procesVerbals" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Proces Verbal
              </p>
            </router-link>
          </li>

          <li class="nav-header">OPTION</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon text-danger fas fa-power-off"></i>
              <p class="text">Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>