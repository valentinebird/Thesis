<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
session_start();
require "dbconfig.php";
global $con;
global $row;

// Check connection

$agent_id = $_GET['id'] ?? die('Agent ID not specified.');
$agent_id = (int)$agent_id; // Casting to int is a good practice for IDs

$stmt = $con->prepare("SELECT * FROM AGENT WHERE id = ?");
$stmt->bind_param("i", $agent_id);
$stmt->execute();

// Instead of get_result, use bind_result to fetch the data
$meta = $stmt->result_metadata();
$parameters = [];
while ($field = $meta->fetch_field()) {
    $parameters[] = &$row[$field->name];
}

call_user_func_array([$stmt, 'bind_result'], $parameters);

?>


<!DOCTYPE html>
<html lang="zxx">
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
<?php include 'header.html'; ?>
<!-- Top header end -->

<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Ingatlanügynök adatlap</h1>
        </div>
    </div>
</div>

<!-- Agent page start -->
<div class="agent-page content-area">
    <div class="container">
        <!-- Heading -->
        <?php
        if ($stmt->fetch()) {
        ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="row team-4 team-6">
                    <div class="col-xl-7 col-lg-7 col-md-7 col-pad align-self-center">
                        <div class="detail">
                            <h4><?php echo $row["real_name"]; ?></h4>
                            <h5><?php echo $row["work_title"]; ?></h5>
                            <div class="contact">
                                <ul>
                                    <li>
                                        <span>Email:</span><a
                                                href="mailto:<?php echo $row['email']; ?>"> <?php echo $row["email"]; ?></a>
                                    </li>
                                    <li>
                                        <span>Mobile:</span><a
                                                href="tel:<?php echo $row["phone"]; ?>"> <?php echo $row["phone"]; ?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="agent-biography">
                    <h3 class="heading-2">Bemutatkozás</h3>
                    <p><?php echo $row["description"]; ?></p>
                    <br>
                    <?php
                            }
                    else {
                        if ($stmt->errno) {
                            die("Fetch failed: " . $stmt->error);
                        } else {
                            echo "<h1>Nincs ilyen ingatlanügynök!</h1>";
                        }
                    }
                    $stmt->close();
                    $con->close();
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>

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