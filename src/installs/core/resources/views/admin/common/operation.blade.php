<a href="{{ route(getPrefix() . '.'. $module .'.edit', $item->id) }}"
   class="btn btn-info btn-xs" title="{{ trans('core::admin.button.edit') }}" 
>
    <i class="uil uil-edit"></i>
</a>
<a href="javascript:void(0)" data-route="{{ route(getPrefix() . '.'. $module .'.destroy', $item->id) }}"
   class="btn btn-danger btn-xs show-confirm-delete" title="{{ trans('core::admin.button.remove') }}" 
>
    <i class="uil uil-trash"></i>
</a>
