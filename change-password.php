<?php
session_start();
require "dbconfig.php";
global $con;
require "profiledata.php";

if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page or show an error
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Jelszó változatás</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Jelszó változatás</h1>
        </div>
    </div>
</div>

<!-- Change password start -->
<div class="change-password content-area-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <!-- Avatar start -->
                <?php include 'profilemenu.php'; ?>
                <!-- My account box end -->
            </div>
            <div class="col-lg-8 col-md-12">
                <!-- My address start -->
                <div class="my-address">
                    <h3 class="heading-2">Jelszó változtatás</h3>
                    <br>
                    <p id="message" name="message"></p>
                    <br>
                    <form id="changePasswordForm" method="POST">
                        <div class="form-group">
                            <label>Jelenlegi jelszó</label>
                            <input type="password" class="input-text" id="current_password" name="current_password"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Új jelszó</label>
                            <input type="password" class="input-text" id="new_password" name="new_password"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Új jelszó ismét</label>
                            <input type="password" class="input-text" id="confirm_new_password" name="confirm_new_password" placeholder="">

                        </div>
                        <button type="submit" id="changePasswordButton" class="btn btn-md button-theme">Jelszó
                            változtatás!
                        </button>
                    </form>
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

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>

<script>
    $(document).ready(function(){
        $("#changePasswordButton").click(function(){
            event.preventDefault();

            let current_password = $("#current_password").val() == undefined ? '' : $("#current_password").val().trim();
            let new_password = $("#new_password").val() == undefined ? '' : $("#new_password").val().trim();
            let confirm_new_password = $("#confirm_new_password").val() == undefined ? '' : $("#confirm_new_password").val().trim();

            $.ajax({
                url: 'passwordchanger.php',
                type: 'post',
                data: {current_password: current_password, new_password: new_password, confirm_new_password: confirm_new_password},
                success: function (response) {
                    if (response === '1') {
                        console.log('Response:', response);
                        //$("#message").html("Sikeres jelszó változtatás!");
                        $("#message").html(response);
                    } else {
                        console.log('Response:', response);
                        $("#message").html(response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText);
                }

            });
        });
    });
</script>

</body>
</html>