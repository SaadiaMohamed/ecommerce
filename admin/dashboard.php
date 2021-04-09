<?php session_start()?>
<?php if(isset($_SESSION['USER_NAME'])):?>

<!-- write all dashboard html -->
<?php include "resources/function.php" ?>
<?php include "resources/includes/header.inc"?>
<?php require "config.php"?>
<?php include "resources/includes/navbar.inc" ?>
<div class="container">
    <div class="row">
    <div class="col-lg-4">
    <div class="members">
        <i class="fas fa-users"></i>
        <?= countItem("user_id", "users","groupid=0" )?>
        <br>
        <i class="fas fa-shopping-cart"></i>
        <?= countItem("product_id" , "products" , "categoryid=0")?>

    </div>
    </div>

    </div>
</div>

<?php include "resources/includes/footer.inc"?>
<!-- end of page -->
<?php else:?>
<?php header("location:index.php")?>
<?php endif?>

