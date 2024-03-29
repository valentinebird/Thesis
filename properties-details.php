<?php

session_start();
require "dbconfig.php";
global $con;

$id = $_GET['id'];
//Query for this property
$sql = "SELECT * FROM PROPERTY WHERE id = $id;";
$result = $con->query($sql);
$row = $result->fetch_assoc();

$propertyExists = $result->num_rows > 0;


if ($propertyExists) {
    //Query for agent
    $agentID_of_thisproperty = $row["agent_id"];
    $sqlforAgent = "SELECT * FROM AGENT WHERE id = $agentID_of_thisproperty;";
    $result_ofporperty = $con->query($sqlforAgent);
    $rowagent = $result_ofporperty->fetch_assoc();
    $result = $con->query($sql);

    //Query for picture
    $sqlforPictures = "SELECT * FROM PICTURE WHERE property_id = $id;";
    $result_ofPicture = $con->query($sqlforPictures);

    //$result = $con->query($sql);

} else {
    $row = null; // Set row to null if property does not exist
}


function checkFavorite($id): bool
{
    global $con, $propertyExists;
    if ($propertyExists && isset($_SESSION['id'])) {
        $userId = $_SESSION['id'];
        $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $userRow = $result->fetch_assoc();
            $favoriteProperties = json_decode($userRow["favorite_properties"], true);
            return in_array($id, $favoriteProperties);
        }
    }
    return false; // Return false if not a favorite or if there's an error
}






?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Az ingtalan adatai</title>
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
            <h1>Az ingatlan adatai</h1>

        </div>
    </div>
