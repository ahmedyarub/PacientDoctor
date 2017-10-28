<?php
$controller = (new ReflectionClass(\Route::getCurrentRoute()->getController()))->getShortName();
list(, $action) = explode('@', Route::getCurrentRoute()->getActionName());
?>
        <!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pacients & Doctors System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Template by FREEHTML5.CO"/>
    <meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive"/>
    <meta name="author" content="FREEHTML5.CO"/>

    <!--
      //////////////////////////////////////////////////////

      FREE HTML5 TEMPLATE
      DESIGNED & DEVELOPED by FREEHTML5.CO

      Website: 		http://freehtml5.co/
      Email: 			info@freehtml5.co
      Twitter: 		http://twitter.com/fh5co
      Facebook: 		https://www.facebook.com/fh5co

      //////////////////////////////////////////////////////
       -->

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content=""/>
    <meta name="twitter:image" content=""/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:card" content=""/>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{asset('css/icomoon.css')}}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/style.css')}}">


    <!-- Modernizr JS -->
    <script src="{{asset('js/modernizr-2.6.2.min.js')}}"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->

</head>
<body>
<div class="box-wrap">
    <header role="banner" id="fh5co-header">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="row">
                    <div class="col-md-3">
                        <div class="fh5co-navbar-brand">
                            <a class="fh5co-logo" href="index.html">Pacients & Doctors </a>
                        </div>
                    </div>
                    <div class="col-md-9 main-nav">
                        <ul class="nav text-right">
                            <li class="{{in_array($controller, ["LoginController"])?"active":""}}">
                                <a href="{{URL::action("Auth\LoginController@login")}}"><span>Login</span></a>
                            </li>
                            <li><a href="services.html">Services</a></li>
                            <li class="{{in_array($controller, ["DoctorsController"])?"active":""}}">
                                <a href="{{URL::action("DoctorsController@form")}}">Doctor Registration</a>
                            </li>
                            <li class="{{in_array($controller, ["PacientsController"])?"active":""}}">
                                <a href="{{URL::action("PacientsController@form")}}">Patient Registration</a>
                            </li>
                            <li class="{{in_array($controller, ["QuestionsController"])?"active":""}}">
                                <a href="{{URL::action("QuestionsController@form")}}">Question Registration</a>
                            </li>
                            <li class="{{in_array($controller, ["AnswersController"])?"active":""}}">
                                <a href="{{URL::action("AnswersController@form")}}">Answer Registration</a>
                            </li>
                            <li>
                                <a href="about.html">About</a>
                            </li>
                            <li class="{{in_array($controller, ["CategoriesController"])?"active":""}}">
                                <a href="{{URL::action("CategoriesController@selCategory")}}">Describe Your Case</a>
                            </li>
                            <li class="{{in_array($controller, ["LoginController"])?"active":""}}">
                                <a href="{{URL::action("Auth\LoginController@logout")}}"><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- END: header -->
    <div id="fh5co-contact-section">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <footer>
        <div id="footer" class="fh5co-border-line">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <p>Copyright 2016 Free Html5 <a href="#">Narrow</a>. All Rights Reserved. <br>Made with <i
                                    class="icon-heart3 love"></i> by <a href="http://freehtml5.co/" target="_blank">Freehtml5.co</a>
                            / Demo Images: <a href="https://unsplash.com/" target="_blank">Unsplash</a></p>
                        <p class="fh5co-social-icons">
                            <a href="#"><i class="icon-twitter-with-circle"></i></a>
                            <a href="#"><i class="icon-facebook-with-circle"></i></a>
                            <a href="#"><i class="icon-instagram-with-circle"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- END: box-wrap -->
</body>
</html>


<!-- jQuery -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<!-- jQuery Easing -->
<script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Owl carousel -->
<script src="{{asset('js/owl.carousel.min.js')}}"></script>
<!-- Waypoints -->
<script src="{{asset('js/jquery.waypoints.min.js')}}"></script>
<!-- Parallax Stellar -->
<script src="{{asset('js/jquery.stellar.min.js')}}"></script>

<!-- Main JS (Do not remove) -->
<script src="{{asset('js/main.js')}}"></script>

{!! Html::script("https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js") !!}
{!! Html::script('js/jquery.mask.min.js') !!}
<script>
    $(document).ready(function () {
        $('#phone').mask('9999-9999');
        $('#birth').mask('99/99/9999');
        /*  $('#email').mask(" A", {
              translation: {
                  "A": {pattern: /[\w@\-.+]/, recursive: true}
              }
          });*/
    });
</script>