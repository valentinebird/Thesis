<?php

session_start();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Ingatlan nyilvántartó portál, webes környezetben</title>
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
                    }else{
                        ?>
                        <a href="index.php" class="sign-in"><i class="fa fa-trophy"></i>Jelentkezz be az oldal használatához!</a>
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
<header class="main-header mh-3 header-transparent">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logos" href="index.html">

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item  active">
                        <a class="nav-link" href="index.html" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Főoldal
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"  id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ingatlanok
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="sale.html">Eladó</a></li>
                        <li><a class="dropdown-item" href="rent.html">Kiadó</a></li>
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
            </div>
        </nav>
    </div>
</header>

<!-- Banner start -->
<div class="banner banner_video_bg" id="banner">
    <div class="pattern-overlay">
        <a id="bgndVideo" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=5e0LxrLSzok',containment:'.banner_video_bg', quality:'large', autoPlay:true, mute:true, opacity:1}"></a>    </div>
    <div id="bannerCarousole" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item banner-max-height item-bg active">
                <div class="carousel-caption banner-slider-inner d-flex h-100 w-100 text-center">
                    <div class="carousel-content container">
                        <div class="text-center banner-info">
                            <h3>Segítünk megtalálni az Önnek megfelelő ingatlant</h3>
                            <div class="search-info">
                                <div class="inline-search-area">
                                    <div class="row">
                                        <div class="col-lg-2 col-sm-6 col-12 search-col">
                                            <select class="selectpicker search-fields" name="property-status">
                                                <option>Bérlés időtartama</option>
                                                <option>Eladó</option>
                                                <option>Kiadó</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 search-col middle-col-1">
                                            <select class="selectpicker search-fields" name="property-types">
                                                <option>Az ingatlan típusa</option>
                                                <option>Aparment</option>
                                                <option>Ház</option>
                                                <option>Irodaház</option>
                                                <option>Lakás</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 search-col middle-col-2">
                                            <select class="selectpicker search-fields" name="Location">
                                                <option>Helye</option>
                                                <option>London</option>
                                                <option>Los Angeles</option>
                                                <option>New York</option>
                                                <option>Budapest</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 search-col middle-col-1">
                                            <select class="selectpicker search-fields" name="Bedrooms">
                                                <option>Hálószoák száma</option>
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 search-col middle-col-2">
                                            <select class="selectpicker search-fields" name="Bathrooms">
                                                <option>Fürdőszobák száma</option>
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-sm-6 col-12 search-col">
                                            <button class="btn button-theme btn-search btn-block">
                                                <i class="fa fa-search"></i> Kersés
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured properties start -->
<div class="featured-properties content-area">
    <div class="container">
        <!-- Main title -->
        <div class="main-title mt2">
            <h1>Legújabb hirdetésink</h1>
            <p></p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="property-box-4 category">
                    <div class="category_bg_box property-photo">
                        <div class="category-overlay">
                            <div class="category-content">
                                <h3>
                                    <a href="properties-details.html">Park Avenue</a>
                                </h3>
                                <ul>
                                    <li>
                                        <i class="flaticon-square"></i> 4800 sq ft
                                    </li>
                                    <li>
                                        <i class="flaticon-furniture"></i>3 Beds
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>2 Bath
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>1 Garage
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>3 Balcony
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>Tv
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="property-box-4 category">
                    <div class="category_bg_box property-photo-2">
                        <div class="category-overlay">
                            <div class="category-content">
                                <h3>
                                    <a href="properties-details.html">Modern Family Home</a>
                                </h3>
                                <ul>
                                    <li>
                                        <i class="flaticon-square"></i> 4800 sq ft
                                    </li>
                                    <li>
                                        <i class="flaticon-furniture"></i>3 Beds
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>2 Bath
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>1 Garage
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>3 Balcony
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>Tv
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="property-box-4 category">
                    <div class="category_bg_box property-photo-3">
                        <div class="category-overlay">
                            <div class="category-content">
                                <h3>
                                    <a href="properties-details.html">Relaxing Apartment</a>
                                </h3>
                                <ul>
                                    <li>
                                        <i class="flaticon-square"></i> 4800 sq ft
                                    </li>
                                    <li>
                                        <i class="flaticon-furniture"></i>3 Beds
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>2 Bath
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>1 Garage
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>3 Balcony
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>Tv
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Services 3 start -->
<div class="services-3 content-area-5 bg-grea-3">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>Miért válassz minket?</h1>
            <p>Az oldalunkat profi ingatlanközvetítők működtetik akik a legjobb tanácsot tuják adni.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service-info-2">
                    <div class="icon">
                        <i class="flaticon-people-1"></i>
                    </div>
                    <div class="service-detail">
                        <h3>
                           Profi ingatlanügynökök
                        </h3>
                        <p>Ügynökeink többéves tapasztalattal rendelkeznek, és napközben folyamatosan rendelkezésre állnak.</p>
                        <h4>01</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service-info-2">
                    <div class="icon">
                        <i class="flaticon-apartment"></i>
                    </div>
                    <div class="service-detail">
                        <h3>
                            Ingatlankeresés fiatal pároknak
                        </h3>
                        <p>Ingatlanirodánk széles körben nyújt segítséget fiatal pároknak, akár egy közös házba vagy albéletbe való összeköltözéskor.</p>
                        <h4>02</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service-info-2">
                    <div class="icon">
                        <i class="flaticon-coins"></i>
                    </div>
                    <div class="service-detail">
                        <h3>
                           Pénzkímélő ingatlanok egyetemistáknak
                        </h3>
                        <p>Amennyiben egyetemistaként albérletet keresel, akár egyedül akár társaiddal, számíthatsz a segítségünkre.</p>
                        <h4>03</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Categories strat -->
<div class="categories content-area-8 bg-grea-3">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1>A legnépszerűbb helyek</h1>
            <p>Ingatlanirodánk az egész világon elérhető, helyek amiket a legtöbb felhasználó keres</p>
        </div>
        <div class="row wow">
            <div class="col-lg-5 col-md-12 col-sm-12 col-pad d-none d-xl-block d-lg-block">
                <div class="category">
                    <div class="category_bg_box category_long_bg cat-4-bg">
                        <div class="category-overlay">
                            <div class="category-content">
                                <h3 class="category-title">
                                    <a href="#">Budapest</a>
                                </h3>
                                <a href="#" class="category-subtitle">X Darab ingatlan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-pad">
                        <div class="category">
                            <div class="category_bg_box cat-3-bg">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">Budapest</a>
                                        </h3>
                                        <a href="#" class="category-subtitle">X darab ingatlan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box cat-1-bg">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">London</a>
                                        </h3>
                                        <a href="#" class="category-subtitle">X Darab ingatlan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-pad">
                        <div class="category">
                            <div class="category_bg_box cat-2-bg">
                                <div class="category-overlay">
                                    <div class="category-content">
                                        <h3 class="category-title">
                                            <a href="#">San Francisco</a>
                                        </h3>
                                        <a href="#" class="category-subtitle">X Darab ingatlan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Counters strat -->
<div class="counters">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="media counter-box">
                    <div class="media-left">
                        <i class="flaticon-tag"></i>
                    </div>
                    <div class="media-body">
                        <h1 class="counter">999</h1>
                        <p>Eladó ingatlanjaink száma</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="media counter-box">
                    <div class="media-left">
                        <i class="flaticon-business"></i>
                    </div>
                    <div class="media-body">
                        <h1 class="counter">999</h1>
                        <p>Kiadó ingatlanjaink száma</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="media counter-box">
                    <div class="media-left">
                        <i class="flaticon-people"></i>
                    </div>
                    <div class="media-body">
                        <h1 class="counter">999</h1>
                        <p>Ügynökeink száma</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="media counter-box">
                    <div class="media-left">
                        <i class="flaticon-people-1"></i>
                    </div>
                    <div class="media-body">
                        <h1 class="counter">999</h1>
                        <p>Elégedett felhasználó</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Testimonial start -->
<div class="testimonial">
    <div class="container">
        <div class="row">
            <div class="offset-lg-2 col-lg-8">
                <div class="testimonial-inner">
                    <header class="testimonia-header">
                        <h1>Rólunk írták</h1>
                    </header>
                    <div id="carouselExampleIndicators7" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <p class="lead">
                                            A Housy ingatlan iroda segített nekem otthot találni.
                                        </p>
                                        <ul class="rating">
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star-half-full"></i>
                                            </li>

                                        </ul>
                                        <div class="author-name">Emma Connor</div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">

                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <p class="lead">
                                            Gyors jó és megbízható.
                                        </p>
                                        <ul class="rating">
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star-half-full"></i>
                                            </li>
                                        </ul>
                                        <div class="author-name">Martin Smith</div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="row">

                                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                        <p class="lead">
                                           Ennyire könnyen még soha nem találtam ingatlant.
                                        </p>
                                        <ul class="rating">
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa fa-star-half-full"></i>
                                            </li>
                                        </ul>
                                        <div class="author-name">John Antony</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators7" role="button" data-slide="prev">
                            <span class="slider-mover-left" aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                            </span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators7" role="button" data-slide="next">
                            <span class="slider-mover-right" aria-hidden="true">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </a>
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
                            360 Harvest St, North Subract, London. United States Of Amrica.
                        </li>
                        <li>
                            <a href="mailto:sales@hotelempire.com">info@madar-szakdolgozat.online</a>
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

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug
<script src="js/ie10-viewport-bug-workaround.js"></script>
-->
</body>
</html>