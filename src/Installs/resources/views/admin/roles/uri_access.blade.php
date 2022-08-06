@push('link')
    <link rel="stylesheet" href="{{ asset('platform/admin/css/role.css') }}">
@endpush
@push('script')
    <script src="{{ asset('platform/admin/js/role.js') }}"></script>
@endpush
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            {{ trans('core::role.allowed_access_permission') }}
        </h3>
        <label class="m-checkbox-label d-line mb-0 mr-0 float-right">
            <input type="checkbox" class="m-checkbox" id="all-checked-permission">
            <span class="m-checkmark"></span>
            <label for="all-checked-permission" class="m-label mb-0">{{ trans('core::role.all_permission') }}</label>
        </label>
    </div>
    <div class="card-body">
        @foreach($uriPermissions as $key => $permission)
        <div class="uri-block block-{{ strtolower($permission['method']) }}">
            <div class="uri-block-summary">
                <div class="uri-info">
                    <span class="method">{{ $permission['method'] }}</span>
                    <span class="uri">{{ url($permission['uri']) }}</span>
                </div>
                <div class="uri-checkbox">
                    <label class="m-checkbox-label d-line">
                        <input type="checkbox" class="m-checkbox"
                               id="m-checkbox-{{ $key }}" value="{{ $key }}" name="uri[]"
                               {{ in_array($key, $checkPermissions ?? []) ? 'checked' : '' }}
                        >
                        <span class="m-checkmark"></span>
                    </label>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
