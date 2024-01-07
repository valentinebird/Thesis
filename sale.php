<?php
session_start();
require "dbconfig.php";
global $con;

$sortOrder = 'upload_date DESC'; // Assuming 'id DESC' as default (newest first)

// Check if a sort option is set and update sortOrder accordingly
if (!empty($_GET['sort'])) {
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

//$sql = "SELECT id,username, email, reg_date FROM USER;";
$sql = "SELECT * FROM PROPERTY WHERE is_for_sale = 1 ORDER BY $sortOrder;";
$result = $con->query($sql);

function display_first_sale_picture($id){
    global $con; // Ensure that $con is accessible within the function
    $sql = "SELECT * FROM PICTURE WHERE property_id = $id LIMIT 1;";
    $result = $con->query($sql);
    $pictureExists = $result->num_rows > 0;
    if ($pictureExists) {
        $row = $result->fetch_assoc();
        return $row["filename"];
    } else {
        return "property_pics/default_sale.jpeg";
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
        <title>Eladó ingatlanok listája</title>
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
                <h1>Eladó ingatlanjaink listája</h1>
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
                                            <img src="<?php echo display_first_sale_picture($row['id']); ?>" alt="properties" class="img-fluid">
                                            <div class="listing-badges">
                                                <span class="listing-time">Eladó</span>
                                            </div>
                                            <div class="price-box"><?php echo $row["price"]; ?><small>/ Ft</small></div>
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
                                            <div class="pull-right">
                                                <a><i class="flaticon-time"></i> <?php echo $row["upload_date"]; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <h1>Jelenleg nincsen eladó ingatlanunk! </h1>
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
                            <?php include 'searchfield.php'; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer start -->
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

<?php $con->close(); ?>