<?php

session_start();
require "dbconfig.php";

//$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sortOrder = 'upload_date DESC'; // Assuming 'id DESC' as default (newest first)

// Check if a sort option is set and update sortOrder accordingly
if (isset($_GET['sort']) && !empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'newest':
            $sortOrder = 'upload_date DESC';
            break;
        case 'oldest':
            $sortOrder = 'upload_date ASC';
            break;
        case 'highest_price':
            $sortOrder = 'price DESC';
            break;
        case 'lowest_price':
            $sortOrder = 'price ASC';
            break;
    }
}

$sql = "SELECT * FROM PROPERTY WHERE is_for_sale = 0 ORDER BY $sortOrder;";
$result = $conn->query($sql);


$conn->close();

function display_first_rent_picture($id)
{
    global $conn; // Ensure that $conn is accessible within the function
    $sql = "SELECT * FROM PICTURE WHERE property_id = $id LIMIT 1;";
    $result = $conn->query($sql);
    $pictureExists = $result->num_rows > 0;
    if ($pictureExists) {
        $row = $result->fetch_assoc();
        return $row["filename"];
    } else {
        return "property_pics/default_rent.jpeg";
    }
}




?>

<script>
    function sortProperties(sortBy) {
        // Redirect to the same page with the new sort parameter
        window.location.href = '?sort=' + sortBy;
    }
</script>


<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Kiadó ingatlanok listája</title>
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
            <h1>Kiadó ingatlanjaink listája</h1>
        </div>
    </div>
</div>

<!-- Properties section body start -->
<div class="properties-section content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <!-- Option bar start -->
                <div class="option-bar">
                    <div class="float-left">
                        <h4>
                            <span class="heading-icon">
                                <i class="fa fa-th-list"></i>
                            </span>
                            <span class="title-name">Rendezési sorrend</span>
                        </h4>
                    </div>
                    <div class="float-right cod-pad">
                        <div class="sorting-options">
                            <select class="sorting" onchange="sortProperties(this.value)">
                                <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>
                                    Legújabb elöl
                                </option>
                                <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : ''; ?>>
                                    Legrégebbi elöl
                                </option>
                                <option value="highest_price" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'highest_price') ? 'selected' : ''; ?>>
                                    Ár (Legdrágább elöl)
                                </option>
                                <option value="lowest_price" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'lowest_price') ? 'selected' : ''; ?>>
                                    Ár (Legolcsóbb elöl)
                                </option>
                            </select>

                        </div>
                    </div>
                </div>

                <!-- Property box 2 start -->
                <?php
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="property-box-2">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-pad">
                                    <a href="properties-details.php?id=<?php echo $row['id']; ?>" class="property-img">
                                        <img src="<?php echo display_first_rent_picture($row['id']); ?>"
                                             alt="properties" class="img-fluid">
                                        <div class="listing-badges">
                                            <span class="listing-time">Kiadó</span>
                                        </div>
                                        <div class="price-box"><?php echo $row["price"]; ?><small> Ft</small></div>
                                    </a>
                                </div>
                                <div class="col-lg-7 col-md-7 col-pad">
                                    <div class="detail">
                                        <h3 class="title">
                                            <a href="properties-details.php?id=<?php echo $row['id']; ?>"><?php echo $row["property_name"]; ?></a>
                                        </h3>
                                        <p class="location">
                                            <i class="flaticon-location"></i> <?php echo $row["city"]; ?>
                                        </p>
                                        <ul class="facilities-list clearfix">
                                            <li>
                                                <i class="flaticon-furniture"></i>
                                                <span> <?php echo $row["rooms"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="flaticon-holidays"></i>
                                                <span><?php echo $row["bath_rooms"]; ?></span>
                                            </li>
                                            <li>
                                                <i class="flaticon-square"></i>
                                                <span><?php echo $row["size"]; ?>m&#178;</span>
                                            </li>
                                            <li>
                                                <i class="flaticon-technology-3"></i>
                                                <span><?php echo $row["type"]; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer clearfix">
                                        <div class="pull-left days">
                                            <a><i class="fa fa-user"></i> <?php echo $row["agent_id"]; ?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a><i class="flaticon-time"></i> <?php echo $row["upload_date"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <h1>Jelenleg nincs kiadó ingatlanunk!</h1>
                <?php } ?>

            </div>

            <div class="col-lg-4 col-md-12">
                <div class="sidebar-right">
                    <!-- Advanced search start -->

                    <div class="sidebar widget advanced-search">
                        <h3 class="sidebar-title">Részletes keresés</h3>
                        <div class="s-border"></div>
                        <div class="m-border"></div>
                        <?php include 'searchfield.php'; ?>
                    </div>
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

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>