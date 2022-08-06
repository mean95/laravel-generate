<div class="form-group">
    {{ Form::label($fieldName, $options['label']) }}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    <br>
    <div>
    @foreach($popupVales as $key => $value)
    @php
        $params['id'] = 'radio_' . $key;
    @endphp
    <label class="m-radio-label d-line">
        {{
            Form::radio($fieldName, $key, $key == old($fieldName, $options['default_value']) ? true : false, $params)
        }}
        <span class="m-indicator"></span>
        {{ Form::label($fieldName, $value, ['class' => 'm-label']) }}
    </label>
    @endforeach
    </div>
    @error($fieldName)
    <span class="error">{{ $message }}</span>
    @enderror
</div>

