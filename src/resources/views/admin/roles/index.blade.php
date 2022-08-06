@extends('core::admin.layouts.app')
@push('link')

@endpush
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => 'Roles',
    ])
@stop
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route(getPrefix() . '.roles.create') }}" class="btn btn-success btn-sm">
                        <i class="uil uil-plus"></i>
                        {{ trans('core::admin.button.create') }}
                    </a>
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-hover table-bordered']) !!}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>

@stop
@push('script')
    {!! $dataTable->scripts() !!}
@endpush
