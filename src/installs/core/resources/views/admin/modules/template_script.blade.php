<script type="text/x-custom-template" id="form_min_or_max">
    <div class="form-group m-min">
        {{ Form::label('minlength', trans('core::module.form.min.label')) }}
        {{ Form::text('minlength', old('minlength'), [
                'class' => 'form-control form-control-sm',
                'placeholder' => trans('core::module.form.min.placeholder')
            ])
        }}
    </div>
    <div class="form-group m-max">
        {{ Form::label('maxlength', trans('core::module.form.max.label')) }}
        {{ Form::text('maxlength', old('maxlength'), [
                'class' => 'form-control form-control-sm',
                'placeholder' => trans('core::module.form.max.placeholder')
            ])
        }} 
    </div>
</script>
<script type="text/x-custom-template" id="form_unique">
    <div class="form-group m-unique">
        {{ Form::label('maxlength', trans('core::module.table.unique'), ['class' => 'mr-3']) }}
        <label class="checkbox">
            {{ Form::checkbox('unique', null, false, [
                    'data-toggle' => 'toggle',
                    'data-width' => '50',
                    'data-size' => 'mini',
                ]) 
            }}
        </label>
    </div>
</script>
<script type="text/x-custom-template" id="form_popup_val">
    <div class="form-group m-popup-val">
        {{ Form::label('popup_vals', trans('core::module.table.value') . ' :') }}
        <div class="radio">
            <label class="m-radio-label d-line">
                {{ Form::radio('popup_value_type', 'table', true, [
                        'class' => 'm-radio',
                        'id' => 'popup_value_type_1',
                    ])
                }}
                <span class="m-indicator"></span>
                {{ Form::label('popup_value_type_1', trans('core::module.table.from_table'), ['class' => 'm-label']) }}
            </label>
            <label class="m-radio-label d-line">
                {{ Form::radio('popup_value_type', 'list', false, [
                        'class' => 'm-radio',
                        'id' => 'popup_value_type_2',
                    ])
                }}
                <span class="m-indicator"></span>
                {{ Form::label('popup_value_type_2', trans('core::module.table.from_list'), ['class' => 'm-label']) }}
            </label>
        </div>
    </div>
</script>
<script type="text/x-custom-template" id="form_from_table">
    {{ 
        Form::select('popup_val_table', $tables, null, [
            'class' => 'form-control custom-select-sm select2',
            'id' => 'popup_val_table'
        ])
    }}
    
</script>
<script type="text/x-custom-template" id="form_from_list">
    {{ 
        Form::select('popup_val_list[]', [], null, [
            'class' => 'form-control',
            'id' => 'popup_val_table',
            'multiple' => '',
            'data-role' => 'tagsinput'
        ])
    }}
</script>
<script type="text/x-custom-template" id="form_tagsinput">
    <div class="form-group m-popup-val">
        {{ Form::label('popup_vals', trans('core::module.table.tag_input')) }}    
    </div>
</script>
