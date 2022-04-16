<!DOCTYPE html>
<html lang="en">
<head>
	<title>Cpanel</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{ asset('auth-assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('auth-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('auth-assets/fonts/flaticon/font/flaticon.css') }}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('auth-assets/img/favicon.ico') }}" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('auth-assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="{{ asset('auth-assets/css/skins/default.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/alertify.css') }}">

    <link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>
<body>

    <div class="page_loader"></div>

    <div class="login-17">
    <div class="container">
        <div class="col-md-12 pad-0">
            <div class="row login-box-6">
                <div class="col-lg-5 col-md-12 col-sm-12 col-pad-0 bg-img align-self-center none-992">
                    <a href="/" style="color: #fff; font-size: 30px;">
                        <!-- <img src="{{ asset('auth-assets/img/logos/logo.png') }}" class="logo" alt="logo"> -->
                        Cpanel
                    </a>
                    <p>Your limitation—it’s only your imagination.</p>
                    <!-- <a href="#" class="btn-outline">View More</a>
                    <ul class="social-list clearfix">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul> -->
                </div>

	           
               @yield('content')


                </div>
            </div>
        </div>
    </div>


    <!-- External JS libraries -->
    <script src="{{ asset('auth-assets/js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('auth-assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('auth-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/alertify.js') }}"></script>
    <!-- Custom JS Script -->

    @yield('scripts')
    @yield('notifications')

</body>
</html>
