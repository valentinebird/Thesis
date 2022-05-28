<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Housy - Real Estate HTML5 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-submenu.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/leaflet.css" type="text/css">
    <link rel="stylesheet" href="css/map.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" type="text/css" href="fonts/linearicons/style.css">
    <link rel="stylesheet" type="text/css"  href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css"  href="css/dropzone.css">
    <link rel="stylesheet" type="text/css"  href="css/slick.css">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="css/skins/default.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CRoboto:300,400,500,700&display=swap">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="css/ie10-viewport-bug-workaround.css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="page_loader"></div>

<!-- Top header start -->
<header class="top-header top-header-bg none-992" id="top-header-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-5">
                <div class="list-inline">
                    <?php
                    if ($_SESSION['loggedin']) { ?>
                        <a href="logout.php" class="sign-in"><i class="fa fa-sign-out"></i>Kijelentkezés</a>
                        <a href="profile.php" class="sign-in"><i class="fa fa-trophy"></i>Profilom: <?print $_SESSION['name'] ?></a>

                        <?php
                        if($_SESSION['is_agent']){
                            ?>
                            <a href="submit-property.php" class="sign-in"><i class="fa fa-upload"></i>Új ingatlan feltöltése</a>
                            <?php
                        }
                        ?>
                        <?php

                    }else{
                        ?>
                        <i class="fa fa-trophy"></i>Jelentkezz be az oldal használatához!
                        <?php
                    }
                    ?>

                </div>

            </div>
            <div class="col-lg-6 col-md-4 col-sm-5">
                <ul class="top-social-media pull-right">
                    <?php  if (!$_SESSION['loggedin']) { ?>
                        <li>
                            <a href="login-as-agent.html" class="sign-in"><i class="fa fa-sign-in"></i> Bejelentkezés ingatlan ügynökként!</a>
                        </li>
                        <li>
                            <a href="login.html" class="sign-in"><i class="fa fa-sign-in"></i> Bejelentkezés</a>
                        </li>
                        <li>
                            <a href="signup.html" class="sign-in"><i class="fa fa-user"></i> Regisztráció</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Top header end -->

<!-- Main header start -->
<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav header-ml">
                    <li class="nav-item  active">
                        <a class="nav-link" href="index.php" id="navbarDropdownMenuLink">
                            Főoldal
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink3" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Ingatlanok
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="sale.php">Eladó</a></li>
                            <li><a class="dropdown-item" href="rent.php">Kiadó</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="agents.php" id="navbarDropdownMenuLink2">
                            Ügynökeink
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="contact.php" id="navbarDropdownMenuLink5">
                            Kapcsolat
                        </a>
                    </li>
                </ul>
                </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Agent Detail</h1>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><span>/</span>Agent Detail</li>
            </ul>
        </div>
    </div>
</div>

<!-- Agent page start -->
<div class="agent-page content-area">
    <div class="container">
        <!-- Heading -->
        <h1 class="heading-2">Agent Details</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="row team-4 team-6">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-pad ">
                        <div class="photo">
                            <img src="http://placehold.it/302x362" alt="avatar-4" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-pad align-self-center">
                        <div class="detail">
                            <h5>Creative Director</h5>
                            <h4>
                                <a href="#">John Pitarshon</a>
                            </h4>

                            <div class="contact">
                                <ul>
                                    <li>
                                        <span>Address:</span><a href="#"> 44 New Design Street,</a>
                                    </li>
                                    <li>
                                        <span>Email:</span><a href="mailto:info@themevessel.com"> info@themevessel.com</a>
                                    </li>
                                    <li>
                                        <span>Mobile:</span><a href="tel:+554XX-634-7071"> +55 4XX-634-7071</a>
                                    </li>
                                    <li>
                                        <span>Fax:</span><a href="#"> +0477 85X6 552</a>
                                    </li>
                                    <li>
                                        <span>Website:</span><a href="#"> www.themevesselcom</a>
                                    </li>
                                </ul>
                            </div>

                            <ul class="social-list clearfix">
                                <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" class="google-bg"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="agent-biography">
                    <h3 class="heading-2">Biography</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar. Donec a consectetur nulla. Nulla posuere sapien vitae lectus suscipit, et pulvinar nisi tincidunt. Aliquam erat volutpat. Curabitur convallis fringilla diam sed aliquam. Sed tempor iaculis massa faucibus feugiat. In fermentum facilisis massa, a consequat purus viverra a.</p>
                    <p>Ut euismod ultricies sollicitudin. Curabitur sed dapibus nulla. Nulla eget iaculis lectus. Mauris ac maximus neque. Nam in mauris quis libero sodales eleifend. Morbi varius, nulla sit amet rutrum elementum</p>
                    <p>Vestibulum vel mauris et odio lobortis laoreet eget eu magna. Proin mauris erat, luctus at nulla ut, lobortis mattis magna. Morbi a arcu lacus. Maecenas tristique velit vitae nisi consectetur, in mattis diam sodales. Mauris sagittis sem mattis justo bibendum, a eleifend dolor facilisis. Mauris nec pharetra tortor, ac aliquam felis. Nunc pretium erat sed quam consectetur fringilla. Aliquam ultricies nunc porta metus interdum mollis.</p>
                    <br>
                    <h3 class="heading-2">Recently Properties</h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="property-box">
                                <div class="property-thumbnail">
                                    <a href="properties-details.php" class="property-img">
                                        <div class="listing-badges">
                                            <span class="featured">Featured</span>
                                            <span class="listing-time">For Sale</span>
                                        </div>
                                        <div class="price-box">$24,000<small>/mo</small></div>
                                        <img class="d-block w-100" src="http://placehold.it/350x233" alt="properties">
                                    </a>
                                </div>
                                <div class="detail">
                                    <h1 class="title">
                                        <a href="properties-details.php">Modern Family Home</a>
                                    </h1>
                                    <div class="location">
                                        <a href="properties-details.php">
                                            <i class="fa fa-map-marker"></i>123 Kathal St. Tampa City
                                        </a>
                                    </div>
                                    <ul class="facilities-list clearfix">
                                        <li>
                                            <i class="flaticon-square"></i> 4800 sq ft
                                        </li>
                                        <li>
                                            <i class="flaticon-furniture"></i> 3 Beds
                                        </li>
                                        <li>
                                            <i class="flaticon-holidays"></i> 2 Baths
                                        </li>
                                        <li>
                                            <i class="flaticon-vehicle"></i> 1 Garage
                                        </li>
                                        <li>
                                            <i class="flaticon-window"></i> 3 Balcony
                                        </li>
                                        <li>
                                            <i class="flaticon-monitor"></i> TV
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer clearfix">
                                    <div class="pull-left days">
                                        <a><i class="fa fa-user"></i> Jhon Doe</a>
                                    </div>
                                    <div class="pull-right">
                                        <a><i class="flaticon-time"></i> 5 Days ago</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="property-box">
                                <div class="property-thumbnail">
                                    <a href="properties-details.php" class="property-img">
                                        <div class="listing-badges">
                                            <span class="featured">Featured</span>
                                            <span class="listing-time">For Sale</span>
                                        </div>
                                        <div class="price-box">$24,000<small>/mo</small></div>
                                        <img class="d-block w-100" src="http://placehold.it/350x233" alt="properties">
                                    </a>
                                </div>
                                <div class="detail">
                                    <h1 class="title">
                                        <a href="properties-details.php">Relaxing Apartment</a>
                                    </h1>
                                    <div class="location">
                                        <a href="properties-details.php">
                                            <i class="fa fa-map-marker"></i>123 Kathal St. Tampa City
                                        </a>
                                    </div>
                                    <ul class="facilities-list clearfix">
                                        <li>
                                            <i class="flaticon-square"></i> 4800 sq ft
                                        </li>
                                        <li>
                                            <i class="flaticon-furniture"></i> 3 Beds
                                        </li>
                                        <li>
                                            <i class="flaticon-holidays"></i> 2 Baths
                                        </li>
                                        <li>
                                            <i class="flaticon-vehicle"></i> 1 Garage
                                        </li>
                                        <li>
                                            <i class="flaticon-window"></i> 3 Balcony
                                        </li>
                                        <li>
                                            <i class="flaticon-monitor"></i> TV
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer clearfix">
                                    <div class="pull-left days">
                                        <a><i class="fa fa-user"></i> Jhon Doe</a>
                                    </div>
                                    <div class="pull-right">
                                        <a><i class="flaticon-time"></i> 5 Days ago</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar-right">
                    <!-- Contact 1 start -->
                    <div class="contact-2 widget reviews">
                        <h3 class="sidebar-title">Reviews</h3>
                        <div class="s-border"></div>
                        <div class="m-border"></div>
                        <form action="#" method="GET" enctype="multipart/form-data">
                            <div class="rowo">
                                <div class="form-group name">
                                    <input type="text" name="name" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group email">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group number">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                                </div>
                                <div class="form-group message">
                                    <textarea class="form-control" name="message" placeholder="Write message"></textarea>
                                </div>
                                <div class="send-btn">
                                    <button type="submit" class="btn btn-md button-theme btn-block">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Latest reviews Start -->
                    <div class="widget latest-reviews">
                        <h3 class="sidebar-title">Reviews</h3>
                        <div class="s-border"></div>
                        <div class="m-border"></div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="http://placehold.it/50x50" alt="avatar-1">
                                </a>
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading"><a href="#">Emma Connor</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiamrisus tortor, accumsan</p>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="http://placehold.it/50x50" alt="avatar-2">
                                </a>
                            </div>
                            <div class="media-body">
                                <h3 class="media-heading"><a href="#">Martin Smith</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiamrisus tortor, accumsan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer start -->
<footer class="footer">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Kapcsolat</h4>
                    <ul class="contact-info">
                        <li>
                            2092 Budakeszi Erkel Ferenc utca 57.
                        </li>
                        <li>
                            <a href="mailto:info@madar-szakdolgozat.online.">info@madar-szakdolgozat.online</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">

            </div>

        </div>
    </div>
</footer>

<!-- Sub footer start -->
<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <p class="copy">© 2022 Ingatlan nyilvántartó portál, webes környezetben.</p>
            </div>
        </div>
    </div>
</div>



<script src="js/jquery-2.2.0.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-submenu.js"></script>
<script src="js/rangeslider.js"></script>
<script src="js/jquery.mb.YTPlayer.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.scrollUp.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/leaflet.js"></script>
<script src="js/leaflet-providers.js"></script>
<script src="js/leaflet.markercluster.js"></script>
<script src="js/dropzone.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.filterizr.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/jquery.countdown.js"></script>
<script src="js/maps.js"></script>
<script src="js/app.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>