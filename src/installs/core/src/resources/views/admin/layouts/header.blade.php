<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link icon-user" data-toggle="dropdown" href="#">
          <img src="{{ asset('platform/admin/img/avatar5.png') }}" alt="user">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ trans('core::admin.label.systems') }}</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.configs.index') }}" class="dropdown-item">
            <i class="uil uil-sliders-v-alt mr-2"></i>{{ trans('core::admin.label.configs') }}
          </a>
          <a href="{{ route('admin.modules.index') }}" class="dropdown-item">
            <i class="uil uil-cube mr-2"></i>{{ trans('core::admin.label.modules') }}
          </a>
          <a href="{{ route('admin.admin_menus.index') }}" class="dropdown-item">
            <i class="uil uil-list-ul mr-2"></i>{{ trans('core::admin.label.menus') }}
          </a>
          <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item dropdown-footer"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
            >
              <i class="uil uil-sign-out-alt"></i>
              {{ trans('core::admin.label.logout') }}
            </a>
            <form class="d-none" id="logout-form" action="{{ route('admin.logout') }}" method="POST">
              @csrf
            </form>
        </div>
      </li>
    </ul>
  </nav>
