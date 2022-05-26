<?php

session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Ingatlanügynökeink</title>
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
                        <a href="index.php" class="sign-in"><i class="fa fa-trophy"></i>Üdvözlünk <?print $_SESSION['name'] ?></a>

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
                    <li>
                        <a href="login-as-agent.html" class="sign-in"><i class="fa fa-sign-in"></i> Bejelentkezés ingatlan ügynökként!</a>
                    </li>
                    <li>
                        <a href="login.html" class="sign-in"><i class="fa fa-sign-in"></i> Bejelentkezés</a>
                    </li>
                    <li>
                        <a href="signup.html" class="sign-in"><i class="fa fa-user"></i> Regisztráció</a>
                    </li>
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
            <a class="navbar-brand logos" href="index.php">
                <img src="img/logos/logo.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ingatlanok
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="sale.php">Eladó</a></li>
                            <li><a class="dropdown-item" href="rent.php">Kiadó</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="agents.php" id="navbarDropdownMenuLink2"   >
                            Ügynökeink
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="contact.html" id="navbarDropdownMenuLink5">
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
            <h1>Agent Grid</h1>
            <ul>
                <li><a href="index.php">Index</a></li>
                <li><span>/</span>Agent Grid</li>
            </ul>
        </div>
    </div>
</div>

<!-- Our team 3 start -->
<div class="our-team-3 content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="option-bar">
                    <div class="float-left">
                        <h4>
                            <span class="heading-icon">
                                <i class="fa fa-th-large"></i>
                            </span>
                            <span class="title-name">Agent Grid</span>
                        </h4>
                    </div>
                    <div class="float-right cod-pad">
                        <div class="sorting-options">
                            <select class="sorting">
                                <option>New To Old</option>
                                <option>Old To New</option>
                                <option>Properties (High To Low)</option>
                                <option>Properties (Low To High)</option>
                            </select>
                            <a href="agent-list-2.html" class="change-view-btn"><i class="fa fa-th-list"></i></a>
                            <a href="agent-grid-2.html" class="change-view-btn active-view-btn"><i class="fa fa-th-large"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Office Manager</h6>
                        <h5><a href="agent-detail.php">Maria Blank</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Creative Director</h6>
                        <h5><a href="agent-detail.php">John Pitarshon</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Support Manager</h6>
                        <h5><a href="agent-detail.php">Karen Paran</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Support Manager</h6>
                        <h5><a href="agent-detail.php">Karen Paran</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Office Manager</h6>
                        <h5><a href="agent-detail.php">Maria Blank</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Creative Director</h6>
                        <h5><a href="agent-detail.php">John Pitarshon</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Creative Director</h6>
                        <h5><a href="agent-detail.php">John Pitarshon</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Support Manager</h6>
                        <h5><a href="agent-detail.php">Karen Paran</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6>Office Manager</h6>
                        <h5><a href="agent-detail.php">Maria Blank</a></h5>
                        <div class="contact">
                            <p>
                                <a href="mailto:info@themevessel.com"><i class="fa fa-envelope-o"></i>info@themevessel.com</a>
                            </p>
                            <p>
                                <a href="tel:+554XX-634-7071"> <i class="fa fa-phone"></i>+55 4XX-634-7071</a>
                            </p>
                            <p>
                                <a href="#"><i class="fa fa-skype"></i>sales.carshop</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div >

<!-- Footer start -->
<footer class="footer">
    <div class="container footer-inner">
        <div class="row">
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Kapcsolat</h4>
                    <ul class="contact-info">
                        <li>
                            360 Harvest St, North Subract, London. United States Of Amrica.
                        </li>
                        <li>
                            <a href="mailto:sales@hotelempire.com">info@madar-szakdolgozat.online</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Gyorlikek </h4>
                    <ul class="links">
                        <li>
                            <a>Rólunk</a>
                        </li>
                        <li>
                            <a>Szolgáltatások</a>
                        </li>

                        <li>
                            <a> Adatkezelés</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- Sub footer start -->
<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <p class="copy">© 2022  Ingatlan nyilvántartó portál, webes környezetben.</p>
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