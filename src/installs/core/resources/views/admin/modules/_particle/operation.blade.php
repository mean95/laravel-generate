<a href="{{ route(getPrefix() . '.modules.show', $module->id) }}"
   class="btn btn-info btn-xs"
   title="{{ trans('core::admin.button.edit') }}"
>
    <i class="uil uil-edit"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger btn-xs show_delete_module"
   title="{{ trans('core::admin.button.remove') }}"
   data-db-name="{{ $module->name }}" data-model-name="{{ $module->model }}"
   data-route="{{ route('admin.modules.destroy', $module->id) }}"
>
    <i class="uil uil-trash"></i>
</a>
