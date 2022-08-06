@extends('core::admin.layouts.app')
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::admin_user.user'),
    ])
@stop
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a href="{{ route(getPrefix() . '.admin_users.create') }}" class="btn btn-success btn-sm">
                        <i class="uil uil-plus"></i>
                        {{ trans('core::admin.button.create') }}
                    </a>
                </h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
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
    @include('core::admin.modules._particle.modal_delete')
@stop
@push('script')
    {!! $dataTable->scripts() !!}
@endpush
