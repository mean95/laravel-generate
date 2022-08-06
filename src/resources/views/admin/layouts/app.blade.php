<!DOCTYPE html>
<html>
<head>
    @include('core::admin.layouts.head')
</head>
<body class="mean hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('core::admin.layouts.header')

    @include('core::admin.layouts.sidebar')

    <div class="content-wrapper">
        @yield('breadcrumb')

        @yield('content')
    </div>

    @include('core::admin.layouts.footer')

</div>
@include('core::admin.common.flag_message')
@include('core::admin.common.confirm_delete')

@include('core::admin.layouts.script')

</body>
</html>