</div>
<?php if ($propertyExists) { ?>
    <!-- Properties Details page start -->
    <div class="properties-details-page content-area-7">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="properties-details-section">
                        <div id="propertiesDetailsSlider" class="carousel properties-details-sliders slide mb-40">
                            <!-- Heading properties start -->
                            <div class="heading-properties-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-left">
                                            <h3><?php echo $row["property_name"]; ?></h3>
                                            <p>
                                                <i class="fa fa-map-marker"></i> <?php echo $row["address"]; ?> <?php echo $row["city"]; ?>
                                            </p>
                                        </div>
                                        <div class="pull-right">
                                            <h3><span class="text-right"> <?php echo $row["price"]; ?> Forint</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
                                <?php
                                $pictureFilenames = []; // Initialize an array to store filenames

                                if ($result_ofPicture && $result_ofPicture->num_rows > 0) {
                                    $counter = 0; // Initialize counter

                                    while ($rowPicture = $result_ofPicture->fetch_assoc()) {
                                        $pictureFilenames[] = $rowPicture['filename']; // Store filename in array

                                        $activeClass = ($counter === 0) ? 'active' : '';
                                        ?>
                                        <div class="item carousel-item <?php echo $activeClass; ?>"
                                             data-slide-number="<?php echo $counter; ?>">
                                            <img src="<?php echo htmlspecialchars($rowPicture['filename']); ?>"
                                                 class="img-fluid"
                                                 alt="<?php echo htmlspecialchars($rowPicture['description']); ?>">
                                        </div>
                                        <?php
                                        $counter++; // Increment counter
                                    }
                                } else {
                                    echo "<h1>Nincs kép a kiválasztott ingatlanhoz</h1>";
                                }
                                ?>
                            </div>

                            <!-- Carousel indicators -->
                            <ul class="carousel-indicators smail-properties list-inline nav nav-justified">
                                <?php
                                foreach ($pictureFilenames as $i => $filename) {
                                    $activeClass = ($i === 0) ? 'active' : '';
                                    ?>
                                    <li class="list-inline-item <?php echo $activeClass; ?>">
                                        <a id="carousel-selector-<?php echo $i; ?>" data-slide-to="<?php echo $i; ?>"
                                           data-target="#propertiesDetailsSlider">
                                            <img src="<?php echo htmlspecialchars($filename); ?>" class="img-fluid"
                                                 alt="properties-small">
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <!-- main slider carousel items -->
                        </div>

                        <!-- Tabbing box start -->
                        <div class="tabbing tabbing-box tb-2 mb-40">
                            <ul class="nav nav-tabs" id="carTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="one-tab" data-toggle="tab" href="#one"
                                       role="tab"
                                       aria-controls="one" aria-selected="false">Leírás</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab"
                                       aria-controls="three" aria-selected="true">Részletek</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="5-tab" data-toggle="tab" href="#5" role="tab"
                                       aria-controls="5"
                                       aria-selected="true">Helyszín</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="carTabContent">
                                <div class="tab-pane fade active show" id="one" role="tabpanel"
                                     aria-labelledby="one-tab">
                                    <div class="properties-description mb-50">
                                        <h3 class="heading-2">
                                            Leírás
                                        </h3>
                                        <?php echo $row["property_description"]; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="three" role="tabpanel" aria-labelledby="three-tab">
                                    <div class="property-details mb-40">
                                        <h3 class="heading-2">Részletek</h3>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li>
                                                        <strong>Az ingatlan Id:</strong><?php echo $row["id"]; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Ár:</strong><?php echo $row["price"]; ?> Ft
                                                    </li>
                                                    <li>
                                                        <strong>Típus:</strong><?php echo $row["type"]; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li>
                                                        <strong>Méret:</strong><?php echo $row["size"]; ?>m&#178;
                                                    </li>


                                                    <li>
                                                        <strong>Fűtés:</strong><?php echo $row["heating_type"]; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Állapota:</strong>
                                                        <?php echo $row["property_condition"]; ?>
                                                    </li>

                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li>
                                                        <strong>Szintek száma:</strong>
                                                        <?php echo $row["level_number"]; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Város: </strong> <?php echo $row["city"]; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Cím: </strong><?php echo $row["address"]; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <ul>
                                                    <li>
                                                        <strong>Kiadó vagy eladó:</strong>
                                                        <?php echo ($row["is_for_sale"] == 1) ? "Eladó" : "Kiadó"; ?>
                                                    </li>
                                                    <li>
                                                        <strong>Elérhető még a hirdetés: </strong><?php if ($row["is_sold"] == 0) {
                                                            echo "Elérhető";
                                                        } else {
                                                            echo "Már nem elérhető";
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <strong>Meghirdetési időpont</strong><?php echo $row["upload_date"]; ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Properties condition start -->
                                    <div class="properties-condition mb-40">
                                        <h3 class="heading-2">
                                            Felszereltség
                                        </h3>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <ul class="condition">
                                                    <li>
                                                        <i class="flaticon-furniture"></i><?php echo $row["rooms"]; ?>
                                                        Hálószobák száma
                                                    </li>
                                                    <li>
                                                        <i class="flaticon-holidays"></i><?php echo $row["bath_rooms"]; ?>
                                                        Fürdőszobák száma
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Properties amenities start -->
                                    <div class="properties-amenities mb-40">
                                        <h3 class="heading-2">
                                            Extrák
                                        </h3>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <ul class="amenities">
                                                    <?php if ($row["has_wifi"] == 1) { ?>
                                                        <li>
                                                            <i class="flaticon-connection"></i>Wifi
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($row["has_garage"] == 1) { ?>
                                                        <li>
                                                            <i class="flaticon-vehicle"></i>Garázs
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($row["pool"] == 1) { ?>
                                                        <li>
                                                            <i class="flaticon-beach"></i>Medence
                                                        </li>
                                                    <?php } ?>
                                                    <?php if ($row["has_wifi"] == 0 and $row["has_garage"]  == 0  and $row["pool"] == 0 )
                                                    {echo "Az ingatlannak nincsennek extrái";} ?>

                                                </ul>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="5" role="tabpanel" aria-labelledby="5-tab">
                                    <div class="location mb-50">
                                        <div class="map">
                                            <h3 class="heading-2">Az ingatlan helye: </h3>
                                            <div id="propertymap" class="contact-map"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Agent details 1 start -->
                        <div class="contact-1 mtb-50">
                            <h3 class="heading">Kapcsolat az ügynökkel/kedvencekhez adás</h3>
                            <div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group name">
                                            <div>Kedvencekhez adás</div>
                                            <?php if (!$_SESSION['is_agent'] and $_SESSION['loggedin']) { ?>
                                                <div>
                                                    <button  class="search-button" id="favoriteButton" onclick="handleFavorite(<?php echo $id; ?>)">
                                                        <?php echo checkFavorite($id) ? 'Az eltávolítás a kedvencek közül' : 'Hozzáadás a kedvencekhez'; ?>
                                                    </button>
                                                </div>
                                            <?php }else { ?>
                                                <div> A kedvencekhez adás csak bejelentkezett felhasználók számára elérhető. </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group email">
                                            <div>Az ingatlan közvetítő ügynök neve:</div>
                                            <a href="agent-detail.php?id=<?php echo $row["agent_id"]; ?>"><?php echo $rowagent["real_name"]; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group subject">
                                            <div>Az ingatlan közvetítő ügynök E-mail címe:</div>
                                            <div>
                                                <a href="mailto: <?php echo $rowagent['email']; ?>"><?php echo $rowagent["email"]; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group number">
                                            <div>Az ingatlan közvetítő ügynök telefonszáma:</div>
                                            <div><?php echo $rowagent["phone"]; ?></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo "<h1>Nincs ilyen ingatlan</h1>";
} ?>

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
<script src="js/app.js"></script>

<script>

    function handleFavorite(propertyId) {
        let button = document.getElementById('favoriteButton');
        let isFavoriteNow = <?php echo checkFavorite($id) ? 'true' : 'false'; ?>;

        $.ajax({
            url: 'handle_favorite.php',
            type: 'POST',
            data: { propertyId: propertyId, action: isFavoriteNow ? 'remove' : 'add' },
            success: function(response) {
                // Toggle the state based on the current state
                if (isFavoriteNow) {
                    console.log('Hozzadas', response);
                    button.innerText = 'Hozzáadás a kedvencekhez';
                } else {
                    console.log('Eltavolitas', response);
                    button.innerText = 'Eltávolítás a kedvencek közül';
                }
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error: ", error);
            }
        });
    }

</script>


<script>
    function initMap() {
        <?php
        // Extract zip code using a regular expression
        preg_match('/\b\d{4,5}\b/', $row['city'], $matches);
        $zipCode = $matches[0] ?? '';

        // Remove the zip code from the city string
        $cityWithoutZip = trim(str_replace($zipCode, '', $row['city']));

        // Format the full address
        $fullAddress = $row['address'] . ', ' . $cityWithoutZip . ' ' . $zipCode;
        ?>
        let address = <?php echo json_encode($fullAddress); ?>;
        let geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': address}, function (results, status) {
            console.log("Geocoder response status:", status);

            if (status === 'OK') {
                console.log("Geocoder results:", results);

                let map = new google.maps.Map(document.getElementById('propertymap'), {
                    zoom: 15,
                    center: results[0].geometry.location
                });

                let marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                console.error('Geocode was not successful for the following reason:', status);
                document.getElementById('propertymap').innerHTML = '<p>A helyszín nem található a térképen.</p>';
            }
        });
    }
</script>
<?php $apiKey = "AIzaSyAWOyts9O5KO0g_OO69ulWKtfL7g-ymjuw"; ?>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&callback=initMap"></script>
</script>


</body>
</html>