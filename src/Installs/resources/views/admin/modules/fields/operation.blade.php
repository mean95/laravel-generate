<a href="{{ route(getPrefix() . '.module_fields.edit', $field->id) }}" class="btn btn-info btn-xs"
   title="{{ trans('core::admin.button.edit') }}" 
>
    <i class="uil uil-edit"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger btn-xs show-confirm-delete"
   data-route="{{ route(getPrefix() . '.module_fields.destroy', $field->id) }}"
   title="{{ trans('core::admin.button.remove') }}" 
>
    <i class="uil uil-trash"></i>
</a>
@if($field->column_name !== $module->view_col)
    <a href="{{ route(getPrefix() . '.modules.set_view_col', [$module->id, $field->column_name]) }}"
       title="{{ trans('core::module.button.set_view') }}" class="btn btn-success btn-xs"
    >
        <i class="uil uil-eye"></i>
    </a>
@endif
