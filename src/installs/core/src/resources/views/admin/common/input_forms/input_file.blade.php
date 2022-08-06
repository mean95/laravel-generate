<div class="form-group group-file">
    {!! Form::label($fieldName, $options['label']) !!}
    <span class="star-required">{{ $options['required_ast'] }}</span>
    <div class="custom-file">
        {{ Form::text($fieldName, old($fieldName, $options['default_value']), $params) }}
        <label class="custom-file-label" for="customFile">
            {{ getUrlFile($options['default_value']) ?:  trans('core::admin.button.choose_file') }}
        </label>
    </div>
    <div class="file-preview" style="margin-top:15px">
        @if(!empty($options['default_value']))
            <img src="{{ getUrlFileThumbnail($options['default_value']) }}"/>
        @endif
    </div>
</div>