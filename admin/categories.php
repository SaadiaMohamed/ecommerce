<?php
    session_start();
    $do=isset($_GET['do'])?$_GET['do']:"manage";
?>

<?php require "config.php"?>
<?php require "resources/includes/header.inc"?>
<?php require "resources/includes/navbar.inc"?>

<?php if($do =="manage") ?>
<?php elseif($do == "add") ?>
<?php elseif($do == "insert") ?>
<?php elseif($do == "edit") ?>
<?php elseif($do == "update") ?>
<?php elseif($do == "delete") ?>
<?php elseif($do == "show") ?>
<?php else:?>
<?php
    header("location:index.php");
?>
<?php endif ?>
<?php require "resources/includes/footer.inc"?>
