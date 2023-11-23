<?php

session_start();
session_start();
require "dbconfig.php";

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
<?php

$sql = "SELECT * FROM AGENT;";
$result = $conn->query($sql);

?>

<!-- Top header start -->
<?php include 'header.html'; ?>
<!-- Top header end -->



<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Inhgatlanügynökeink</h1>
        </div>
    </div>
</div>

<!-- Our team 3 start -->
<div class="our-team-3 content-area">
    <div class="container">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <?php
                if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                <div class="team-2">
                    <div class="team-photo">
                        <img src="img/cube.gif" alt="agent-2" class="img-fluid">
                    </div>
                    <div class="team-details">
                        <h6><?php echo $row["work_title"]; ?></h6>
                        <h5><a href="agent-detail.php?id=<?php echo $row["id"]; ?>"><?php echo $row["real_name"]; ?></a></h5>

                        <div class="contact">
                            <p>
                                <a href="mailto:<?php echo $row["email"]; ?>"><i class="fa fa-envelope-o"></i><?php echo $row["email"]; ?></a>
                            </p>
                            <p>
                                <a href="<?php echo $row["phone"]; ?>"> <i class="fa fa-phone"></i><?php echo $row["phone"]; ?></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            } else {
                echo "<h1>Nincs Ingatlanugznok</h1>";
            } ?>

        </div>
    </div>
</div >


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