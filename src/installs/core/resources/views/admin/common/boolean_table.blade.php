@if((int) $status === 1)
   <span class="badge badge-info">{{ trans('core::admin.badge.true') }}</span>
@else
    <span class="badge badge-danger">{{ trans('core::admin.badge.false') }}</span>
@endif
