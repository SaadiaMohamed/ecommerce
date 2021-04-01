<?php session_start()?>
  <?php include "resources/includes/header.inc"?>
  <?php require "config.php"?>
  <?php
    if($_SERVER['REQUEST_METHOD']=="POST"){
      $adminUsername = $_POST['adminusername'];
      $adminPassword = $_POST['adminpassword'];
      $hashedPass = sha1($adminPassword);

      $stmt = $con->prepare("SELECT * FROM users WHERE username=? AND password=? AND groupid = 1");
      $stmt->execute(array($adminUsername , $hashedPass));
      $row = $stmt->fetch();
      // fetchAll()
      $count = $stmt->rowCount();

      echo "<pre>";
      print_r($row);
      echo "</pre>";
   
      $in_DB = 1;
      if($count == $in_DB ){
        // or $_SESSION['USER_NAME']= $row['username'];
        $_SESSION['USER_NAME']=$adminUsername;
        $_SESSION['USER_ID']= $row['user_id'];
        $_SESSION['FULL_NAME']= $row['fullname'];
        $_SESSION['GOUP_ID']= $row['groupid'];
          header("location:dashboard.php");
          exit();
      }else{
        echo "check username and password";
      }
    }
  ?>

<div class="login">
<h1 class="text-center">Admin login</h1>
<div class="container">
<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">User Name</label>
    <input type="text" class="form-control" name="adminusername">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="adminpassword">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
<?php include "resources/includes/footer.inc"?>