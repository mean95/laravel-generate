<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark title-page">
                    {{ $module }}
                    @if(!empty($edit))
                        <small>{{ $edit }}</small>
                    @else
                        <small>{{ trans('core::admin.button.list') }} {{ Str::singular($module) }}</small>
                    @endif
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.home') }}">
                            <i style="font-size: 16px;" class="uil uil-tachometer-fast-alt"></i>{{ trans('core::admin.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        @if(!empty($route))
                            <a href="{{ $route }}">
                                {{ $module }}
                            </a>
                        @else
                            {{ $module }}
                        @endif
                    </li>
                    @if(!empty($edit))
                        <li class="breadcrumb-item active">{{ $edit }}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div>
</div>
