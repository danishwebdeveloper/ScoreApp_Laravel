<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>@yield('page_title', 'Talent Ranker')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        @section('style')
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />

            {{ Html::style('web/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}
            {{ Html::style('web/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}
            <!-- END GLOBAL MANDATORY STYLES -->
            <!-- BEGIN THEME GLOBAL STYLES -->
            {{ Html::style('web/assets/global/css/components.min.css') }}
            {{ Html::style('web/assets/global/css/plugins.min.css') }}
            <!-- END THEME GLOBAL STYLES -->
            <!-- BEGIN THEME LAYOUT STYLES -->
            {{ Html::style('web/assets/layouts/layout2/css/layout.min.css') }}
            {{ Html::style('web/assets/layouts/layout2/css/themes/blue.min.css') }}
            {{ Html::style('web/assets/layouts/layout2/css/custom.min.css') }}
        @show

        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">

        <!-- BEGIN HEADER -->
        @include('elements.header')
        <!-- END HEADER -->

        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->

        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            @include('elements.sidebar')
            <!-- END SIDEBAR -->

            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    @yield('content')
                </div>
                <!-- END CONTENT BODY -->
            </div>
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">
                Talent Ranker Application
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
        </div>
        <!-- END FOOTER -->
        @include('elements.models.models')
        @section('javascript')
            <!--[if lt IE 9]>
            <script src="../assets/global/plugins/respond.min.js"></script>
            <script src="../assets/global/plugins/excanvas.min.js"></script> 
            <script src="../assets/global/plugins/ie8.fix.min.js"></script> 
            <![endif]-->
            <!-- BEGIN CORE PLUGINS -->
            {{ Html::script('web/assets/global/plugins/jquery.min.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}
            {{ Html::script('web/assets/global/plugins/js.cookie.min.js') }}
            {{ Html::script('web/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
            {{ Html::script('web/assets/global/plugins/jquery.blockui.min.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}
            {{ Html::style('web/assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}
            <!-- END CORE PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            {{ Html::script('web/assets/global/scripts/app.min.js') }}
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            {{ Html::script('web/assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}
            {{ Html::script('web/assets/pages/scripts/ui-extended-modals.min.js') }}
            {{ Html::script('web/assets/pages/scripts/components-bootstrap-select.min.js') }}
            {{ Html::script('web/assets/layouts/layout2/scripts/layout.min.js') }}
            {{ Html::script('web/assets/layouts/layout2/scripts/demo.min.js') }}
            {{ Html::script('web/assets/layouts/global/scripts/quick-sidebar.min.js') }}
            {{ Html::script('web/assets/layouts/global/scripts/quick-nav.min.js') }}
            {{ Html::script('web/assets/requests/global.js') }}
            <!-- END THEME LAYOUT SCRIPTS -->
        @show
    </body>

</html>