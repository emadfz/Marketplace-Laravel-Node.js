<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ trans('site.admin.title') }}</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('admin.layouts.partials.styles')
        @stack('styles')
    </head>
    <body class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="{{route(config('project.admin_route').'home.index')}}">
                <img src="{{ asset('assets/admin/pages/img/logo-big.png') }}" alt="" />
            </a>
        </div>
        <!-- END LOGO -->

        <div class="content">
            @include('admin.layouts.partials.flash_message')
            @yield('content')
        </div>

        <!-- Java Scripts -->
        @include('admin.layouts.partials.scripts')
        @stack('scripts')
    </body>
</html>