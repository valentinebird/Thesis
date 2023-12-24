<?php
session_start();
require "dbconfig.php";
global $username;
?>

<div class="clearfix">
    <!-- Avatar start -->
    <div class="edit-profile-photo">
        <img src="http://placehold.it/350x350" alt="profile-photo" class="img-fluid">
        <div class="change-photo-btn">
            <div class="photoUpload">
                <span><i class="fa fa-upload"></i> Upload Photo</span>
                <input type="file" class="upload">
            </div>
        </div>
    </div>
    <!-- Avatar end -->
    <!-- My account box start -->
    <div class="my-account-box">
        <ul>
            <li>
                <a href="profile.php" class="active">
                    <i class="flaticon-people"></i>Profilom: <?php echo $username; ?>
                </a>
            </li>
            <?php if (!$_SESSION['is_agent']) { ?>
                <li>
                    <a href="favorited-properties.php">
                        <i class="flaticon-favorite"></i>Kedvecnek jelölt ingatlanok
                    </a>
                </li>
            <?php } ?>


            <?php if ($_SESSION['is_agent']) { ?>
                <li>
                    <a href="my-properties.php">
                        <i class="flaticon-internet"></i>Meghirdetett ingatlanjaim
                    </a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['is_agent']) { ?>
                <li>
                    <a href="submit-property.php">
                        <i class="flaticon-cross"></i>Új ingatlan feltöltése
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="change-password.php">
                    <i class="flaticon-lock"></i>Jelszó változtatás
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="flaticon-exit"></i>Kijelentkezés
                </a>
            </li>
        </ul>
    </div>
    <!-- My account box end -->
</div>
