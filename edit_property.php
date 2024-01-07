<?php
session_start();
require "dbconfig.php";
require "propertydropdown.php";

global $con;
$info_message = "";


// Check if logged in and is an agent
if (!isset($_SESSION['loggedin']) || $_SESSION['is_agent'] !== TRUE) {
    // If not logged in or not an agent, redirect to index page or show an error
    header('Location: index.php');
    exit;
}

$propertyId = $_GET['id'] ?? $_POST['propertyId'] ?? null;
if (!$propertyId) {
    exit('Hiba az n ID-val!');
}


$stmt = $con->prepare("SELECT * FROM PROPERTY WHERE id = ?");
$stmt->bind_param("i", $propertyId);
$stmt->execute();

// Bind the result variables
$stmt->store_result();
$meta = $stmt->result_metadata();
while ($field = $meta->fetch_field()) {
    $params[] = &$row[$field->name];
}

call_user_func_array(array($stmt, 'bind_result'), $params);

// Fetch the result
if ($stmt->fetch()) {
    foreach($row as $key => $val) {
        $property[$key] = $val;
    }
    // Now $property is an associative array with the result
} else {
    exit('Az ingatlanügynökhöz nem tartozik ingatlan!');
}

$stmt->close();

// Function to maintain form state and display existing property values
function allapottarto($key  ) {
    global $property;
    return $_POST[$key] ?? htmlspecialchars($property[$key]);
}



function checkifPOST_EXIST($key)
{
    return !empty($_POST[$key]);
}
$errors = [];
$result = [];
$numbers = [1, 2, 3, 4, 5];
function hibasE($kulcs)
{
    global $errors;
    return in_array($kulcs, array_keys($errors));
}

// Function to display errors
function hibaKiir($key) {
    global $errors;
    return isset($errors[$key]) ? $errors[$key] : '';
}


$msg = "";
function upload_picture_and_insert_it_to_db()
{
    global $info_message;
    require "dbconfig.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    mysqli_query($con, "SET NAMES utf8;");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $sql = "SELECT id, property_name FROM PROPERTY ORDER BY upload_date DESC LIMIT 1;";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $property_id = $row["id"];
        $property_name = $row["property_name"];
    } else {
        $info_message .= "Nincs meg az utolsó feltöltött ingatlan! A kép nem tölthető fel\n";
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
                $uploadOk = 1;
            } else {
                $info_message .= "A fálj nem kép - ". $check["mime"] . "\n";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"][$key] > 50000000) {
                $info_message .=  "A kép túl nagy méretű. ". $_FILES["fileToUpload"]["tmp_name"][$key] .  "\n";
                $uploadOk = 0;
            }

            // Allow certain file formats
            /*
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $info_message .= "Csak JPG, JPEG, PNG & GIF fálj engedélyezett.";
                echo "Csak JPG, JPEG, PNG & GIF fálj engedélyezett. : tipus" . $imageFileType . " -ez \n";
                $uploadOk = 0;
            }
            */
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $info_message .= "A kép nincs feltöltve.";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
                    $info_message .= "\n A fálj " . htmlspecialchars($name) . " sikeresen fel lett töltve.";
                    //$fullFilePath = $target_dir . $newFileName;
                    $fullFilePath = "https://madar-szakdolgozat.online/property_pics/" . $newFileName;
                    $sql = "INSERT INTO PICTURE (property_id, filename, description) VALUES ('$property_id', '$fullFilePath', '$property_name')";
                    $result = mysqli_query($con, $sql);
                    if (!$result) {
                        $info_message .= "\n SQL hiba a kép feltöltése közben : " . mysqli_error($con) . "\n";
                    }
                } else {
                    $info_message .= "\n A kép feltöltése nem sikerült, hiba a szerverre való feltöltéskor " . $_FILES["fileToUpload"]["tmp_name"][$key] . "\n";
                }
            }

        }
    } else {
        $info_message .= "\n A ".  $_FILES["fileToUpload"]["tmp_name"][$key] . " nem lett kép feltöltve. Nincs bettallózva. \n";
    }

}

// If upload button is clicked ...

