<div class="form-group">
    {!! Form::label($fieldName, $options['label']) !!}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    {{ Form::password($fieldName, $params) }}
    @error($fieldName)
        <span class="error">{{ $message }}</span>
    @enderror
</div>
@php
    $nameConfirm = $fieldName . '_confirmation';
@endphp
<div class="form-group">
    {!! Form::label($nameConfirm, $options['label'] . ' confirmation') !!}
    {{ Form::password($nameConfirm, $params) }}
</div>