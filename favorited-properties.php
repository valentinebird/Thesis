<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kedvencnek jelölt ingatlanjaim</title>
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
<?php include 'header.html'; ?>


<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Kedvencnek jelölt ingatlanjaim</h1>
        </div>
    </div>
</div>

<!-- Favorited properties start -->
<div class="favorited-properties content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <?php include 'profilemenu.php'; ?>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <!-- Heading -->
                <h3 class="heading-2">Favorited Properties</h3>
                <div class="my-properties">
                    <table class="table brd-none">
                        <thead>
                        <tr>
                            <th>Property</th>
                            <th></th>
                            <th class="hedin-div">Date</th>
                            <th><span class="hedin-div">Views</span></th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Modern Family Home</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 27,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">7.02.2018</td>
                            <td> <span class="hedin-div">421</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Beautiful Single Home</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 19,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">4.07.2018</td>
                            <td> <span class="hedin-div">365</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Masons Villas</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 19,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">9.03.2018</td>
                            <td> <span class="hedin-div">165</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Modern Family Home</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 27,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">7.02.2018</td>
                            <td> <span class="hedin-div">421</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Beautiful Single Home</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 19,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">4.07.2018</td>
                            <td> <span class="hedin-div">365</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <tr class="brd-none">
                            <td class="image">
                                <a href="properties-details.php"><img alt="properties-small" src="http://placehold.it/100x66" class="img-fluid"></a>
                            </td>
                            <td>
                                <div class="inner">
                                    <h5><a href="properties-details.php">Masons Villas</a></h5>
                                    <figure class="hedin-div"><i class="fa fa-map-marker"></i> 123 Kathal St. Tampa City</figure>
                                    <div class="price-month">$ 19,000</div>
                                </div>
                            </td>
                            <td class="hedin-div">9.03.2018</td>
                            <td> <span class="hedin-div">165</span></td>
                            <td class="actions">
                                <a href="#" class="edit"><i class="fa fa-pencil"></i>Edit</a>
                                <a href="#"><i class="delete fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
                    <h4>Contact Us</h4>
                    <ul class="contact-info">
                        <li>
                            360 Harvest St, North Subract, London. United States Of Amrica.
                        </li>
                        <li>
                            <a href="mailto:sales@hotelempire.com">info@themevessel.com</a>
                        </li>
                        <li>
                            <a href="tel:+55-417-634-7071">+1 347-465-0659</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Properties Types</h4>
                    <ul class="links">
                        <li>
                            <a>Apartment</a>
                        </li>
                        <li>
                            <a>Restaurant</a>
                        </li>
                        <li>
                            <a>My Houses</a>
                        </li>
                        <li>
                            <a>Villa & Condo</a>
                        </li>
                        <li>
                            <a>Family House</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                <div class="footer-item">
                    <h4>Quick Links</h4>
                    <ul class="links">
                        <li>
                            <a>About Us</a>
                        </li>
                        <li>
                            <a>Services</a>
                        </li>
                        <li>
                            <a>Properties Details</a>
                        </li>
                        <li>
                            <a>My Account</a>
                        </li>
                        <li>
                            <a> Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <h4>Subscribe</h4>
                    <div class="subscribe-box-2">
                        <form class="form-inline" action="#" method="GET">
                            <input type="text" class="form-control mb-sm-0" id="inlineFormInputName4" placeholder="Your Email">
                            <button type="submit" class="btn"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                    <ul class="social-list clearfix">
                        <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="google-bg"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" class="rss-bg"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#" class="linkedin-bg"><i class="fa fa-linkedin"></i></a></li>
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
                <p class="copy">© 2020 <a href="#">Theme Vessel.</a> Trademarks and brands are the property of their respective owners.</p>
            </div>
        </div>
    </div>
</div>

<!-- Full Page Search -->
<div id="full-page-search">
    <button type="button" class="close">×</button>
    <form action="index.php#">
        <input type="search" value="" placeholder="type keyword(s) here" />
        <button type="submit" class="btn btn-sm button-theme">Search</button>
    </form>
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