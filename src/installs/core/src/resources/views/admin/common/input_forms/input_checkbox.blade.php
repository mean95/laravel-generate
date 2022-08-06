<div class="form-group">
    {{ Form::label($fieldName, $options['label']) }}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    <br>
    <div>
    @foreach($popupVales as $key => $value)
        <label class="m-checkbox-label d-line">
            {{
                Form::checkbox($fieldName . '[]', $key, $key == old($fieldName, $options['default_value']) ? true : false, $params)
            }}
            <span class="m-checkmark"></span>
            {{ Form::label($fieldName, $value, ['class' => 'm-label']) }}
        </label>
    @endforeach
    </div>
    @error($fieldName)
    <span class="error">{{ $message }}</span>
    @enderror
</div>

