<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>@yield('page_title', 'CMS')</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/fontawesome-free/css/all.min.css') }}">

<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

<!-- Font roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

<!-- Icon iconscout -->
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">

<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/toastr/toastr.css') }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/datatables-bs4/css/fixedColumns.bootstrap4.min.css') }}">

<!-- Switch toggle -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/switch/switch.min.css') }}">

<!-- Tags input -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/tagsinput/bootstrap-tagsinput.css') }}">

<!-- DateTime picker -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/datetimepicker/css/datetimepicker.min.css') }}">

<!-- Select 2 -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/select2/css/select2.min.css') }}">

<!-- Summernote v0.8.18 -->
<link rel="stylesheet" href="{{ asset('platform/admin/plugins/summernote/summernote-bs4.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('platform/admin/css/adminlte.css') }}">
<link rel="stylesheet" href="{{ asset('platform/admin/css/style.css') }}">

<!-- jQuery -->
<script src="{{ asset('platform/admin/plugins/jquery/jquery.min.js') }}"></script>
@stack('link')