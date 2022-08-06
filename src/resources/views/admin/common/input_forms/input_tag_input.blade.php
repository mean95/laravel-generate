<div class="form-group">
    {!! Form::label($fieldName, $options['label']) !!}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    {{ Form::select($fieldName . '[]', $options['default_value'], null, $params) }}
    @error($fieldName)
        <span class="error">{{ $message }}</span>
    @enderror
</div>
