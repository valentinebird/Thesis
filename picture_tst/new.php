<?php
$output = [];
$eredmeny = [];

function exists($key)
{
    return (isset($_GET[$key]));
}

if (exists(num_children)) {
    $children = $_GET["num_children"];
    $eredmeny["num_children"] = $_GET["num_children"];
    if (intval($_GET["num_children"]) > 0) {

    } else {
        $output_c = "Number of children must be positive ineger!";
        $output["num_children"] = "Number of children must be positive ineger!";
    }
} else {
    $children = "";
    $output_c = "Number of children must be specified";
    $output["num_children"] = "Number of children must be specified";
}


if (exists(children_names)) {
    $cnames = $_GET["children_names"];
    $eredmeny["children_names"] = $_GET["children_names"];
    if (substr_count($_GET["children_names"], ",") + 1 < intval($_GET["num_children"])) {
        $gyerror = "Túl kevés gyerek! cnt" . substr_count($_GET["children_names"], ",") + 1 . "oval " . intval($_GET["num_children"]);
        $output["children_names"] = "Túl kevés gyerek! cnt" . substr_count($_GET["children_names"], ",") + 1 . "oval " . intval($_GET["num_children"]);;
    }
} else {
    $cnames = "";
    $gyerror = "Number of childrens cannot be empty!";
    $output["children_names"] = "Number of childrens cannot be empty!";
}


if (exists(music_url)) {
    $music_url = $_GET["music_url"];
    $eredmeny["music_url"] = $_GET["music_url"];
    if (filter_var($music_url, FILTER_VALIDATE_URL) === FALSE) {
        $link_error = "Link not valid!";
        $output["music_url"] = "Link not valid!";
    }


} else {
    $music_url = "";
    $link_error = "URl cannot be empty";
    $output["music_url"] = "URl cannot be empty";
}


if (exists(performance_type)) {
    $ptype = $_GET["performance_type"];
    $eredmeny["performance_type"] = $_GET["performance_type"];
    if ($_GET["performance_type"] == "poem" or $_GET["performance_type"] == "song") {

        //okay
    }else{
        $pterror = "performance_type must be song or poem";
        $output["performance_type"] = "performance_type must be song or poem";
    }


} else {
    $ptype = "";

    $pterror = "performance_type cannot be empty";
    $output["performance_type"] = "performance_type cannot be empty";
}


if (isset($_GET['ready'])) {

} else {
    $readyerror = "Everyone must be ready!";
    $output['ready'] = "Everyone must be ready!";
}



function hibasE($kulcs){
    global $output;
    return in_array($kulcs, array_keys($output));
}

function allapottarto($kulcs){
    global $output;
    global $eredmeny;
    return count($output)>0 || hasError($kulcs) ? '' : $eredmeny[$kulcs];
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Performance</title>
</head>
<body>
<h1>Performance</h1>
<form action="index.php" method="get" novalidate>
    <br>
    <label for="i1">Number of children:</label> <input type="text" name="num_children" id="i1" value="<?=stateHolder("num_children")?>">   <span style="color:red"> <?php echo $output_c; ?> </span>
    <br>
    <label for="i2">Children's names:</label> <input type="text" name="children_names" id="i2" value="<?=stateHolder("children_names")?>">  <span style="color:red"> <?php echo $gyerror; ?></span>
    <br>
    <label for="i3">URL of music to be played:</label> <input type="text" name="music_url" id="i3" value="<?=stateHolder("music_url")?>">  <span style="color:red"><?php echo $link_error; ?>  </span><br>
    <label for="i4">Performance type:</label> <input type="text" name="performance_type" id="i4" value="<?=stateHolder("performance_type")?>"> <span style="color:red"> <?php echo $pterror; ?> </span> <br>
    <input type="checkbox" name="ready" id="i5" value="<?=stateHolder("ready")?>"><label for="i5">Everyone is ready</label>  <span style="color:red"> <?php echo $readyerror; ?> </span>
    <br>
    <button type="submit">Submit</button>
</form>
<?php
if(count($output)<=0 ){

    ?>
    <div class="merry">🎄 MERRY CHRISTMAS AND HAPPY NEW YEAR! 🎄</div>
<?php   } ?>




<h2>Test cases</h2>
<a href="index.php?num_children=&children_names=&music_url=&performance_type=">num_children=&children_names=&music_url=&performance_type=</a><br>
<a href="index.php?num_children=n&children_names=&music_url=&performance_type=">num_children=n&children_names=&music_url=&performance_type=</a><br>
<a href="index.php?num_children=6.7&children_names=&music_url=&performance_type=">num_children=6.7&children_names=&music_url=&performance_type=</a><br>
<a href="index.php?num_children=0&children_names=&music_url=&performance_type=">num_children=0&children_names=&music_url=&performance_type=</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara&music_url=&performance_type=">num_children=3&children_names=Adam%2CBarbara&music_url=&performance_type=</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=&performance_type=">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=&performance_type=</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=5c3ezwen&performance_type=">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=5c3ezwen&performance_type=</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=good">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=good</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=song">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=song</a><br>
<a href="index.php?num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=song&ready=on">num_children=3&children_names=Adam%2CBarbara%2CChloe&music_url=http%3A%2F%2Ftinyurl.com%2F5c3ezwen&performance_type=song&ready=on</a><br>
</body>
</html>