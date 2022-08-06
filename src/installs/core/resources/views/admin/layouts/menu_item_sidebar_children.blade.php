<ul class="nav nav-treeview">
    @foreach($menuChildren as $children)
    <li class="nav-item">
        <a href="{{ url(getPrefix() . '/' . $children->url) }}" class="nav-link">
            <i class="{{ $children->icon }} nav-icon"></i>
            <p>
                {{ $children->name }}
                @if(count($children->menuChildren))
                    <i class="uil uil-angle-left right"></i>
                @endif
            </p>
        </a>
        @if(count($children->menuChildren))
            @include('core::admin.layouts.menu_item_sidebar_children', [
                'menuChildren' => $children->menuChildren
            ])
        @endif
    </li>
    @endforeach
</ul>
