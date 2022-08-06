@extends('core::admin.layouts.app')
@push('link')
    <link rel="stylesheet" href="{{ asset('platform/admin/css/module.css') }}">
@endpush
@section('content')
    <section class="content p-0">
        <div class="card">
            <div class="card-header p-0">
                <div class="{{ $module->is_gen ? 'bg-info' : 'bg-danger' }} m-module-info row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="m-profile-icon text-primary">
                                    <i class="{{ $module->icon }}"></i>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <a class="text-white"
                                   @if($module->is_gen)
                                        href="{{ route(getPrefix() . '.' . $module->name_db . '.index') }}"
                                   @else
                                       href="javascript:void(0)"
                                   @endif
                                >
                                    <h5>{{ $module->label }}</h5>
                                </a>
                                <div class="row m-stats">
                                    <div class="col-md-12">{{ $countItemModule }} Items</div>
                                </div>
                                <p class="desc"></p>
                                <div class="m-generate">
                                    <a class="btn btn-outline-info btn-sm">
                                        @if($module->is_gen)
                                            {{ trans('core::module.generated') }}
                                        @else
                                            {{ trans('core::module.no_generate') }}
                                        @endif
                                    </a>
                                </div>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="m-show-field">
                            <i class="uil uil-anchor"></i>
                            {{ $module->controller }}
                        </div>
                        <div class="m-show-field">
                            <i class="uil uil-database"></i>
                            {{ $module->model }}
                        </div>
                        <div class="m-show-field">
                            <i class="uil uil-eye"></i>
                            @if(!empty($module->view_col))
                                {{$module->view_col}}
                            @else
                                {{ trans('core::module.no_set') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        @if(!empty($module->view_col))
                            @if(!empty($module->is_gen))
                                <div class="text-center mb-2 m-generate">
                                    <form action="{{ route(getPrefix() . '.modules.module_generate_crud_update', $module->id) }}"
                                          method="POST"
                                    >
                                        @csrf
                                        <button type="submit" data-toggle="tooltip" title="{{ trans('core::module.update_module') }}"
                                                class="btn btn-sm btn-outline-info"
                                        >
                                            <i class="uil uil-refresh"></i>
                                            {{ trans('core::module.update_module') }}
                                        </button>
                                    </form>
                                </div>
                                <div class="text-center m-generate">
                                    <form action="{{ route(getPrefix() . '.modules.module_generate_migrate_update', $module->id) }}"
                                          method="POST"
                                    >
                                        @csrf
                                        <button type="submit" data-toggle="tooltip" title="{{ trans('core::module.update_migration_title') }}"
                                                class="btn btn-sm btn-outline-info"
                                        >
                                            <i class="uil uil-database"></i>
                                            {{ trans('core::module.update_migration') }}
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center mb-2">
                                    <form action="{{ route(getPrefix() . '.modules.module_generate_migrate_crud', $module->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        <button type="submit" data-toggle="tooltip" title="{{ trans('core::module.generate_crud_title') }}"
                                            class="btn btn-sm btn-info"
                                        >
                                            <i class="uil uil-cube"></i>
                                            {{ trans('core::module.generate_crud') }}
                                        </button>
                                    </form>
                                </div>

                                <div class="text-center">
                                    <form action="{{ route(getPrefix() . '.modules.module_generate_migrate', $module->id) }}"
                                          method="POST"
                                    >
                                        @csrf
                                        <button type="submit" data-toggle="tooltip" title="{{ trans('core::module.generate_migrate_file') }}"
                                                class="btn btn-sm btn-info"
                                        >
                                            <i class="fa fa-database"></i>
                                            {{ trans('core::module.generate_migrate') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="m-show-field text-center">
                                {!! trans('core::module.note_module') !!}
                            </div>
                        @endif
                    </div>

                    <div class="col-md-1 m-actions">
                        <button class="btn btn-default m-btn-delete btn-xs m-delete-module show_delete_module"
                            data-db-name="{{ $module->name }}" data-model-name="{{ $module->model }}"
                            data-route="{{ route('admin.modules.destroy', $module->id) }}"
                        >
                            <i class="uil uil-times"></i>
                        </button>
                    </div>
                </div>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <ul class="nav nav-tabs m-tab-module mb-3" id="custom-content-below-tab" role="tablist">
                    <li class="m-module-back">
                        <a href="{{ route(getPrefix() . '.modules.index') }}" data-toggle="tooltip"
                            title="{{ trans('core::module.back_to_module') }}"
                        >
                            <i class="uil uil-angle-left-b"></i> &nbsp;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#fields"
                            role="tab" aria-controls="fields" aria-selected="true"
                        >
                            <i class="uil uil-clipboard-notes"></i>
                            {{ trans('core::module.module_field') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill"
                            href="#access" role="tab" aria-controls="access" aria-selected="false"
                        >
                            <i class="uil uil-key-skeleton"></i>
                            {{ trans('core::module.module_access') }}
                        </a>
                    </li>
                    <div class="m-add-field">
                        <a href="{{ route(getPrefix() . '.modules.edit', $module->id) }}"
                            class="btn btn-success btn-sm"
                        >
                            <i class="uil uil-plus"></i>
                            {{ trans('core::module.button.add_field') }}
                        </a>
                    </div>

                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                    <div class="tab-pane fade active show" id="fields"
                        role="tabpanel" aria-labelledby="fields-tab"
                    >
                        {!! $dataTable->table(['class' => 'table table-hover table-bordered']) !!}
                    </div>
                    <div class="tab-pane fade" id="access"
                        role="tabpanel" aria-labelledby="access-tab"
                    >
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    @include('core::admin.common.confirm_delete')
    @include('core::admin.modules._particle.modal_delete')
@stop
@push('script')
    {!! $dataTable->scripts() !!}
    <script>
        var changeField = false;
    </script>
    <script src="{{ asset('platform/admin/js/module.js') }}"></script>
@endpush
