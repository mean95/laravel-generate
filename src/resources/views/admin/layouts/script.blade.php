<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('platform/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('platform/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Bootstrap 4 -->
<script src="{{ asset('platform/admin/plugins/toastr/toastr.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('platform/admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('platform/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('platform/admin/plugins/datatables-bs4/js/dataTables.fixedColumns.min.js') }}"></script>

<!-- Bootstrap Switch -->
<script src="{{ asset('platform/admin/plugins/switch/switch.min.js') }}"></script>

<!-- Tags input -->
<script src="{{ asset('platform/admin/plugins/tagsinput/bootstrap-tagsinput.min.js') }}"></script>

<!-- DateTime picker -->
<script src="{{ asset('platform/admin/plugins/datetimepicker/js/moment.min.js') }}"></script>
<script src="{{ asset('platform/admin/plugins/datetimepicker/js/datetimepicker.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('platform/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<!-- Validation -->
<script src="{{ asset('platform/admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('platform/admin/plugins/jquery-validation/localization/messages_'. App::getLocale() .'.js') }}"></script>

<!-- Summernote v0.8.18 -->
<script src="{{ asset('platform/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>

@routes
<!-- AdminLTE App -->
<script src="{{ asset('platform/admin/js/adminlte.js') }}"></script>
<script src="{{ asset('platform/admin/js/common.js') }}"></script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var app = {
        locale: "{{ App::getLocale() }}",
        uniqueValue: "{{ trans('core::admin.validate.unique') }}",
    };
</script>
@stack('script')