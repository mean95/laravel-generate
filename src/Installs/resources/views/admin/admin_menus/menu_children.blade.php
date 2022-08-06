<li class="dd-item" data-id="{{ $menuChildren->id }}">
    <div class="dd-handle">
        <span class="item">
            <i class="uil {{ $menuChildren->icon }}"></i>
            {{ $menuChildren->name }}
        </span>
        <span class="pull-right dd-nodrag">
            @if($menuChildren->type === config('const.menu_type.custom'))
                <a href="{{ route(getPrefix() . '.admin_menus.edit', $menuChildren->id) }}" 
                    title="{{ trans('core::admin.button.edit') }}" data-toggle="tooltip"
                    class="edit-menu btn btn-info btn-xs" data-id="{{ $menuChildren->id }}"
                >
                    <i class="uil uil-edit"></i>
                </a>
            @endif
            <a href="javascript:void(0);" data-toggle="tooltip" title="{{ trans('core::admin.button.remove') }}"
               data-route="{{ route(getPrefix() . '.admin_menus.destroy', $menu->id) }}"
               class="show-confirm-delete btn btn-danger btn-xs">
                <i class="uil uil-trash"></i>
            </a>
        </span>
    </div>
    @if(count($menuChildren->menuChildren))
        <ol>
            @foreach ($menuChildren->menuChildren as $menuChildren)
                @include('core::admin.admin_menus.menu_children', [
                    'menuChildren' => $menuChildren
                ])
            @endforeach
        </ol>
    @endif
</li>