 <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        {{-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Karhutla</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
          </li>
          @isset(Auth::user()->id)
            <li class="nav-item">
              <a href="#" class="nav-link" onclick="modal_form()">Submit Report</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('riwayat_lapor', ['id_user' => Auth::user()->id]) }}" class="nav-link">Riwayat Pelaporan</a>
            </li>
          @endisset

          @isset(Auth::user()->id)
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pengaturan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('riwayat_lapor', ['id_user' => Auth::user()->id]) }}" class="dropdown-item">Kelola Pelaporan </a></li>
              <li><a href="{{ route('master_user') }}" class="dropdown-item">Kelola Pengguna </a></li>
              <li><a href="{{ route('master_data') }}" class="dropdown-item">Kelola Master Data</a></li>

              {{-- <li class="dropdown-divider"></li> 
                <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>

                  
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>
                  

                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li> --}}
              
            </ul>
          </li>
           @endisset
        </ul>

        <!-- SEARCH FORM -->
        {{-- <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form> --}}
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Notifications Dropdown Menu -->
        @if(isset(Auth::user()->id))
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            {{ Auth::user()->name }} <i class="fas fa-user"></i>
            {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            {{-- <span class="dropdown-header">15 Notifications</span> --}}
            <div class="dropdown-divider"></div>
            {{-- <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a> --}}
            <div class="dropdown-divider"></div>
             <a href="{{ route('logout') }}" class="dropdown-item dropdown-footer">Logout</a>
          </div>
        </li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
          Masuk <i class="fas fa-edit"></i>
            {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
             <a href="{{ route('register') }}" class="dropdown-item dropdown-footer">Daftar</a>
             <a href="{{ route('login') }}" class="dropdown-item dropdown-footer">Masuk</a>
          </div>
        </li>
        @endif
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
              class="fas fa-th-large"></i></a>
        </li> --}}
      </ul>
    </div>
  </nav>