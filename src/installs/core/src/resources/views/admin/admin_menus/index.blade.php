@extends("core::admin.layouts.app")

@push('link')
	<link rel="stylesheet" href="{{ asset('platform/admin/plugins/nestable/nestable.css') }}">
    <link rel="stylesheet" href="{{ asset('platform/admin/css/menu.css') }}">
    <!-- Icon picker -->
    <link rel="stylesheet" href="{{ asset('platform/admin/plugins/iconscout-iconpicker/css/iconscout-iconpicker.min.css') }}">
@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::menu.menu'),
    ])
@stop
@section("content")
<section class="content">
    <div class="row">
        <div class="col-md-5">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->any() ? '' : 'active' }}" data-toggle="pill" href="#module" 
                                role="tab" aria-controls="module" aria-selected="true"
                            >
                                {{ trans('core::menu.module') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $errors->any() ? 'active' : '' }}" data-toggle="pill" 
                                href="#custom-link" role="tab" aria-controls="custom-link" aria-selected="false"
                            >
                                {{ trans('core::menu.custom_link') }}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade {{ $errors->any() ? '' : 'active show' }}" id="module" 
                            role="tabpanel" aria-labelledby="module-tab"
                        >
                            <ul class="list-module">
                                @foreach($modules as $module)
                                    <li>
                                        <i class="{{ $module->icon }}"></i> 
                                        {{ $module->name }} 
                                        <a data-module="{{ $module->id }}" class="js-add-module-menu pull-right">
                                            <i class="uil uil-plus"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-pane fade {{ $errors->any() ? 'active show' : '' }}" id="custom-link" 
                            role="tabpanel" aria-labelledby="custom-link-tab"
                        >
                            <form method="POST" action="{{ route(getPrefix() . '.admin_menus.store') }}" 
                                class="form-horizontal mt-4"
                            >
                                @csrf
                                <div class="box-body fields-group">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('core::menu.form.name.label') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                class="form-control form-control-sm"
                                                placeholder="{{ trans('core::menu.form.name.placeholder') }}"
                                            />
                                            @error('name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('core::menu.form.icon.label') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="input-group iconpicker-container">
                                                <input type="text" name="icon" value="{{ old('icon', 'uil uil-500px') }}" 
                                                    autocomplete="off" class="form-control form-control-sm icon iconpicker-input" 
                                                    placeholder="{{ trans('core::menu.form.icon.placeholder') }}"
                                                />
                                                @error('icon')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('core::menu.form.url.label') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" value="{{ old('url') }}" class="form-control form-control-sm" 
                                                name="url" placeholder="{{ trans('core::menu.form.url.placeholder') }}"
                                            />
                                            @error('url')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('core::menu.form.parent.label') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <select class="form-control form-control-sm custom-select-sm select2" name="admin_menu_id">
                                                <option value="0">{{ trans('core::menu.form.parent.placeholder') }}</option>
                                                @foreach($menus as $adminMenu)
                                                    <option value="{{ $adminMenu->id }}">{{ $adminMenu->name }}</option>
                                                    @foreach($adminMenu->menuChildren as $menuChildren)
                                                        @include('core::admin.admin_menus.menu_children_select', [
                                                            'menuChildren' => $menuChildren,
                                                            'slas' => '—'
                                                        ])
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @error('admin_menu_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">
                                            {{ trans('core::menu.form.sort.label') }}
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="sort" value="{{ old('sort') }}" class="form-control form-control-sm" 
                                                placeholder="{{ trans('core::menu.form.sort.label') }}"
                                            />
                                            @error('sort')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="btn-group pull-right">
                                                <button type="submit" class="btn btn-primary btn-sm pull-right">
                                                    {{ trans('core::menu.button.add_to_menu') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- /.card -->
        </div>

        <div class="col-md-7">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    @include('core::admin.admin_menus.list')
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
@include('core::admin.common.confirm_delete')
@endsection

@push('script')
    <script src="{{ asset('platform/admin/plugins/nestable/jquery.nestable.js') }}"></script>
    <!-- Icon picker -->
    <script src="{{ asset('platform/admin/plugins/iconscout-iconpicker/js/iconscout-iconpicker.min.js') }}"></script>
    <script src="{{ asset('platform/admin/js/menu.js') }}"></script>
@endpush