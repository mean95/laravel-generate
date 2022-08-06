@extends('core::admin.layouts.app')
@push('link')

@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => 'Roles',
        'route' => route(getPrefix() . '.roles.index'),
        'edit' => trans('core::admin.button.create')
    ])
@stop
@section('content')
    <section class="content">
        {{
            Form::open([
                'action' => 'RoleController@store',
                'route' => getPrefix() . '.roles.store',
                'id' => 'validate_form_roles'
            ])
        }}
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        @include('core::admin.roles.form')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                @include('core::admin.roles.uri_access')
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
            $('#validate_form_roles').validate();
        });
    </script>
@endpush
