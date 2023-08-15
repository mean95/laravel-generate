<div class="form-group">
    {{ Form::label('first_name', trans('core::admin_user.form.first_name.label')) }}
    <span class="star-required">*</span>
    {{
        Form::text('first_name', old('first_name', $user->first_name ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.first_name.placeholder'),
            'required' => '',
            'maxlength' => 80,
        ])
    }}
    @error('first_name')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('last_name', trans('core::admin_user.form.last_name.label')) }}
    <span class="star-required">*</span>
    {{
        Form::text('last_name', old('last_name', $user->last_name ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.last_name.placeholder'),
            'required' => '',
            'maxlength' => 80,
        ])
    }}
    @error('last_name')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('username', trans('core::admin_user.form.username.label')) }}
    <span class="star-required">*</span>
    {{
        Form::text('username',  old('username', $user->username ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.username.placeholder'),
            'required' => '',
            'maxlength' => 20,
            'minlength' => 3,
        ])
    }}
    @error('username')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('email', trans('core::admin_user.form.email.label')) }}
    <span class="star-required">*</span>
    {{
        Form::email('email',  old('email', $user->email ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.email.placeholder'),
            'required' => '',
        ])
    }}
    @error('email')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('email', trans('core::admin_user.form.about.label')) }}
    <span class="star-required">*</span>
    {{
        Form::textarea('about',  old('about', $user->about ?? ''), [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.about.placeholder'),
            'required' => '',
        ])
    }}
    @error('about')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('type', trans('core::admin_user.form.role.label')) }}
    {{
        Form::select('role[]', $roles->pluck('name', 'id'), old('role', !empty($user) ? $user->adminUserRole->pluck('role_id') : []), [
            'class' => 'form-control custom-select-sm select2',
            'required' => '',
            'data-placeholder' => trans('core::admin_user.form.role.placeholder'),
            'multiple' => 'multiple',
        ])
    }}
    @error('role')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('status', trans('core::admin_user.form.status.label')) }}
    <br>
    <label class="checkbox">
        {{
            Form::checkbox('status', null, $user->status ?? 0 === 1 ? true : false, [
                'data-toggle' => 'toggle',
                'data-width' => '50',
                'data-size' => 'mini',
            ])
        }}
    </label>
    @error('status')
    <br><span class="error">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    {{ Form::label('password', trans('core::admin_user.form.password.label')) }}
    <span class="star-required">*</span>
    {{
        Form::password('password', [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.password.placeholder'),
            'maxlength' => 32,
            'minlength' => 6,
        ])
    }}
    @error('password')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    {{ Form::label('password_confirmation', trans('core::admin_user.form.password_confirmation.label')) }}
    <span class="star-required">*</span>
    {{
        Form::password('password_confirmation', [
            'class' => 'form-control form-control-sm',
            'placeholder' => trans('core::admin_user.form.password_confirmation.placeholder')
        ])
    }}
</div>
