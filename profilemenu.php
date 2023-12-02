<?php
session_start();
require "dbconfig.php";

?>
<div class="col-lg-4 col-md-12 col-sm-12">
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
                    <a href="my-profile.html" class="active">
                        <i class="flaticon-people"></i>Profilom
                    </a>
                </li>
                <li>
                    <a href="favorited-properties.php">
                        <i class="flaticon-favorite"></i>Kedvecnek jelölt ingatlanok
                    </a>
                </li>
                <li>
                    <a href="my-properties.html">
                        <i class="flaticon-internet"></i>Ingatlanjaim
                    </a>
                </li>
                <li>
                    <a href="submit-property.php">
                        <i class="flaticon-cross"></i>Új ingatlan feltöltése
                    </a>
                </li>
                <li>
                    <a href="change-password.html">
                        <i class="flaticon-lock"></i>Jelszó változtatás
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="flaticon-exit"></i>Kijelentkezés
                    </a>
                </li>
            </ul>
        </div>
        <!-- My account box end -->
    </div>
</div>