@extends('core::admin.layouts.app')
@push('link')
    <link rel="stylesheet" href="{{ asset('platform/admin/css/module.css') }}">
@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::module.module'),
        'route' => route(getPrefix() . '.modules.show', $module->id),
        'edit' => trans('core::module.button.add_field'),
    ])
@stop
@section('content')
    <section class="content">
        {{
            Form::open(['action' => 'ModuleController@store', 'id' => 'form_add_field',
                'route' => getPrefix() . '.module_fields.store'])
        }}
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="modal-body">
                            <div class="form-group m-field-label">
                                {{ Form::label('label', trans('core::module.form.field_label.label')) }}
                                {{ Form::text('label', old('label'), [
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => trans('core::module.form.field_label.placeholder')
                                    ])
                                }}
                                @error('label')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group m-column-name">
                                {{ Form::label('column_name', trans('core::module.form.column_name.label')) }}
                                {{ Form::hidden('module_id', $module->id) }}
                                {{ Form::text('column_name', old('column_name'), [
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => trans('core::module.form.column_name.placeholder')
                                    ])
                                }}
                                @error('column_name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group m-ui-type">
                                {{ Form::label('module_field_type_id', trans('core::module.form.ui_type.label')) }}
                                {{
                                    Form::select('module_field_type_id', $moduleFieldTypes, null, [
                                        'class' => 'form-control custom-select-sm'
                                    ])
                                }}
                                @error('module_field_type_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group m-default-value">
                                {{ Form::label('default_value', trans('core::module.form.default_value.label')) }}
                                {{ Form::text('default_value', old('default_value'), [
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => trans('core::module.form.default_value.placeholder')
                                    ])
                                }}
                            </div>
                            <div class="form-group m-required">
                                {{ Form::label('required', trans('core::module.table.required'), ['class' => 'mr-3']) }}
                                <label class="checkbox">
                                    {{ Form::checkbox('required', null, false, [
                                            'data-toggle' => 'toggle',
                                            'data-width' => '50',
                                            'data-size' => 'mini',
                                        ])
                                    }}
                                </label>
                            </div>
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
    @include('core::admin.modules.template_script')
@stop
@push('script')
    <script type="text/javascript">
        var changeField = true;
    </script>
    <script src="{{ asset('platform/admin/js/module.js') }}"></script>
@endpush
