<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page or show an error
    header('Location: index.php');
    exit;
}
require "dbconfig.php";
require "profiledata.php";
global $con;
global $id;

$sql = "SELECT * FROM PROPERTY WHERE agent_id = '$id';";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Meghirdetett ingatlanjaim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/jquery-2.2.0.min.js"></script>
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
            <h1>Meghirdetett ingatlanjaim</h1>
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
                    <table class="table brd-none">
                        <thead>


                        <tr>
                            <th>Ingatlan neve</th>

                            <th class="hedin-div">Dátum</th>
                            <th><span class="hedin-div">Ingatlan azonosító</span></th>
                            <th>Műveletek (Szerkesztés, Törlés)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) { ?>
                                <tr id="propertyRow_<?php echo $row['id']; ?>">
                                    <td>
                                        <div class="inner">
                                            <h5>
                                                <a href="properties-details.php?id=<?php echo $row['id']; ?>"><?php echo $row["property_name"]; ?></a>
                                            </h5>

                                            <figure class="hedin-div"><i
                                                        class="fa fa-map-marker"></i> <?php echo $row["city"]; ?>
                                                 <?php echo $row["address"]; ?>
                                            </figure>
                                            <div class="price-month"><?php echo $row["price"]; ?></div>
                                        </div>
                                    </td>
                                    <td class="hedin-div"><?php echo $row["upload_date"]; ?></td>
                                    <td><span class="hedin-div"><?php echo $row["id"]; ?></span></td>
                                    <td class="actions">
                                        <a href="#" class="edit" onclick="editProperty(<?php echo $row['id']; ?>)"><i class="fa fa-pencil"></i>Szerkesztés</a>
                                        <a href="#" class="delete" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i
                                                    class="fa fa-trash-o"></i>Törlés</a>

                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<h1>Nincs meghirdetett ingatlanod!</h1>";
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer start -->
<?php include 'footer.html'; ?>

<script type="text/javascript">
    function editProperty(propertyId) {
        // Use AJAX to redirect to the edit property page
        $.ajax({
            url: 'edit_property.php', // The URL of your edit property page
            type: 'GET', // GET method
            data: {id: propertyId}, // Send the property ID
            success: function(response) {
                // Redirect to the edit page with the property ID
                window.location.href = 'edit_property.php?id=' + propertyId;
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("Hiba: " + error);
            }
        });
    }
</script>


<script type="text/javascript">
    function confirmDelete(id) {
        if (confirm("Biztosan törölni szeretnéd az ingatlant?")) {
            $.ajax({
                url: 'delete_property.php',
                type: 'POST',
                data: {id: id},
                success: function (response) {
                    if (response === '1') {
                        $('#propertyRow_' + id).remove();
                        $("#message").html(response);
                    } else {
                        $("#message").html(response);
                    }
                },
                error: function (xhr, status, error) {
                    $("#message").html("Hiba az ingatlan törlésekor: " + error);
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