if (isset($_POST['editProperty'])) {
    //Check the values is okay!!!
    if (isset($_POST['is_sold'])) {
        // Explicitly compare with the string value '1'
        $is_sold = $_POST['is_sold'] === '1' ? 1 : 0;
    } else {
        // Fallback to the original property value if not set
        $is_sold = $property['is_sold'];
    }

    $has_garage = isset($_POST['has_garage']) ? 1 : 0;
    $pool = isset($_POST['pool']) ? 1 : 0;
    $has_wifi = isset($_POST['has_wifi']) ? 1 : 0;


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
        // Check if there are changes
        $changes = [];

        // Check for changes and prepare for update
        if ($property['is_sold'] != $is_sold) {
            $changes['is_sold'] = $is_sold;
        }

        // Check for changes
        if ($property['is_sold'] != $is_sold) {
            $changes['is_sold'] = $is_sold;
        }

        foreach ($result as $key => $value) {
            if ($property[$key] != $value) {
                $changes[$key] = $value;
            }
        }


        // Only proceed if there are changes
        if (count($changes) > 0) {
            $updateParts = [];
            foreach ($changes as $key => $value) {
                $updateParts[] = "$key = '" . mysqli_real_escape_string($con, $value) . "'";
            }
            $updateQuery = "UPDATE PROPERTY SET " . implode(', ', $updateParts) . " WHERE id = $propertyId";

            if (mysqli_query($con, $updateQuery)) {
                $info_message .= "\nAz ingatlan adatai sikeresen frissítve.\n";
            } else {
                $info_message .= "\nHiba történt az adatok frissítése során: " . mysqli_error($con) . "\n";
            }
        } else {
            $info_message .= "\nNem történt változtatás.\n";
        }

        // Handle picture upload and insertion
        upload_picture_and_insert_it_to_db();
    } else {
        $info_message .= "\nKérlek ellenőrizd, hogy minden mező helyesen ki van-e töltve.\n";
    }

}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Ingatlan szerkesztés</title>
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

<!-- Submit Property start -->
<div class="submit-property content-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="notification-box">
                    <h3>Szerkesztés, az oldal ingatlanügynökök számára van fenntartva.</h3>
                    <p id="info_message"><?php echo $info_message ?></p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="submit-address">
                    <form method="POST" action="edit_property.php" enctype="multipart/form-data">
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
                                            <option value="sale" <?php echo ($property['is_for_sale'] == 1 ? 'selected' : ''); ?>>Eladó</option>
                                            <option value="rent" <?php echo ($property['is_for_sale'] == 0 ? 'selected' : ''); ?>>Kiadó</option>
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
                                        <label>Város (Irányítószám):</label>
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
                                        <select class="selectpicker search-fields" name="level_number" id="level_number">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?= $i ?>" <?php echo ($property['level_number'] == $i ? 'selected' : ''); ?>> <?= $i ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Szobák száma</label>
                                        <select class="selectpicker search-fields" name="rooms" id="rooms">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?= $i ?>" <?php echo ($property['rooms'] == $i ? 'selected' : ''); ?>> <?= $i ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Fürdőszobák száma</label>
                                        <select class="selectpicker search-fields" name="bath_rooms" id="bath_rooms">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <option value="<?= $i ?>" <?php echo ($property['bath_rooms'] == $i ? 'selected' : ''); ?>> <?= $i ?> </option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan típusa</label>
                                        <select class="selectpicker search-fields" name="type" id="type">
                                            <?php foreach ($propertyTypes as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= ($property['type'] == $value ? 'selected' : '') ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan állapota</label>
                                        <select class="selectpicker search-fields" name="property_condition" id="property_condition">
                                            <?php foreach ($propertyConditions as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= ($property['property_condition'] == $value ? 'selected' : '') ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan fűtése</label>
                                        <select class="selectpicker search-fields" name="heating_type" id="heating_type">
                                            <?php foreach ($heatingTypes as $value => $label): ?>
                                                <option value="<?= $value ?>" <?= ($property['heating_type'] == $value ? 'selected' : '') ?>><?= $label ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>Az ingatlan elérhető-e még? Ki van adva vagy el van adva?:</label>
                                        <select class="selectpicker search-fields" name="is_sold" id="is_sold">
                                            <option value="0" <?= $property['is_sold'] == 0 ? 'selected' : ''; ?>>Elérhető</option>
                                            <option value="1" <?= $property['is_sold'] == 1 ? 'selected' : ''; ?>>Nem elérhető</option>
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
                                            <input type="checkbox" name="has_garage" id="has_garage" value="has_garage" <?php echo ($property['has_garage'] == 1 ? 'checked' : ''); ?>>

                                            <label for="has_garage">
                                                Garázs
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input type="checkbox" name="pool" id="pool" value="pool" <?php echo ($property['pool'] == 1 ? 'checked' : ''); ?>>

                                            <label for="pool">
                                                Medence
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-theme checkbox-circle">
                                            <input type="checkbox" name="has_wifi" id="has_wifi" value="has_wifi" <?php echo ($property['has_wifi'] == 1 ? 'checked' : ''); ?>>
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
                                              >
                                        <?php echo allapottarto('property_description') ?>
                                    </textarea>
                                    <span style="color: red"><?php echo hibaKiir('property_description') ?></span>
                                </div>
                            </div>
                        </div>

                        <h3 class="heading-2">Képek feltöltése</h3>
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
                        <h3 class="heading-2">A te adataid:</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Az ingatlanközvetítő ügynök neve</label>
                                    <div><?php echo $_SESSION['name'] ?> </div>
                                </div>
                            </div>
                            <input type="hidden" name="propertyId" value="<?= htmlspecialchars($propertyId) ?>">

                            <div class="col-md-12">
                                <button type="submit" name="editProperty" id="editProperty" class="btn btn-md button-theme mb-30">
                                    A hirdetés szerkesztése
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

</script>


<script src="js/ie10-viewport-bug-workaround.js"></script>
</html>
</body>