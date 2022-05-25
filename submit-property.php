<?php
session_start();

function checkifPOST_EXIST($key)
{
    if (isset( $_POST[$key]) && strlen(trim($_POST[$key]) > 0)) {
        return true;
    } else {
        return false;

    }
}



require "dbconfig.php";

$errors = [];
$result = [];

function hibasE($kulcs)
{
    global $errors;
    return in_array($kulcs, array_keys($errors));
}

function hibaKiir($key)
{
    global $errors;
     if ($errors){
         echo $errors[$key];
     }
}

function allapottarto($kulcs)
{
    global $errors;
    global $result;
    return count($errors) > 0 || hibasE($kulcs) ? '' : $result[$kulcs];
}


$msg = "";

// If upload button is clicked ...

if (isset($_POST['upload'])) {
    //Check the values is okay!!!

    //actiual


    $colors = ["black", "grey", "multi", "white"];

    if (checkifPOST_EXIST("property_name")) {
        $result["property_name"] = $_POST["property_name"];
    } else {
        $errors["property_name"] = "Az ingatlan neve nincs kitöltve";

    }
    if (checkifPOST_EXIST("is_for_sale")) {
        $result["is_for_sale"] = $_POST["is_for_sale"];
    } else {
        $errors["is_for_sale"] = "Az ingatlan neve nincs kitöltve";

    }
    if (checkifPOST_EXIST("price")) {
        $result["price"] = $_POST["price"];
    } else {
        $errors["price"] = "Az ár  nincs kitöltve";

    }

    if (checkifPOST_EXIST("city")) {
        $result["city"] = $_POST["city"];
    } else {
        $errors["city"] = "Város nincs kitöltve";

    }

    if (checkifPOST_EXIST("address")) {
        $result["address"] = $_POST["address"];
    } else {
        $errors["address"] = "Cím nincs kitöltve";

    }

    if (checkifPOST_EXIST("size")) {
        $result["size"] = $_POST["size"];
    } else {
        $errors["size"] = "Méret nincs kitöltve";

    }

    if (checkifPOST_EXIST("level_number")) {
        $result["level_number"] = $_POST["level_number"];
    } else {
        $errors["level_number"] = "Szintek száma nincs kitöltve";

    }
    if (checkifPOST_EXIST("rooms")) {
        $result["rooms"] = $_POST["rooms"];
    } else {
        $errors["rooms"] = "Szintek száma nincs kitöltve";

    }

    if (checkifPOST_EXIST("rooms")) {
        $result["rooms"] = $_POST["rooms"];
    } else {
        $errors["rooms"] = "Szobák száma nincs kitöltve";

    }

    if (checkifPOST_EXIST("bath_rooms")) {
        $result["bath_rooms"] = $_POST["bath_rooms"];
    } else {
        $errors["bath_rooms"] = "Fürdő szobák száma nincs kitöltve";

    }

    if (checkifPOST_EXIST("type")) {
        $result["type"] = $_POST["type"];
    } else {
        $errors["type"] = "Típus nincs kitöltve";

    }


    if (checkifPOST_EXIST("property_condition")) {
        $result["property_condition"] = $_POST["property_condition"];
    } else {
        $errors["property_condition"] = "Állapot nincs kitöltve";

    }
    if (checkifPOST_EXIST("heating_type")) {
        $result["heating_type"] = $_POST["heating_type"];
    } else {
        $errors["heating_type"] = "Fűtés nincs kitöltve";

    }

    if (checkifPOST_EXIST("has_garage")) {
        $result["has_garage"] = $_POST["has_garage"];
    } else {
        $errors["has_garage"] = "Garázs nincs kitöltve";

    }
    if (checkifPOST_EXIST("pool")) {
        $result["has_garage"] = $_POST["has_garage"];
    } else {
        $errors["has_garage"] = "Garázs nincs kitöltve";

    }

    if (checkifPOST_EXIST("property_description")) {
        $result["property_description"] = $_POST["property_description"];
    } else {
        $errors["property_description"] = "Leírás nincs kitöltve";
    }

    if(!$errors){
        echo "\n\n\nSIKERES!";
        echo $result["property_name"];
        echo $result["is_for_sale"];
        echo $result["price"];
        echo $result["address"];
        echo $result["level_number"];
        echo $result["rooms"];
        echo $result["bath_rooms"];
        echo $result["property_condition"];
        echo $result["heating_type"];
        echo $result["has_garage"];
        echo $result["has_wifi"];
        echo $result["property_description"];
        //echo $result["photo_filename"];
        //echo $result["agent_id"];

    }else{
        echo "HIBA";
    }




       // has_garage,
       // pool,
       // has_wifi,
       // property_description,
        //photo_filename,
        //agent_id,
        //is_sold



}


   //$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Get all the submitted data from the form

    // $sql = "INSERT INTO PROPERTY () VALUES ('TEST',1,100,'London','Oxford Street 3',100,2,3,4,'Rent','Új','Gáz',0,0,1,'Szép ház Londonban','$filename',1,0);";

    // Execute query
    //mysqli_query($db, $sql);




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
<!-- Top header start -->
<header class="top-header top-header-bg none-992" id="top-header-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-4 col-sm-5">
                <div class="list-inline">
                    <?php
                    if ($_SESSION['loggedin']) { ?>
                        <a href="logout.php" class="sign-in"><i class="fa fa-sign-out"></i>Kijelentkezés</a>
                        <a href="index.php" class="sign-in"><i
                                    class="fa fa-trophy"></i>Üdvözlünk <? print $_SESSION['name'] ?></a>

                        <?php
                        if ($_SESSION['is_agent']) {
                            ?>
                            <a href="submit-property.php" class="sign-in"><i class="fa fa-upload"></i>Új ingatlan
                                feltöltése</a>
                            <?php
                        }
                        ?>
                        <?php

                    } else {
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
                        <a href="login-as-agent.html" class="sign-in"><i class="fa fa-sign-in"></i> Bejelentkezés
                            ingatlan ügynökként!</a>
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
                            <li><a class="dropdown-item" href="sale.html">Eladó</a></li>
                            <li><a class="dropdown-item" href="rent.html">Kiadó</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="agents.php" id="navbarDropdownMenuLink2">
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

<!-- Submit Property start -->
<div class="submit-property content-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="notification-box">
                    <h3>Ez az oldal ingatlanügynökök számára van fenntartva.</h3>
                    <p>Kérlek tölts ki miniden mezőt.</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="submit-address">
                    <form method="POST" action="submit-property.php">
                        <h3 class="heading-2">Alap információk</h3>
                        <div class="search-contents-sidebar mb-30">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Ingatlan hirdetés neve:</label>
                                        <input type="text" class="input-text" name="property_name" id="property_name"
                                               value="<?= allapottarto('property_name') ?>"
                                               placeholder="Ingatlan hirdetés neve">
                                        <span style="color: red"><?php echo hibaKiir('property_name') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Eladó vagy kiadó?</label>
                                        <select class="selectpicker search-fields" name="is_for-sale" id="is_for-sale">
                                            <option value="sale">Eladó</option>
                                            <option value="rent">Kiadó</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Irányár:</label>
                                        <input type="number" class="input-text" name="price" id="price"
                                               value="<?= allapottarto('price') ?>"
                                               placeholder="Irányár">
                                        <span style="color: red"><?php echo hibaKiir('price') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Város:</label>
                                        <input type="text" class="input-text" name="city" id="city"
                                               value="<?= allapottarto('city') ?>"
                                               placeholder="Város">
                                        <span style="color: red"><?php echo hibaKiir('city') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Cím:</label>
                                        <input type="text" class="input-text" name="address" id="address"
                                               value="<?= allapottarto('address') ?>"
                                               placeholder="Utca Házszám">
                                        <span style="color: red"><?php echo hibaKiir('address') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Méret m&#178;:</label>
                                        <input type="text" class="input-text" name="size" id="size"
                                               value="<?= allapottarto('size') ?>"

                                               placeholder="Méret m&#178;">
                                        <span style="color: red"><?php echo hibaKiir('size') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Szintek száma</label>
                                        <select class="selectpicker search-fields" name="level_number"
                                                id="level_number">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Szobák száma</label>
                                        <select class="selectpicker search-fields" name="rooms" id="rooms">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Fürdőszobák száma</label>
                                        <select class="selectpicker search-fields" name="bath_rooms" id="bath_rooms">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan típusa</label>
                                        <select class="selectpicker search-fields" name="type" id="type"">
                                        <option value="Apartment">Apartment</option>
                                        <option value="Családi ház">Családi ház</option>
                                        <option value="Lakás">Családi ház</option>
                                        <option value="Panel lakás">Panel lakás</option>
                                        <option value="Garázs">Garázs</option>
                                        <option value="Tanya">Tanya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan állapota</label>
                                        <select class="selectpicker search-fields" name="property_condition"
                                                id="property_condition">
                                            <option value="Új">Új</option>
                                            <option value="Újszerű">Újszerű</option>
                                            <option value="Felújított">Felújított</option>
                                            <option value="Használt">Használt</option>
                                            <option value="Romos">Romos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan fűtése</label>
                                        <select class="selectpicker search-fields" name="heating_type">
                                            <option value="Gáz">Gáz</option>
                                            <option value="Elektromos">Elektromos</option>
                                            <option value="Fa">Fa</option>
                                            <option value="Egyéb">Egyéb</option>

                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <h3 class="heading-2">Kiegészítók (opcionális)</h3>
                        <div class="row mb-40">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input id="has_garage" type="checkbox">
                                            <label for="has_garage">
                                                Garázs
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input id="pool" type="checkbox">
                                            <label for="pool">
                                                Medence
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input id="has_wifi" type="checkbox">
                                            <label for="has_wifi">
                                                Wi-Fi
                                            </label>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>


                        <h3 class="heading-2">Detailed Information</h3>
                        <div class="row mb-50">
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label>Leírás</label>
                                    <textarea class="input-text" name="property_description" id="property_description"
                                              value="<?= allapottarto('property_description') ?>"
                                              placeholder="Leírás"></textarea>
                                    <span style="color: red"><?php echo hibaKiir('property_description') ?></span>
                                </div>
                            </div>
                        </div>

                        <h3 class="heading-2">Property Gallery</h3>
                        <div id="myDropZone" class="dropzone dropzone-design mb-50">
                            <input type="file" name="uploadfile" class="dz-default dz-message"><span>Itt tudsz képeket feltölteni</span></input>
                        </div>

                        <h3 class="heading-2">A te adataid:</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Az ingatlanközvetítő ügynök neve</label>
                                    <div><?php echo $_SESSION['name'] ?> </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Az ügynök ID-ja </label>
                                    <div><?php echo $_SESSION['id'] ?> </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <!--<a href="" class="btn btn-md button-theme mb-30">A hirdetés feladása</a>-->
                                <button type="submit" name="upload" id="upload" class="btn btn-md button-theme mb-30">
                                    A hirdetés feladása
                                </button>

                            </div>
                        </div>
                    </form>
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

</html>
</body>