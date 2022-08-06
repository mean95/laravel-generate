<script type="text/javascript">
    $(function() {
        toastr.options = {
            "debug": false,
            "positionClass": "toast-top-right",
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 4000,
            "extendedTimeOut": 1000,
            "closeButton": true,
            "preventDuplicates": true,
            "progressBar": true,
        }
    });
</script>

@if(session('success'))
    <script type="text/javascript">
        $(function() {
            toastr.success("{{ session('success') }}", "{{ trans('core::admin.flash_message.success') }}");
        });
    </script>
@endif

@if(session('warning'))
    <script type="text/javascript">
        $(function() {
            toastr.warning("{{ session('warning') }}", "{{ trans('core::admin.flash_message.warning') }}");
        });
    </script>
@endif

@if(session('error'))
    <script type="text/javascript">
        $(function() {
            toastr.error("{{ session('error') }}", "{{ trans('core::admin.flash_message.error') }}");
        });
    </script>
@endif
