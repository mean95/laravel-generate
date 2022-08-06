@extends('core::admin.layouts.app')
@push('link')
    <!-- Icon picker -->
    <link rel="stylesheet" href="{{ asset('platform/admin/plugins/iconscout-iconpicker/css/iconscout-iconpicker.min.css') }}">
@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::module.module'),
    ])
@stop
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add-module">
                        <i class="uil uil-plus"></i>
                        {{ trans('core::admin.button.create') }}
                    </a>
                </h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-hover table-bordered']) !!}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

    <!-- Modal create module -->
    <div class="modal fade" id="add-module">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('core::module.add_module') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route(getPrefix() . '.modules.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label>{{ trans('core::module.form.module_name.label') }}</label>
                                <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name') }}"
                                    placeholder="{{ trans('core::module.form.module_name.placeholder') }}"
                                />
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>
                                    {{ trans('core::module.form.icon.label') }}
                                </label>
                                <div class="iconpicker-container">
                                    <input type="text" name="icon" value="{{ old('icon', 'uil uil-500px') }}"
                                        autocomplete="off" class="form-control form-control-sm icon iconpicker-input"
                                        placeholder="{{ trans('core::module.form.icon.placeholder') }}"
                                    />
                                    @error('icon')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pull-right">
                        <button type="submit" class="btn btn-info btn-sm">
                            {{ trans('core::admin.button.create') }}
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            {{ trans('core::admin.button.cancel') }}
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal create module-->

    @include('core::admin.modules._particle.modal_delete')
@stop
@push('script')
    {!! $dataTable->scripts() !!}
    <script>
        var changeField = false;
    </script>
    <!-- Icon picker -->
    <script src="{{ asset('platform/admin/plugins/iconscout-iconpicker/js/iconscout-iconpicker.min.js') }}"></script>
    <script src="{{ asset('platform/admin/js/module.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.icon').iconpicker();
        });
    </script>
    @error('error_module')
        <script type="text/javascript">
            $('a[data-target="#add-module"]').trigger('click');
        </script>
    @enderror
@endpush
