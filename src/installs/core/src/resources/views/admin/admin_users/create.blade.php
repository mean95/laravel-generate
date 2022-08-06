@extends('core::admin.layouts.app')
@push('link')

@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::admin_user.user'),
        'route' => route(getPrefix() . '.admin_users.index'),
        'edit' => trans('core::admin.button.create')
    ])
@stop
@section('content')
    <section class="content">
        {{ Form::open(['action' => 'AdminUserController@store', 'route' => getPrefix() . '.admin_users.store', 'id' => 'validate_form_users']) }}
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @include('core::admin.admin_users.form')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-3">
                @include('core::admin.common.button_save')
            </div>
        </div>
        {{ Form::close() }}
    </section>
@stop
@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#validate_form_users').validate();
        });
    </script>
@endpush
