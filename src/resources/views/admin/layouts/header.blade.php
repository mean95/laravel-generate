<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/platform/admin/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/platform/admin/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/platform/admin/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link icon-user" data-toggle="dropdown" href="#">
          <img src="{{ asset('platform/admin/img/avatar5.png') }}" alt="user">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Acount</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="uil uil-envelope mr-2"></i>Messages
            <span class="float-right badge badge-danger">3</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="uil uil-comment mr-2"></i>Comment
            <span class="float-right badge badge-danger">2</span>
          </a>
          <div class="dropdown-divider"></div>
          <span class="dropdown-item dropdown-header">System</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="uil uil-sliders-v-alt mr-2"></i>Configs
          </a>
          <a href="#" class="dropdown-item">
            <i class="uil uil-setting mr-2"></i>Setting
          </a>
          <a href="{{ route('admin.modules.index') }}" class="dropdown-item">
            <i class="uil uil-cube mr-2"></i>Modules
          </a>
          <a href="{{ route('admin.admin_menus.index') }}" class="dropdown-item">
            <i class="uil uil-list-ul mr-2"></i>Menus
          </a>
          <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item dropdown-footer"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
            >
              <i class="uil uil-sign-out-alt"></i>
              Logout
            </a>
            <form class="d-none" id="logout-form" action="{{ route('admin.logout') }}" method="POST">
              @csrf
            </form>
        </div>
      </li>
    </ul>
  </nav>
