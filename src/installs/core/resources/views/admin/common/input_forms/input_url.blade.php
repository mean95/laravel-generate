<div class="form-group">
    {!! Form::label($fieldName, $options['label']) !!}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    <input class="form-control form-control-sm {{ $params['class'] }}"
        placeholder="{{ $params['placeholder'] }}" {{ !empty($params['required']) ? 'required' : '' }}
        minlength="{{ $params['minlength'] }}" maxlength="{{ $params['maxlength'] }}" 
        name="{{ $fieldName }}" type="url" id="{{ $fieldName }}"
        value="{{ old($fieldName, $options['default_value']) }}"
    >
    @error($fieldName)
        <span class="error">{{ $message }}</span>
    @enderror
</div>
