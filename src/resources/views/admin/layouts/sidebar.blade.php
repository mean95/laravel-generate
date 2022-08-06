<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route(getPrefix() . '.home') }}" class="brand-link">
        <img src="{{ asset('platform/admin/img/logo.png') }}" alt=""
             class="brand-image ">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/platform/admin/img/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            @if(Auth::guard('admin')->check())
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::guard('admin')->user()->full_name }}</a>
                </div>
            @endif
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false"
            >
                @foreach(adminMenu()->getMenus() as $menu)
                    <li class="nav-item has-treeview">
                        <a href="{{ count($menu->menuChildren) ? 'javascript:void(0)' : url(getPrefix() . '/' . $menu->url) }}" class="nav-link">
                            <i class="nav-icon {{ $menu->icon }}"></i>
                            <p>
                                {{ $menu->name }}
                                @if(count($menu->menuChildren))
                                <i class="uil uil-angle-left right"></i>
                                @endif
                            </p>
                        </a>
                        @if(count($menu->menuChildren))
                            @include('core::admin.layouts.menu_item_sidebar_children', [
                                'menuChildren' => $menu->menuChildren
                            ])
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
