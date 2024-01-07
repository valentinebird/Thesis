<?php
session_start();
require "dbconfig.php";
global $con;

// Ensure all GET variables are set, even if they're empty
$propertyStatus = isset($_GET['property-status']) ? $_GET['property-status'] : 'empty';
$propertyType = isset($_GET['property-type']) ? $_GET['property-type'] : 'empty';
$location = isset($_GET['location']) ? $_GET['location'] : 'empty';
$bedrooms = isset($_GET['bedrooms']) ? $_GET['bedrooms'] : 'empty';
$bathroom = isset($_GET['bathroom']) ? $_GET['bathroom'] : 'empty';
$condition = isset($_GET['condition']) ? $_GET['condition'] : 'empty';

// Checkboxes
$garage = isset($_GET['garage']) ? 'checked' : 'not checked';
$pool = isset($_GET['pool']) ? 'checked' : 'not checked';
$wifi = isset($_GET['wifi']) ? 'checked' : 'not checked';


// Initialize the SQL query
$sql = "SELECT * FROM `PROPERTY` WHERE 1 = 1";  // '1 = 1' is used to simplify appending further conditions

// Check if 'property-status' is set and not the 'rentandsale' default value
if (!empty($_GET['property-status']) && $_GET['property-status'] !== 'rentandsale') {
    $isForSaleValue = $_GET['property-status'] === 'sale' ? 1 : 0;
    $sql .= " AND is_for_sale = {$isForSaleValue}";
}

// Check if 'property-type' is set and not the default value
if (!empty($_GET['property-type']) && $_GET['property-type'] !== 'defaulttype') {
    $propertyType = $_GET['property-type'];
    $sql .= " AND type = '{$propertyType}'";
}

// Check if 'location' is set and not empty
if (!empty($_GET['location'])) {
    $location = $_GET['location'];
    $sql .= " AND city LIKE '%{$location}%'";
}

// Check if 'bedrooms' is set and not the default value
if (!empty($_GET['bedrooms']) && $_GET['bedrooms'] !== 'bedroom0') {
    $bedrooms = substr($_GET['bedrooms'], -1);  // Gets the last character which is the number of bedrooms
    $sql .= " AND rooms = '{$bedrooms}'";
}

// Check if 'bathroom' is set and not the default value
if (!empty($_GET['bathroom']) && $_GET['bathroom'] !== 'bathroom0') {
    $bathroom = substr($_GET['bathroom'], -1);  // Gets the last character which is the number of bathrooms
    $sql .= " AND bath_rooms = '{$bathroom}'";
}

// Check if 'condition' is set and not the default value
if (!empty($_GET['condition']) && $_GET['condition'] !== 'defaultcondition') {
    $condition = $_GET['condition'];
    $sql .= " AND property_condition = '{$condition}'";
}

// Checkboxes
if (isset($_GET['garage'])) {
    $sql .= " AND has_garage = 1";
}

if (isset($_GET['pool'])) {
    $sql .= " AND pool = 1";
}

if (isset($_GET['wifi'])) {
    $sql .= " AND has_wifi = 1";
}


if (isset($_GET['min_area']) && isset($_GET['max_area'])) {
    $minPrice = $_GET['min_area'];
    $maxPrice = $_GET['max_area'];
    $sql .= " AND size BETWEEN '{$minPrice}' AND '{$maxPrice}'";
}


if (isset($_GET['min_price']) && isset($_GET['max_price'])) {
    $minPrice = $_GET['min_price'];
    $maxPrice = $_GET['max_price'];
    $sql .= " AND price BETWEEN '{$minPrice}' AND '{$maxPrice}'";
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

$sql .= " ORDER BY $sortOrder;";
//echo htmlspecialchars($sql); the sql query
$result = $con->query($sql);


function display_picture($id) {
    global $con; // Ensure that $con is accessible within the function

    // Sanitize the $id to prevent SQL injection if not done earlier
    $id = $con->real_escape_string($id);

    $getSaleOrRent = "SELECT * FROM PROPERTY WHERE id = '$id';";
    $propertyResult = $con->query($getSaleOrRent);

    $propertyExists = $propertyResult->num_rows > 0;
    $propertyRow = $propertyExists ? $propertyResult->fetch_assoc() : null;

    $sql = "SELECT * FROM PICTURE WHERE property_id = '$id' LIMIT 1;";
    $result = $con->query($sql);

    $pictureExists = $result->num_rows > 0;
    if ($pictureExists) {
        $row = $result->fetch_assoc();
        return $row["filename"];
    } else {
        if ($propertyExists) {
            if ($propertyRow["is_for_sale"] == '1') {
                return "property_pics/default_sale.jpeg";
            } else {
                return "property_pics/default_rent.jpeg";
            }
        }
        return "property_pics/default_rent.jpeg"; // A default image if no property is found
    }
}


echo $sql;

?>

<script>
    function sortProperties(sortBy) {
        let existingParams = new URLSearchParams(window.location.search);
        existingParams.set('sort', sortBy);
        window.location.href = window.location.pathname + '?' + existingParams.toString();
    }

</script>

<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Keresés az ingatlanok között</title>
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
            <h1>Keresés</h1>
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
                                <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Legújabb elöl</option>
                                <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : ''; ?>>Legrégebbi elöl</option>
                                <option value="highest_price" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'highest_price') ? 'selected' : ''; ?>>Ár (Legdrágább elöl)</option>
                                <option value="lowest_price" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'lowest_price') ? 'selected' : ''; ?>>Ár (Legolcsóbb elöl)</option>
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
                                        <img src="<?php echo display_picture($row['id']); ?>"
                                             alt="properties" class="img-fluid">
                                        <div class="listing-badges">
                                            <span class="listing-time">
                                                <?php if ($row["is_for_sale"] == 1) echo "Eladó";
                                                else echo "Kiadó"; ?>
                                            </span>
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
                    <h1>Nincs a keresésnek megfelelő ingatlanunk!</h1>
                <?php } ?>

            </div>

            <div class="col-lg-4 col-md-12">
                <div class="sidebar-right">
                    <!-- Advanced search start -->
                    <?php
                    function select_DISTINCT_into_asoc_array($what_to_select)
                    {
                        $assoc_array = [];
                        global $con;
                        $saq = "type";
                        $sql_for_search = "SELECT DISTINCT  $what_to_select FROM PROPERTY WHERE is_for_sale = 1 ORDER BY $what_to_select ASC;";
                        $result_for_search = $con->query($sql_for_search);


                        if ($result_for_search->num_rows > 0) {
                            while ($row_for_search = $result_for_search->fetch_assoc()) {

                                //$assoc_array +=  $row_for_search[$what_to_select];
                                //$assoc_array[] +=  $row_for_search[$what_to_select];
                                echo "<option>" . $row_for_search[$what_to_select];
                                "</option>";
                            }
                        }
                        return $assoc_array;
                    }

                    ?>


                    <div class="sidebar widget advanced-search">
                        <h3 class="sidebar-title">Részletes keresés</h3>
                        <div class="s-border"></div>
                        <div class="m-border"></div>
                        <?php  include 'searchfield.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.html';
$con->close();?>


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