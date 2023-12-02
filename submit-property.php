<?php
session_start();

function checkifPOST_EXIST($key)
{
    return !empty($_POST[$key]);
}

require "dbconfig.php";
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

mysqli_query($db, "SET NAMES utf8;");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];
$result = [];
$numbers = [1, 2, 3, 4, 5];

function hibasE($kulcs)
{
    global $errors;
    return in_array($kulcs, array_keys($errors));
}

function hibaKiir($key)
{
    global $errors;
    if ($errors) {
        echo $errors[$key];
    }
}

function allapottarto($kulcs)
{
    global $errors;
    global $result;
    //return count($errors) > 0 || hibasE($kulcs) ? $result[$kulcs] : $result[$kulcs];
    if (count($errors) > 0) {
        return $result[$kulcs];
    } else {
        return "";
    }
}

$msg = "";

function upload_picture_and_insert_it_to_db()
{
    $sql = "SELECT id, property_name FROM PROPERTY ORDER BY upload_date DESC LIMIT 1;";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $property_id = $row["id"];
        $property_name = $row["property_name"];
    } else {
        echo "No results found.";
    }
    $target_dir = "/home/thebwvas/madar-szakdolgozat.online/property_pics/";
    if (isset($_FILES['fileToUpload']['name'][0])) {

        // Loop through each file
        foreach ($_FILES["fileToUpload"]["name"] as $key => $name) {
            $sanitized_property_name = preg_replace("/[^a-zA-Z0-9_-]/", "", $property_name);
            $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $newFileName = $sanitized_property_name . "_" . time() . "_" . $key . "." . $imageFileType;
            $target_file = $target_dir . $newFileName;

            $uploadOk = 1;

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
            if ($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"][$key] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
                    echo "The file " . htmlspecialchars($name) . " has been uploaded.";
                    //$fullFilePath = $target_dir . $newFileName;
                    $fullFilePath = "http://madar-szakdolgozat.online/property_pics/" . $newFileName;
                    $sql = "INSERT INTO PICTURE (property_id, filename, description) VALUES ('$property_id', '$fullFilePath', '$property_name')";
                    $result = mysqli_query($db, $sql);
                    if (!$result) {
                        echo "Error: " . mysqli_error($db);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }
    } else {
        echo "No files were uploaded.";
    }

}

// If upload button is clicked ...

if (isset($_POST['upload'])) {
    //Check the values is okay!!!

    if (checkifPOST_EXIST("property_name")) {
        $result["property_name"] = $_POST["property_name"];
        $property_name = $_POST["property_name"];
    } else {
        $errors["property_name"] = "Az ingatlan neve nincs kitöltve";

    }
    if (checkifPOST_EXIST("is_for_sale")) {
        $result["is_for_sale"] = $_POST["is_for_sale"] === 'sale' ? 1 : 0;
        $is_for_sale = $_POST["is_for_sale"] === 'sale' ? 1 : 0;
    } else {
        $errors["is_for_sale"] = "Az Kiadó vagy eladó?";

    }
    if (checkifPOST_EXIST("price")) {
        if (intval($_POST["price"]) && intval($_POST["price"]) > 0) {
            $result["price"] = $_POST["price"];
            $price = $_POST["price"];
        } else {
            $errors["price"] = "Az ár csak pozitív egész szám lehet";
        }

    } else {
        $errors["price"] = "Az ár  nincs kitöltve";
    }

    if (checkifPOST_EXIST("city")) {
        $result["city"] = $_POST["city"];
        $city = $_POST["city"];
    } else {
        $errors["city"] = "Város nincs kitöltve";

    }

    if (checkifPOST_EXIST("address")) {
        $result["address"] = $_POST["address"];
        $address = $_POST["address"];
    } else {
        $errors["address"] = "Cím nincs kitöltve";

    }

    if (checkifPOST_EXIST("size")) {
        if (intval($_POST["size"]) && intval($_POST["size"]) > 0) {
            $result["size"] = $_POST["size"];
            $size = $_POST["size"];
        } else {
            $errors["price"] = "Az méret csak pozitív egész szám lehet";
        }
    } else {
        $errors["size"] = "Méret nincs kitöltve";

    }

    if (checkifPOST_EXIST("level_number") && in_array($_POST["level_number"], $numbers)) {
        $result["level_number"] = $_POST["level_number"];
        $level_number = $_POST["level_number"];
    } else {
        $errors["level_number"] = "Szintek száma nem megfelelő!";

    }


    if (checkifPOST_EXIST("rooms") && in_array($_POST["rooms"], $numbers)) {
        $result["rooms"] = $_POST["rooms"];
        $rooms = $_POST["rooms"];
    } else {
        $errors["rooms"] = "Szobák száma nem megfelelő";

    }


    if (checkifPOST_EXIST("bath_rooms") && in_array($_POST["bath_rooms"], $numbers)) {
        $result["bath_rooms"] = $_POST["bath_rooms"];
        $bath_rooms = $_POST["bath_rooms"];
    } else {
        $errors["bath_rooms"] = "Fürdő szobák nem megfelelő";

    }

    if (checkifPOST_EXIST("type")) {
        $result["type"] = $_POST["type"];
        $type = $_POST["type"];
    } else {
        $errors["type"] = "Típus nincs kitöltve";

    }


    if (checkifPOST_EXIST("property_condition")) {
        $result["property_condition"] = $_POST["property_condition"];
        $property_condition = $_POST["property_condition"];
    } else {
        $errors["property_condition"] = "Állapot nincs kitöltve";

    }
    if (checkifPOST_EXIST("heating_type")) {
        $result["heating_type"] = $_POST["heating_type"];
        $heating_type = $_POST["heating_type"];
    } else {
        $errors["heating_type"] = "Fűtés nincs kitöltve";

    }

    if ($_POST["has_garage"] == "has_garage") {
        $result["has_garage"] = 1;
        $has_garage = 1;
    } else {
        $result["has_garage"] = 0;
        $has_garage = 0;

    }
    if ($_POST["pool"] == "pool") {
        $result["pool"] = 1;
        $pool = 1;
    } else {
        $result["pool"] = 0;
        $pool = 0;

    }
    if ($_POST["has_wifi"] == "has_wifi") {
        $result["has_wifi"] = 1;
        $has_wifi = 1;
    } else {
        $result["has_wifi"] = 0;
        $has_wifi = 0;

    }

    if (checkifPOST_EXIST("property_description")) {
        $result["property_description"] = $_POST["property_description"];
        $property_description = $_POST["property_description"];
    } else {
        $errors["property_description"] = "Leírás nincs kitöltve";
    }

    if (!$errors) {


        $sql = "insert into PROPERTY (property_name, is_for_sale, price, city, address, size, level_number, rooms, bath_rooms, type, property_condition, heating_type, has_garage, pool, has_wifi, property_description, agent_id, is_sold)
VALUES(
    '$property_name',
    $is_for_sale,
    $price,
    '$city',
    '$address',
    $size,
    $level_number,
    $rooms,
    $bath_rooms,
    '$type',
    '$property_condition',
    '$heating_type',
    $has_garage,
    $pool,
    $has_wifi,
    '$property_description',
    1,
    0);";

        $result = mysqli_query($db, $sql);
        $info_message = "Sikeres feltöltés" . mysqli_error($db);
        // After successfully inserting property details upload the picture
        upload_picture_and_insert_it_to_db();
    } else {
        $info_message = "Kérlek ellenőrizd hogy minden mező helyesen ki van töltve.";
    }


}

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
                            <li><a class="dropdown-item">Eladó</a></li>
                            <li><a class="dropdown-item">Kiadó</a></li>
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
                    <p id="info_message"><?php echo $info_message ?></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="submit-address">
                    <form method="POST" action="submit-property.php" enctype="multipart/form-data">
                        <h3 class="heading-2">Alap információk</h3>
                        <div class="search-contents-sidebar mb-30">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Ingatlan hirdetés neve:</label>
                                        <input type="text" class="input-text" name="property_name" id="property_name"
                                               value="<?= allapottarto('property_name') ?>"
                                        >
                                        <span style="color: red"><?php echo hibaKiir('property_name') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Eladó vagy kiadó?</label>
                                        <select class="selectpicker search-fields" name="is_for_sale" id="is_for_sale">
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
                                        >
                                        <span style="color: red"><?php echo hibaKiir('price') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Város:</label>
                                        <input type="text" class="input-text" name="city" id="city"
                                               value="<?= allapottarto('city') ?>"
                                        >
                                        <span style="color: red"><?php echo hibaKiir('city') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Cím:</label>
                                        <input type="text" class="input-text" name="address" id="address"
                                               value="<?= allapottarto('address') ?>"
                                        >
                                        <span style="color: red"><?php echo hibaKiir('address') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Méret m&#178;:</label>
                                        <input type="number" class="input-text" name="size" id="size"
                                               value="<?= allapottarto('size') ?>"
                                        >
                                        <span style="color: red"><?php echo hibaKiir('size') ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Szintek száma</label>
                                        <select class="selectpicker search-fields" name="level_number"
                                                id="level_number">
                                            <?php for ($i = 0;
                                                       $i < count($numbers);
                                                       $i++): ?>
                                                <option value="<?= $numbers[$i] ?>"> <?= $numbers[$i] ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Szobák száma</label>
                                        <select class="selectpicker search-fields" name="rooms" id="rooms">
                                            <?php for ($i = 0;
                                                       $i < count($numbers);
                                                       $i++): ?>
                                                <option value="<?= $numbers[$i] ?>"> <?= $numbers[$i] ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Fürdőszobák száma</label>
                                        <select class="selectpicker search-fields" name="bath_rooms" id="bath_rooms">
                                            <?php for ($i = 0;
                                                       $i < count($numbers);
                                                       $i++): ?>
                                                <option value="<?= $numbers[$i] ?>"> <?= $numbers[$i] ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan típusa</label>
                                        <select class="selectpicker search-fields" name="type" id="type"">
                                        <option value="Apartment">Apartment</option>
                                        <option value="Családi ház">Családi ház</option>
                                        <option value="Lakás">Lakás</option>
                                        <option value="Panel lakás">Panel lakás</option>
                                        <option value="Garázs">Garázs</option>
                                        <option value="Tanya">Tanya</option>
                                        <option value="Nyaraló">Nyaraló</option>
                                        <option value="Iroda">Iroda</option>
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
                                        <select class="selectpicker search-fields" name="heating_type"
                                                id="heating_type">
                                            <option value="Gáz">Gáz</option>
                                            <option value="Elektromos">Elektromos</option>
                                            <option value="Fa">Fa</option>
                                            <option value="Egyéb">Egyéb</option>
                                            <option value="Nincs">Nincs</option>

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
                                        <div class="checkbox checkbox-theme">
                                            <input name="has_garage" id="has_garage" type="checkbox" value="has_garage">
                                            <label for="has_garage">
                                                Garázs
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input name="pool" id="pool" type="checkbox" value="pool">
                                            <label for="pool">
                                                Medence
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input name="has_wifi" id="has_wifi" type="checkbox" value="has_wifi">
                                            <label for="has_wifi">
                                                Wi-Fi
                                            </label>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row mb-50">
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label>Leírás</label>
                                    <textarea class="input-text" name="property_description" id="property_description"
                                              value="<?= allapottarto('property_description') ?>"
                                    ></textarea>
                                    <span style="color: red"><?php echo hibaKiir('property_description') ?></span>
                                </div>
                            </div>
                        </div>

                        <h3 class="heading-2">Képek feltöltése</h3>
                        <div id="myDropZone" class="dropzone dropzone-design mb-50">
                            <input type="file" name="fileToUpload[]" id="fileToUpload" class="dz-default dz-message"><span>Itt tudsz képeket feltölteni</span></input>
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

<script type="javascript">
    /*  let elem = document.getElementById("price");

      elem.addEventListener("keydown",function(event){
          var key = event.which;
          if((key<48 || key>57) && key != 8) event.preventDefault();
      });

      elem.addEventListener("keyup",function(event){
          var value = this.value.replace(/,/g,"");
          this.dataset.currentValue=parseInt(value);
          var caret = value.length-1;
          while((caret-3)>-1)
          {
              caret -= 3;
              value = value.split('');
              value.splice(caret+1,0,",");
              value = value.join('');
          }
          this.value = value;
      });


          console.log(document.getElementById("price").dataset.currentValue);
  */
</script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

<script src="js/ie10-viewport-bug-workaround.js"></script>
</html>
</body>
