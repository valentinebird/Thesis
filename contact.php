<?php

session_start();
require "dbconfig.php";

$errors = [];
$result = [];

function check_if_POST_EXIST($key): bool
{
    return !empty($_POST[$key]);
}

function hasError($kulcs): bool
{
    global $errors;
    return in_array($kulcs, array_keys($errors));
}

function errorWrite($key) {
    global $errors;
    if (array_key_exists($key, $errors)) {
        echo $errors[$key];
    }
}
function stateHolder($key)
{
    global $errors;
    global $result;

    if (count($errors) > 0) {
        return $result[$key];
    } else {
        return "";
    }
}

$info_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (check_if_POST_EXIST("name")) {
        $result["name"] = $_POST["name"];
    } else {
        $errors["name"] = "Az név nincs kitöltve!";
    }

    if (!check_if_POST_EXIST("email") || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Érvényes e-mail cím megadása szükséges.';
    } else {
        $result["email"] = $_POST["email"];
    }

    if (check_if_POST_EXIST("subject")) {
        $result["subject"] = $_POST["subject"];
    } else {
        $errors["subject"] = "A tárgy nincs kitöltve!";
    }

    if (check_if_POST_EXIST("phone")) {
        $result["phone"] = $_POST["phone"];
    } else {
        $errors["phone"] = "A telefonszám nincs kitöltve!";
    }

    if (check_if_POST_EXIST("message")) {
        $result["message"] = $_POST["message"];
    } else {
        $errors["message"] = "Az üzenet nincs kitöltve!";
    }

    if (!$errors) {
        $to = 'info@madar-szakdolgozat.online';
        $subject = '=?UTF-8?B?' . base64_encode('Új üzenet ' . $result['name']) . '?=';
        $message = "A következő üzenetet kaptad \n\n";
        $message .= "Név: " . $result['name'] . "\n";
        $message .= "Email: " . $result['email'] . "\n";
        $message .= "Telefonszám: " . $result['phone'] . "\n";
        $message .= "Üzenet: " . $result['message'] . "\n";

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
        $headers .= 'From: ' . $result['email'] . "\r\n";
        $headers .= 'Reply-To: ' . $result['email'] . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $message, $headers)){
            $info_message .= "\n Az üzenet sikeresen elküldve!" . "\n";
        } else{
            $info_message .= "\n Hiba az üzenet elküldésekor!" . "\n";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kapcsolat</title>
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


<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container">
        <div class="page-name">
            <h1>Kapcsolat</h1>
        </div>
    </div>
</div>

<!-- Contact 2 start -->
<div class="contact-2 content-area-5">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1 class="mb-10">Kapcsolat</h1>
            <p>További ajánlakat az alábbi űrlap kitöltésével lehet kérni</p>
        </div>
        <div class="contact-info">
            <div class="row">
                <div class="col-md-3 col-sm-6 mrg-btn-50">
                    <i class="flaticon-location"></i>
                    <p>Az iroda címe</p>
                    <strong>Budapest</strong>
                </div>
                <div class="col-md-3 col-sm-6 mrg-btn-50">
                    <i class="flaticon-technology-1"></i>
                    <p>Telefon</p>
                    <strong>+36 123 456728</strong>
                </div>
                <div class="col-md-3 col-sm-6 mrg-btn-50">
                    <i class="flaticon-envelope"></i>
                    <p>E-mail</p>
                    <strong>info@madar-szakdolgozat.online</strong>
                </div>
                <div class="col-md-3 col-sm-6 mrg-btn-50">
                    <i class="flaticon-globe"></i>
                    <p>Web</p>
                    <strong>madar-szakdolgozat.online</strong>
                </div>
            </div>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            <p style="color: green" id="info_message"><?php echo $info_message ?></p>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group name">
                                <label for="name"></label>
                                <input type="text" id="name" name="name" class="form-control" value="<?= stateHolder('name') ?>" placeholder="Név">
                                <span style="color: red"><?php echo errorWrite('name') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group email">
                                <label for="email"></label>
                                <input type="email" id="email" name="email" class="form-control" value="<?= stateHolder('email') ?>" placeholder="E-mail">
                                <span style="color: red"><?php echo errorWrite('email') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group subject">
                                <label for="subject"></label>
                                <input type="text" id="subject" name="subject" class="form-control" value="<?= stateHolder('subject') ?>" placeholder="Tárgy">
                                <span style="color: red"><?php echo errorWrite('subject') ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group number">
                                <label for="phone"></label>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?= stateHolder('phone') ?>" placeholder="Telefonszám">
                                <span style="color: red"><?php echo errorWrite('phone') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group message">
                                <label for="message"></label>
                                <textarea class="form-control" id="message" name="message" placeholder="Üzenet"><?= stateHolder('message') ?></textarea>
                                <span style="color: red"><?php echo errorWrite('message') ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="send-btn text-center">
                                <button type="submit" class="btn btn-md button-theme">Üzenet elküldése</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="opening-hours">
                        <h3>Nyitvatartás</h3>
                        <ul class="list-style-none">
                            <li><strong>Hétfő</strong> <span> 10 - 16 </span></li>
                            <li><strong>Kedd </strong> <span> 8 - 16</span></li>
                            <li><strong>Szerda </strong> <span> 8 - 16 </span></li>
                            <li><strong>Csütörtök </strong> <span> 8 - 16 </span></li>
                            <li><strong>Péntek </strong> <span> 8 - 14</span></li>
                            <li><strong>Szombat </strong> <span> 10 - 14</span></li>
                            <li><strong>Vasárnap</strong> <span class="text-red"> Zárva</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
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
