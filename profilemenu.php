<?php
session_start();
require "dbconfig.php";
global $username;
?>

<div class="clearfix">
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
