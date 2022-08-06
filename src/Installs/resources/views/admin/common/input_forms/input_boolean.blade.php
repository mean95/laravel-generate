<div class="form-group">
    {{ Form::label($fieldName, $options['label']) }}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    <label class="checkbox">
        {{ Form::checkbox($fieldName, null, $options['default_value'] === 1 ? true : false, $params)}}
    </label>
    @error($fieldName)
    <br><span class="error">{{ $message }}</span>
    @enderror
</div>
