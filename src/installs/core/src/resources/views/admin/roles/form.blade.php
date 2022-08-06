<div class="form-group">
    {!! Form::label('name', trans('core::role.form.name.label')) !!}
    <span class="star-required"> *</span>
    {{
        Form::text('name', old('name', $role->name ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::role.form.name.placeholder'),
        ])
    }}
    @error('name')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('display_name', trans('core::role.form.display_name.label')) !!}
    <span class="star-required"> *</span>
    {{
        Form::text('display_name', old('display_name', $role->display_name ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::role.form.display_name.placeholder'),
        ])
    }}
    @error('display_name')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {!! Form::label('description', trans('core::role.form.description.label')) !!}
    {{
        Form::textarea('description', old('description', $role->description ?? ''), [
            'class' => 'form-control form-control-sm',
            'rows' => 3,
            'placeholder' => trans('core::role.form.description.placeholder'),
        ])
    }}
    @error('description')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
