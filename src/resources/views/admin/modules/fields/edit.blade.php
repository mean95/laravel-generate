@extends('core::admin.layouts.app')
@push('link')
    <link rel="stylesheet" href="{{ asset('platform/admin/css/module.css') }}">
@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::module.module'),
        'route' => route(getPrefix() . '.modules.show', $field->module->id),
        'edit' => trans('core::module.button.edit_field'),
    ])
@stop
@section('content')
    <section class="content">
        {{
            Form::open(['action' => 'ModuleFieldController@update', 'id' => 'form_add_field',
                'route' => [getPrefix() . '.module_fields.update', $field->id],
                'method' => 'PUT'
            ])
        }}
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="modal-body">
                        <div class="form-group m-field-label">
                            {{ Form::label('label', trans('core::module.form.field_label.label')) }}
                            {{ Form::text('label', old('label', $field->label), [
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
                            {{ Form::hidden('module_id', $field->module->id) }}
                            {{ Form::text('column_name', old('column_name', $field->column_name), [
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
                                Form::select('module_field_type_id', $moduleFieldTypes, $field->module_field_type_id, [
                                    'class' => 'form-control custom-select-sm'
                                ])
                            }}
                            @error('module_field_type_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        @if(in_array($field->module_field_type_id, config('core.unique_field')))
                            <div class="form-group m-unique">
                                {{ Form::label('maxlength', trans('core::module.table.unique'), ['class' => 'mr-3']) }}
                                <label class="checkbox">
                                    {{ Form::checkbox('unique', null, $field->unique === 1 ? true :false, [
                                            'data-toggle' => 'toggle',
                                            'data-width' => '50',
                                            'data-size' => 'mini',
                                        ])
                                    }}
                                </label>
                            </div>
                        @endif
                        <div class="form-group m-default-value">
                            {{ Form::label('default_value', trans('core::module.form.default_value.label')) }}
                            {{ Form::text('default_value', old('default_value', $field->default_value), [
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => trans('core::module.form.default_value.placeholder')
                                ])
                            }}
                        </div>
                        @if(in_array($field->module_field_type_id, config('core.min_max_field')))
                            <div class="form-group m-min">
                                {{ Form::label('minlength', trans('core::module.form.min.label')) }}
                                {{ Form::text('minlength', old('minlength', $field->minlength), [
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => trans('core::module.form.min.placeholder')
                                    ])
                                }}
                            </div>
                            <div class="form-group m-max">
                                {{ Form::label('maxlength', trans('core::module.form.max.label')) }}
                                {{ Form::text('maxlength', old('maxlength', $field->maxlength), [
                                        'class' => 'form-control form-control-sm',
                                        'placeholder' => trans('core::module.form.max.placeholder')
                                    ])
                                }}
                            </div>
                        @endif
                        <div class="form-group m-required">
                            {{ Form::label('required', trans('core::module.table.required'), ['class' => 'mr-3']) }}
                            <label class="checkbox">
                                {{ Form::checkbox('required', null, $field->required === 1 ? true : false, [
                                        'data-toggle' => 'toggle',
                                        'data-width' => '50',
                                        'data-size' => 'mini',
                                    ])
                                }}
                            </label>
                        </div>
                        @if(in_array($field->module_field_type_id, config('core.popup_field')))
                            <div class="form-group m-popup-val">
                                {{ Form::label('popup_vals', trans('core::module.table.value') . ' :') }}
                                <div class="radio">
                                    <label class="m-radio-label d-line">
                                        {{ Form::radio('popup_value_type', 'table',
                                            empty($field->popup_val) || startsWith($field->popup_val, '@') ? true : false,
                                            [
                                                'class' => 'm-radio',
                                                'id' => 'popup_value_type_1',
                                            ])
                                        }}
                                        <span class="m-indicator"></span>
                                        {{ Form::label('popup_value_type_1', trans('core::module.table.from_table'), ['class' => 'm-label']) }}
                                    </label>
                                    <label class="m-radio-label d-line">
                                        {{ Form::radio('popup_value_type', 'list',
                                            empty($field->popup_val) || startsWith($field->popup_val, '@') ? false : true,
                                            [
                                                'class' => 'm-radio',
                                                'id' => 'popup_value_type_2',
                                            ])
                                        }}
                                        <span class="m-indicator"></span>
                                        {{ Form::label('popup_value_type_2', trans('core::module.table.from_list'), ['class' => 'm-label']) }}
                                    </label>
                                </div>
                                @if(empty($field->popup_val) || startsWith($field->popup_val, '@'))
                                    {{
                                        Form::select('popup_val_table', $tables, str_replace('@', '', $field->popup_val), [
                                            'class' => 'form-control custom-select-sm select2',
                                            'id' => 'popup_val_table'
                                        ])
                                    }}
                                @else
                                    {{
                                        Form::select('popup_val_list[]', getPopupValTagsInput($field->popup_val), null, [
                                            'class' => 'form-control',
                                            'id' => 'popup_val_table',
                                            'multiple' => '',
                                            'data-role' => 'tagsinput'
                                        ])
                                    }}
                                @endif
                            </div>
                        @endif
                        @if($field->module_field_type_id === config('core.tag_input'))
                            <div class="form-group m-popup-val">
                                {{ Form::label('popup_vals', trans('core::module.table.tag_input')) }}
                                {{
                                    Form::select('popup_val_list[]', getPopupValTagsInput($field->popup_val), null, [
                                        'class' => 'form-control',
                                        'id' => 'popup_val_table',
                                        'multiple' => '',
                                        'data-role' => 'tagsinput'
                                    ])
                                }}
                            </div>
                        @endif
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
        var changeField = false;
    </script>
    <script src="{{ asset('platform/admin/js/module.js') }}"></script>
@endpush
