<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ trans('site.admin.title') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        @include('admin.layouts.partials.styles')
        @stack('styles')                
        <link rel="shortcut icon" href="{{asset('assets/admin/favicon.ico')}}" />
       
    </head>

    <body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">


        <!-- Header -->
        @include('admin.layouts.partials.header')

        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->

        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- Sidebar -->
            @include('admin.layouts.partials.sidebar')


            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">                    
                                        
                    <!-- Sub navigation -->
                    {{--@include('admin.layouts.partials.sub_navigation')--}}
                    
                    <!-- BEGIN PAGE BASE CONTENT -->
                    @include('admin.layouts.partials.flash_message')
                    @yield('content')
                    <!-- END PAGE BASE CONTENT -->    
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            @include('admin.layouts.partials.quick_sidebar')
        </div>
        <!-- END CONTAINER -->

        @include('admin.layouts.partials.footer')

        <!-- JS -->
        @include('admin.layouts.partials.scripts')
        @stack('scripts')

    </body>
</html>