<?php
session_start();
require "dbconfig.php";
require "profiledata.php";
if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profilom</title>
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
            <h1>Profilom</h1>
        </div>
    </div>
</div>

<!-- My profile start -->
<div class="my-profile content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <?php include 'profilemenu.php'; ?>
            </div>
            <?php if ($_SESSION['is_agent']) { ?>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <!-- My address start-->
                    <div class="my-address">
                        <h3 class="heading-2">A fiókom</h3>
                        <p id="profile_change_message" name="profile_change_message"></p>
                        <form id="changeprofiledata" method="POST">
                            <div class="form-group">
                                <label>Felhasználó név: (Nem változtatható)</label>
                                <br>
                                <label><?php echo $username; ?></label>
                            </div>
                            <div class="form-group">
                                <label>Név: </label>
                                <input type="text" class="input-text" id="real_name" name="real_name" value="<?php echo $real_name; ?>">
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" class="input-text" id="email" name="email" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-group">
                                <label>Telefon</label>
                                <input type="text" class="input-text" id="phone" name="phone" value="<?php echo $phone; ?>">
                            </div>
                            <div class="form-group">
                                <label>Munkakör</label>
                                <input type="text" class="input-text" id="work_title" name="work_title" value="<?php echo $work_title; ?>">
                            </div>
                            <div class="form-group">
                                <label>Leírásom:</label>
                                <textarea class="input-text" id="description" name="description" ><?php echo $description; ?></textarea>
                            </div>
                            <a type="submit" id="saveProfileButton" class="btn btn-md button-theme">Új adatok mentése</a>
                        </form>
                    </div>
                    <!-- My address end -->
                </div>
            <?php } else { ?>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <!-- My address start-->
                    <div class="my-address">
                        <h3 class="heading-2">A fiókom</h3>
                        <p id="profile_change_message" name="profile_change_message"></p>
                         <form id="changeprofiledata" method="POST">
                            <div class="form-group">
                                <label>Felhasználó név (Nem változtatható): </label>
                                <br>
                                <label><?php echo $username; ?> </label>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="input-text" id="email" name="email" value="<?php echo $email; ?>">
                            </div>
                            <a  type="submit" id="saveProfileButton"  class="btn btn-md button-theme">Új adatok mentése</a>
                        </form>
                    </div>
                    <!-- My address end -->
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<?php include 'footer.html'; ?>

<script>

        $(document).ready(function() {
        // Use a class or a different ID if you have multiple save buttons
        $("#saveProfileButton").click(function(event) {
            event.preventDefault();

            let dataToSend;

            if ('<?php echo $_SESSION['is_agent']; ?>' == '1') {
                // Agent's data
                dataToSend = {
                    real_name: $("#real_name").val(),
                    email: $("#email").val(),
                    phone: $("#phone").val(),
                    work_title: $("#work_title").val(),
                    description: $("#description").val()
                };
            } else {
                // User's data
                dataToSend = {
                    email: $("#email").val()
                };
            }
            console.log(dataToSend);
            $.ajax({
                url: 'update_profile.php',
                type: 'post',
                data: dataToSend,
                success: function(response) {
                    $("#profile_change_message").html(response);
                   console.log(response);
                },
                error: function(xhr, status, error) {
                    $("#profile_change_message").html("Error: " + status + " " + error);
                    console.log("Error: " + status + " " + error);
                }
            });
        });
    });


</script>

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