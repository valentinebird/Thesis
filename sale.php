<?php
session_start();
require "dbconfig.php";
$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$sql = "SELECT id,username, email, reg_date FROM USER;";
$sql = "SELECT * FROM PROPERTY WHERE is_for_sale = 1;";
$result = $conn->query($sql);


//$conn->close();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Eladó ingatlanok listája</title>
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
    <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="css/dropzone.css">
    <link rel="stylesheet" type="text/css" href="css/slick.css">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="css/skins/default.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700%7CRoboto:300,400,500,700&display=swap">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="css/ie10-viewport-bug-workaround.css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
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
            <h1>Eladó ingatlanjaink listája</h1>
        </div>
    </div>
</div>

<!-- Properties section body start -->
<div class="properties-section content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <!-- Option bar start -->
                <div class="option-bar">
                    <div class="float-left">
                        <h4>
                            <span class="heading-icon">
                                <i class="fa fa-th-list"></i>
                            </span>
                            <span class="title-name">Rendezési sorrend</span>
                        </h4>
                    </div>
                    <div class="float-right cod-pad">
                        <div class="sorting-options">
                            <select class="sorting">
                                <option>Legújabb elöl</option>
                                <option>Legrégebbi elöl</option>
                                <option>Ár (Legdrágább elöl)</option>
                                <option>Ár (Legolcsóbb elöl)</option>
                            </select>

                        </div>
                    </div>
                </div>

                <!-- Property box 2 start -->
                <?php
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="property-box-2">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-pad">
                                    <a href="properties-details.php?id=<?php echo $row['id']; ?>" class="property-img">
                                        <img src="img/cube.gif" alt="properties" class="img-fluid">
                                        <div class="listing-badges">
                                            <span class="featured">Kiemelt</span>
                                            <span class="listing-time">Eladó</span>
                                        </div>
                                        <div class="price-box"><?php echo $row["price"]; ?><small>/ Ft</small></div>
                                    </a>
                                </div>
                                <div class="col-lg-7 col-md-7 col-pad">
                                    <div class="detail">
                                        <h3 class="title">
                                            <a href="properties-details.php?id=<?php echo $row['id']; ?>"><?php echo $row["property_name"]; ?></a>
                                        </h3>
                                        <p class="location">
                                            <i class="flaticon-location"></i> <?php echo $row["city"]; ?>
                                        </p>
                                        <ul class="facilities-list clearfix">
                                            <li>
                                                <i class="flaticon-furniture"></i>
                                                <span> <?php echo $row["rooms"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span><?php echo $row["bath_rooms"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="flaticon-square"></i>
                                                <span><?php echo $row["size"]; ?>m&#178;</span>
                                            </li>
                                            <li>
                                                <i class="flaticon-technology-3"></i>
                                                <span><?php echo $row["type"]; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer clearfix">
                                        <div class="pull-left days">
                                            <a><i class="fa fa-user"></i> <?php echo $row["agent_id"]; ?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a><i class="flaticon-time"></i> <?php echo $row["upload_date"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <h1>No results in DB </h1>
                <?php } ?>


                <!--
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Park avenue</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Modern Family Home</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Relaxing Apartment</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Park avenue</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Modern Family Home</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Relaxing Apartment</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Park avenue</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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
                <div class="property-box-2">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-pad">
                            <a href="properties-details.html" class="property-img">
                                <img src="img/cube.gif" alt="properties" class="img-fluid">
                                <div class="listing-badges">
                                    <span class="featured">Featured</span>
                                    <span class="listing-time">For Sale</span>
                                </div>
                                <div class="price-box">$24,000<small>/mo</small></div>
                            </a>
                        </div>
                        <div class="col-lg-7 col-md-7 col-pad">
                            <div class="detail">
                                <h3 class="title">
                                    <a href="properties-details.html">Modern Family Home</a>
                                </h3>
                                <p class="location">
                                    <a href="properties-details.html">
                                        <i class="flaticon-location"></i>20-21 Kathal St. Tampa City, FL
                                    </a>
                                </p>
                                <ul class="facilities-list clearfix">
                                    <li>
                                        <i class="flaticon-furniture"></i>
                                        <span>3 Beds</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-holidays"></i>
                                        <span>1 Baths</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-square"></i>
                                        <span>4800 sq ft</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-vehicle"></i>
                                        <span>1 Garage</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-monitor"></i>
                                        <span>1 TV</span>
                                    </li>
                                    <li>
                                        <i class="flaticon-window"></i>
                                        <span>3 Balcony</span>
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

                <div class="pagination-box hidden-mb-45 text-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fa fa-angle-left"></i></a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#"><i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                  -->
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="sidebar-right">
                    <!-- Advanced search start -->
                    <?php
                    function select_DISTINCT_into_asoc_array($what_to_select)
                    {
                        $assoc_array = [];
                        global $conn;
                        $saq = "type";
                        $sql_for_search = "SELECT DISTINCT  $what_to_select FROM PROPERTY WHERE is_for_sale = 1 ORDER BY $what_to_select ASC;";
                        $result_for_search = $conn->query($sql_for_search);


                        if ($result_for_search->num_rows > 0) {
                            while ($row_for_search = $result_for_search->fetch_assoc()) {

                                //$assoc_array +=  $row_for_search[$what_to_select];
                                //$assoc_array[] +=  $row_for_search[$what_to_select];
                                echo "<option>" . $row_for_search[$what_to_select];
                                "</option>";
                            }
                        }
                        return $assoc_array;
                    }

                    ?>


                    <div class="sidebar widget advanced-search">
                        <h3 class="sidebar-title">Részletes keresés</h3>
                        <div class="s-border"></div>
                        <div class="m-border"></div>
                        <form method="GET">
                            <div class="form-group">
                                <select class="selectpicker search-fields" name="property-sdtatus">
                                    <option>Kiadó és eladó</option>
                                    <option value="sale">Eladó</option>
                                    <option value="rent">Kiadó</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker search-fields" name="property-type">
                                    <option>Típus</option>
                                    <?php select_DISTINCT_into_asoc_array("type"); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="selectpicker search-fields" name="location">
                                    <option>Hely</option>
                                    <?php select_DISTINCT_into_asoc_array("city"); ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="bedrooms">
                                            <option>Szobák száma</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields" name="bathroom">
                                            <option>Fürdő szobák száma</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <select class="selectpicker search-fields" name="balcony">
                                    <option>Állapot</option>
                                    <?php select_DISTINCT_into_asoc_array("property_condition"); ?>
                                </select>

                            </div>
                            <div class="range-slider">
                                <label>Méret</label>
                                <div data-min="0" data-max="1000" data-min-name="min_area" data-max-name="max_area"
                                     data-unit="m&#178;" class="range-slider-ui ui-slider" aria-disabled="false"></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="range-slider">
                                <label>Ár</label>
                                <div data-min="0" data-max="500000" data-min-name="min_price" data-max-name="max_price"
                                     data-unit="Forint" class="range-slider-ui ui-slider" aria-disabled="false"></div>
                                <div class="clearfix"></div>
                            </div>
                            <a class="show-more-options" data-toggle="collapse" data-target="#options-content">
                                <i class="fa fa-plus-circle"></i> Egyéb opciók
                            </a>
                            <div id="options-content" class="collapse">
                                <label class="margin-t-10">Tulajdonságok</label>
                                <div class="s-border"></div>
                                <div class="m-border"></div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox1" type="checkbox">
                                    <label for="checkbox1">
                                        Free Parking
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox2" type="checkbox">
                                    <label for="checkbox2">
                                        Air Condition
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox3" type="checkbox">
                                    <label for="checkbox3">
                                        Places to seat
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox4" type="checkbox">
                                    <label for="checkbox4">
                                        Swimming Pool
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox5" type="checkbox">
                                    <label for="checkbox5">
                                        Laundry Room
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox6" type="checkbox">
                                    <label for="checkbox6">
                                        Window Covering
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox7" type="checkbox">
                                    <label for="checkbox7">
                                        Central Heating
                                    </label>
                                </div>
                                <div class="checkbox checkbox-theme checkbox-circle">
                                    <input id="checkbox8" type="checkbox">
                                    <label for="checkbox8">
                                        Alarm
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <button class="search-button">Keresés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer start -->
<?php include 'footer.html'; ?>


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

</body>
</html>