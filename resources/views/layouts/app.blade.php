<?php
$controller = (new ReflectionClass(\Route::getCurrentRoute()->getController()))->getShortName();
list(, $action) = explode('@', Route::getCurrentRoute()->getActionName());
?>
        <!DOCTYPE html>
<html lang="en" class="wide wow-animation smoothscroll scrollTo">
<head>
    <!-- Site Title-->
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="SANA design multipurpose template">
    <meta name="date" content="Dec 26">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Oswald%7CLato:400italic,400,700">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img
                src="{{asset('images/ie8-panel/warning_bar_0000_us.jpg')}}" border="0" height="42" width="820"
                alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
    </div>
    <script src="{{asset('js/html5shiv.min.js')}}"></script>
    <![endif]-->
    <script src="{{asset('node_modules/jquery/dist/jquery.js')}}"></script>
    <script src="{{asset('node_modules/socket.io-client/dist/socket.io.js')}}"></script>
    <script> public_path = '{{ url('/') }}';</script>
</head>
<body>
<!-- Page-->
<div class="page text-center">
    <!-- Page Header-->
    <header class="page-head">
        <!-- RD Navbar minimal-->
        <div class="rd-navbar-wrap">
            <nav data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-static"
                 data-md-stick-up-offset="120px" data-lg-stick-up-offset="120px"
                 class="rd-navbar rd-navbar-minimal rd-navbar-light " data-lg-auto-height="true"
                 data-md-layout="rd-navbar-static" data-lg-layout="rd-navbar-static" data-lg-stick-up="true">
                <div class="rd-navbar-inner">
                    <div class="rd-navbar-top-panel">
                        <!--Navbar Brand-->
                        <div class="rd-navbar-brand veil reveal-md-inline-block"><a
                                    href="{{URL::action("Auth\LoginController@login")}}"><img width='197' height='52'
                                                                                              class='img-responsive'
                                                                                              src='{{asset('images/logo-dark.png')}}'
                                                                                              alt=''/></a></div>
                        <div>
                            <!-- Contact Info-->
                            <address class="contact-info reveal-sm-inline-block text-left offset-none">
                                <div class="p unit unit-spacing-xs unit-horizontal">
                                    <div class="unit-left"><span
                                                class="icon icon-xs icon-circle icon-gray-light mdi mdi-phone text-java"></span>
                                    </div>
                                    <div class="unit-body"><a href="callto:#"
                                                              class="text-gray-darker">1-800-1234-567</a><br/><a
                                                href="callto:#" class="text-gray-darker">1-800-3214-654</a></div>
                                </div>
                            </address>
                            <!-- Contact Info-->
                            <address class="contact-info reveal-sm-inline-block text-left">
                                <div class="p unit unit-horizontal unit-spacing-xs">
                                    <div class="unit-left"><span
                                                class="icon icon-xs icon-circle icon-gray-light mdi mdi-map-marker text-java"></span>
                                    </div>
                                    <div class="unit-body"><a href="#" class="text-gray-darker">2130 Fulton Street San
                                            Diego<br/>CA 94117-1080 USA</a></div>
                                </div>
                            </address>
                        </div>
                    </div>
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap" class="rd-navbar-toggle">
                            <span></span></button>
                        <!--Navbar Brand-->
                        <div class="rd-navbar-brand veil-md"><a
                                    href="{{URL::action("Auth\LoginController@login")}}"><img width='197' height='52'
                                                                                              class='img-responsive'
                                                                                              src='{{asset('images/logo-dark.png')}}'
                                                                                              alt=''/></a></div>
                        <button data-rd-navbar-toggle=".rd-navbar, .rd-navbar-top-panel"
                                class="rd-navbar-top-panel-toggle"><span></span></button>
                    </div>
                    <div class="rd-navbar-menu-wrap">
                        <div class="rd-navbar-nav-wrap">
                            <div class="rd-navbar-mobile-scroll">
                                <!--Navbar Brand Mobile-->
                                <div class="rd-navbar-mobile-brand"><a
                                            href="{{URL::action("Auth\LoginController@login")}}"><img width='197'
                                                                                                      height='52'
                                                                                                      class='img-responsive'
                                                                                                      src='{{asset('images/logo-dark.png')}}'
                                                                                                      alt=''/></a></div>
                                <div class="form-search-wrap">
                                    <!-- RD Search Form-->
                                    <form action="search-results.html" method="GET" class="form-search rd-search">
                                        <div class="form-group">
                                            <label for="rd-navbar-form-search-widget"
                                                   class="form-label form-search-label form-label-sm">Search</label>
                                            <input id="rd-navbar-form-search-widget" type="text" name="s"
                                                   autocomplete="off"
                                                   class="form-search-input form-control form-control-gray-lightest input-sm"/>
                                        </div>
                                        <button type="submit" class="form-search-submit"><span
                                                    class="fa fa-search text-primary"></span></button>
                                    </form>
                                </div>
                                <!-- RD Navbar Nav-->
                                <ul class="rd-navbar-nav">
                                    @if(!\Auth::check())
                                        <li class="{{in_array($controller, ["LoginController"])?"active":""}}">
                                            <a href="{{URL::action("Auth\LoginController@login")}}"><span>Login</span></a>
                                        </li>
                                        <li class="{{in_array($controller, ["DoctorsController"])?"active":""}}">
                                            <a href="{{URL::action("DoctorsController@form")}}">Doctor Registration</a>
                                        </li>
                                        <li class="{{in_array($controller, ["PacientsController"])?"active":""}}">
                                            <a href="{{URL::action("PacientsController@form")}}">Patient
                                                Registration</a>
                                        </li>
                                    @endif
                                    @if(\Auth::check())
                                        @if(\Auth::user()->admin)
                                            <li class="{{in_array($controller, ["QuestionsController"])?"active":""}}">
                                                <a href="{{URL::action("QuestionsController@form")}}">Question
                                                    Registration</a>
                                            </li>
                                            <li class="{{in_array($controller, ["AnswersController"])?"active":""}}">
                                                <a href="{{URL::action("AnswersController@form")}}">Answer
                                                    Registration</a>
                                            </li>
                                        @endif
                                        <li class="{{ $action == 'doctor_cases'?"active":""}}">
                                            <a href="{{URL::action("DoctorsController@doctor_cases")}}">My Cases</a>
                                        </li>
                                        @if(\Auth::user()->isDoctor())
                                            <li class="{{ $action == 'waiting_patients'?"active":""}}">
                                                <a href="{{URL::action("DoctorsController@waiting_patients")}}">Waiting
                                                    Patients</a>
                                            </li>
                                        @endif
                                        <li class="{{in_array($controller, ["CategoriesController"])?"active":""}}">
                                            <a href="{{URL::action("CategoriesController@selCategory")}}">Describe Your
                                                Case</a>
                                        </li>

                                        <li class="{{$action=='profile'?"active":""}}">
                                            <a href="{{URL::action("ProfileController@profile")}}"><span>Profile</span></a>
                                        </li>

                                        <li class="{{in_array($controller, ["LoginController"])?"active":""}}">
                                            <a href="{{URL::action("Auth\LoginController@logout")}}"><span>Logout</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!--RD Navbar Search-->
                        <div class="rd-navbar-search"><a data-rd-navbar-toggle=".rd-navbar-menu-wrap,.rd-navbar-search"
                                                         href="#" class="rd-navbar-search-toggle mdi"><span></span></a>
                            <form action="search-results.html" data-search-live="rd-search-results-live" method="GET"
                                  class="rd-navbar-search-form search-form-icon-right rd-search">
                                <div class="form-group">
                                    <label for="rd-navbar-search-form-input" class="form-label">Type and hit
                                        enter...</label>
                                    <input id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off"
                                           class="rd-navbar-search-form-input form-control form-control-gray-lightest"/>
                                </div>
                                <div id="rd-search-results-live" class="rd-search-results-live"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Modern Breadcrumbs-->
    <section class="breadcrumb-modern context-dark text-md-left">
        <div class="shell section-34 section-md-top-110 section-md-bottom-41">
            <h1>@yield('title')</h1>
            <ul class="list-inline list-inline-arrows p offset-top-34 offset-md-top-70">
                <li><a href="index.html" class="text-white">Home</a></li>
                <li><a href="#" class="text-white">Pages</a></li>
                <li>@yield('title')
                </li>
            </ul>
        </div>
    </section>
    <!-- Page Content-->
    <main class="page-content">
        @yield('content')
    </main>
    <!-- Page Footer-->
    <!-- Default footer-->
    <footer class="section-relative section-top-66 section-bottom-20 page-footer bg-bondi-blue context-dark">
        <div class="shell">
            <div class="range range-sm-center text-lg-left">
                <div class="cell-sm-8 cell-md-12">
                    <div class="range range-xs-center">
                        <div class="cell-xs-10 cell-md-4 text-left cell-md-push-3 inset-md-left-50">
                            <h6>Newsletter</h6>
                            <hr class="text-subline">
                            <p class="text-white-02">Enter your email address to receive up-to-date news and new patient
                                information.</p>
                            <div class="form-validation-subscribe">
                                <form data-form-output="form-output-global" data-form-type="subscribe" method="post"
                                      action="bat/rd-mailform.php" class="rd-mailform">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <input placeholder="Your e-mail..." type="email"
                                                   data-constraints="@Required @Email" name="email"
                                                   class="form-control text-gray-darker"><span class="input-group-btn">
                                  <button type="submit" class="btn btn-sm btn-primary">Subscribe</button></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="cell-xs-10 text-xs-left cell-md-4 cell-md-push-2 offset-top-50 offset-md-top-0">
                            <h6>contact us</h6>
                            <hr class="text-subline">
                            <div class="text-center text-lg-left">
                                <address class="contact-info reveal-sm-inline-block text-left">
                                    <div class="p unit unit-spacing-xxs unit-horizontal">
                                        <div class="unit-left"><span
                                                    class="icon icon-xxs mdi mdi-phone text-primary"></span></div>
                                        <div class="unit-body"><a href="callto:#"
                                                                  class="text-white">1-800-1234-567</a><span
                                                    class="text-white">, </span><a href="callto:#" class="text-white">1-800-3214-321</a>
                                        </div>
                                    </div>
                                    <div class="p unit unit-horizontal unit-spacing-xxs">
                                        <div class="unit-left"><span
                                                    class="icon icon-xxs mdi mdi-map-marker text-primary"></span></div>
                                        <div class="unit-body"><a href="#" class="text-white">2130 Fulton Street San
                                                Diego, CA 94117-1080 USA</a></div>
                                    </div>
                                    <div class="p unit unit-spacing-xxs unit-horizontal offset-top-16">
                                        <div class="unit-left"><span
                                                    class="icon icon-xxs mdi mdi-email-outline text-primary"></span>
                                        </div>
                                        <div class="unit-body"><a href="mailto:#"
                                                                  class="text-primary text-primary-hovered">info@demolink.org</a>
                                        </div>
                                    </div>
                                </address>
                            </div>
                        </div>
                        <div class="cell-xs-10 offset-top-66 cell-md-4 cell-md-push-1 offset-md-top-0">
                            <!-- Footer brand-->
                            <div class="footer-brand"><a href="index.html"><img width='206' height='63'
                                                                                class='img-responsive'
                                                                                src='{{asset('images/logo.png')}}'
                                                                                alt=''/></a></div>
                            <div class="offset-top-50 offset-md-top-90">
                                <ul class="list-inline">
                                    <li><a href="#"
                                           class="icon fa fa-facebook icon-xxs icon-circle icon-white-filled"></a></li>
                                    <li><a href="#"
                                           class="icon fa fa-twitter icon-xxs icon-circle icon-white-filled"></a></li>
                                    <li><a href="#"
                                           class="icon fa fa-google-plus icon-xxs icon-circle icon-white-filled"></a>
                                    </li>
                                    <li><a href="#" class="icon fa fa-rss icon-xxs icon-circle icon-white-filled"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="offset-top-50 offset-md-top-60">
            <hr class="hr bg-deep-cerulean">
        </div>
        <div class="shell offset-top-14">
            <p class="text-white-05 text-md-left">&copy; <span id="copyright-year"></span> All Rights Reserved Terms of
                Use <a href="privacy.html" class="text-white-05">Privacy Policy</a>
            </p>
        </div>
    </footer>
</div>
<!-- Global Mailform Output-->
<div id="form-output-global" class="snackbars"></div>
<!-- PhotoSwipe Gallery-->
<div tabindex="-1" role="dialog" aria-hidden="true" class="pswp">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button title="Close (Esc)" class="pswp__button pswp__button--close"></button>
                <button title="Share" class="pswp__button pswp__button--share"></button>
                <button title="Toggle fullscreen" class="pswp__button pswp__button--fs"></button>
                <button title="Zoom in/out" class="pswp__button pswp__button--zoom"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button title="Previous (arrow left)" class="pswp__button pswp__button--arrow--left"></button>
            <button title="Next (arrow right)" class="pswp__button pswp__button--arrow--right"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<!-- Java script-->
<script src="{{asset('js/core.min.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
</body>
</html>