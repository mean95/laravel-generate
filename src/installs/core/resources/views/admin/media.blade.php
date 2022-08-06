@extends('core::admin.layouts.app')
@section('breadcrumb')
    @include('core::admin.layouts.breadcrumb', [
        'module' => trans('core::admin.media.label'),
    ])
@stop
@section('content')
    <section class="content">
        <div class="card">
            <div class="card-body p-0">
                <iframe src="{{ route('admin.file_manager.show') }}" 
                    style="width: 100%; height: 700px; overflow: hidden; border: none;"
                ></iframe>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@stop