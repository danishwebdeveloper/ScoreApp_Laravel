<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>@yield('page_title', 'Talent Ranker - Login')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        @section('style')
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
            
            {{ Html::style('web/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}
            {{ Html::style('web/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}
            {{ Html::style('web/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}
            <!-- END GLOBAL MANDATORY STYLES -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            {{ Html::style('web/assets/global/plugins/select2/css/select2.min.css') }}
            {{ Html::style('web/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL STYLES -->
            {{ Html::style('web/assets/global/css/components.min.css') }}
            {{ Html::style('web/assets/global/css/plugins.min.css') }}
            <!-- END THEME GLOBAL STYLES -->
            <!-- BEGIN PAGE LEVEL STYLES -->
            {{ Html::style('web/assets/pages/css/login-2.min.css') }}
            <!-- END PAGE LEVEL STYLES -->
            <!-- BEGIN THEME LAYOUT STYLES -->
            <!-- END THEME LAYOUT STYLES -->
            <link rel="shortcut icon" href="favicon.ico" /> 
        @show
    </head>
    <!-- END HEAD -->
    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <h3>Talent Ranker</h3>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
             @yield('content')
        </div>

        @section('javascript')
            <!--[if lt IE 9]>
            {{ Html::script('web/assets/global/plugins/respond.min.js') }}
            {{ Html::script('web/assets/global/plugins/excanvas.min.js') }}
            {{ Html::script('web/assets/global/plugins/ie8.fix.min.js') }}
            <![endif]-->
            <!-- BEGIN CORE PLUGINS -->
            {{ Html::script('web/assets/global/plugins/jquery.min.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}
            {{ Html::script('web/assets/global/plugins/js.cookie.min.js') }}
            {{ Html::script('web/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
            {{ Html::script('web/assets/global/plugins/jquery.blockui.min.js') }}
            {{ Html::script('web/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            {{ Html::script('web/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}
            {{ Html::script('web/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}
            {{ Html::script('web/assets/global/plugins/select2/js/select2.full.min.js') }}
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            {{ Html::script('web/assets/global/scripts/app.min.js') }}
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
            {{ Html::script('web/assets/pages/scripts/login.min.js') }}
            <!-- END PAGE LEVEL SCRIPTS -->
        @show
    </body>

</html>