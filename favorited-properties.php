<?php
session_start();
require "dbconfig.php";
require "profiledata.php";

global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME, $id;
$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT favorite_properties FROM USER WHERE id = '$id'";
$result = $conn->query($sql);


?>

    <!DOCTYPE html>
    <html lang="hu">
    <head>
        <title>Kedvenc ingatlanjaim</title>
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
                <h1>Kedvencnek jelölt ingatlanjaim</h1>
            </div>
        </div>
    </div>

    <!-- My properties start -->
    <div class="my-properties content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <?php include 'profilemenu.php'; ?>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <!-- Heading -->
                    <p id="message"></p>
                    <div class="my-properties">
                        <?php
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $favoriteProperties = json_decode($row["favorite_properties"], true);
                            if (is_array($favoriteProperties) && count($favoriteProperties) > 0) {
                                ?>
                                <table class="table brd-none">
                                    <thead>
                                    <tr>
                                        <th>Ingatlan neve</th>
                                        <th class="hedin-div">Dátum</th>
                                        <th><span class="hedin-div">Ingatlan azonosító</span></th>
                                        <th>Kedvenc eltávolítása</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $ids = implode(',', $favoriteProperties);
                                    $propertyQuery = "SELECT * FROM PROPERTY WHERE id IN ($ids)";
                                    $propertyResult = $conn->query($propertyQuery);

                                    if ($propertyResult->num_rows > 0) {
                                        while ($propertyRow = $propertyResult->fetch_assoc()) {
                                            ?>
                                            <tr id="propertyRow-<?php echo $propertyRow['id']; ?>">
                                                <td class="actions">
                                                    <div class="inner">
                                                        <h5>
                                                            <a href="properties-details.php?id=<?php echo $propertyRow['id']; ?>"><?php echo $propertyRow['property_name']; ?></a>
                                                        </h5>
                                                        <figure class="hedin-div"><i
                                                                    class="fa fa-map-marker"></i> <?php echo $propertyRow["city"]; ?>
                                                            , <?php echo $propertyRow["address"]; ?></figure>
                                                        <div class="price-month"><?php echo $propertyRow["price"]; ?></div>
                                                    </div>
                                                </td>
                                                <td class="hedin-div"><?php echo $propertyRow["upload_date"]; ?></td>
                                                <td><span class="hedin-div"><?php echo $propertyRow["id"]; ?></span>
                                                </td>
                                                <td class="actions">
                                                    <a href="#" class="delete"
                                                       onclick="confirmDelete(<?php echo $propertyRow['id']; ?>)"><i
                                                                class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>Nincs kedvenc ingatlanod.</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                echo "<p>Nincs kedvenc ingatlanod.</p>";
                            }
                        } else {
                            echo "<p>Nincs kedvenc ingatlanod.</p>";
                        }
                        ?>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Footer start -->
    <?php include 'footer.html'; ?>

    <script type="text/javascript">
        function confirmDelete(id) {
            if (confirm("Biztosan eltávolítod az ingatlant a kedvencek közül?")) {
                $.ajax({
                    url: 'remove_fav_property.php',
                    type: 'POST',
                    data: {propertyId: id},
                    success: function (response) {
                        // Check if the response indicates successful removal
                        if (response === 'A kedvenc sikeresen el lett távolítva') {
                            // Remove the table row for this property
                            $('#propertyRow-' + id).remove();

                            // Optionally, you can also check if there are no more favorite properties
                            // and show a message or hide the table
                        } else {
                            // Handle error or different response
                            $("#message").html(response);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Handle AJAX error
                        $("#message").html("Hiba történt: " + error);
                    }
                });
            }
        }

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

<?php
$conn->close();
?>