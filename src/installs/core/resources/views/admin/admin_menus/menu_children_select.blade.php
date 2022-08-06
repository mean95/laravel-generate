<option value="{{ $menuChildren->id }}" 
    {{ (!empty($menu) && $menuChildren->id === $menu->admin_menu_id) ? 'selected="selected"' : '' }}
>
    {{  $slas . ' ' . $menuChildren->name }}
</option>
@if(count($menuChildren->menuChildren))
    @foreach($menuChildren->menuChildren as $menuChildren)
        @if($menu->id ?? '' === $menuChildren->id) 
            @continue
        @endif
        @include('core::admin.admin_menus.menu_children_select', [
            'menuChildren' => $menuChildren,
            'slas' => $slas . '—'
        ])
    @endforeach
@endif