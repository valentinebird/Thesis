<?php
require "../dbconfig.php";
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "image/" . $filename;

    $db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    // Get all the submitted data from the form
    //$sql = "INSERT INTO  (property_name,is_for_sale,price,city,address,size,level_number,rooms,bath_rooms,type,property_condition,heating_type,has_garage,pool,has_wifi,property_description,photo_filename,agent_id,is_sold) VALUES ('TEST',1,100,'London','Oxford Street 3',100,2,3,4,'Rent','Új','Gáz',0,0,1,'Szép ház Londonban','filename',1,0); ";
    $sql = "INSERT INTO image (filename) VALUES ('$filename')";

    // Execute query
    mysqli_query($db, $sql);

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        $msg = "Image uploaded successfully";
        echo "Image uploaded successfully";
    } else {
        echo "Failed to upload image";
    }


    $result = mysqli_query($db, "SELECT * FROM image");
    while ($data = mysqli_fetch_array($result)) {

        ?>
        <img src="<?php echo $data['Filename']; ?>">

        <?php
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<div id="content">

    <form method="POST" action="" enctype="multipart/form-data">
        <input type="file" name="uploadfile" value=""/>

        <div>
            <button type="submit" name="upload">UPLOAD</button>
        </div>
    </form>
</div>
</body>
</html>