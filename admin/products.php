<?php
session_start();
$do = "";
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    $do="manage";
}
?>
<?php if(isset($_SESSION['USER_NAME'])): ?>
        <?php include "resources/includes/header.inc"?>
        <?php require "config.php"?>
        <?php include "resources/includes/navbar.inc"?>

<!-- start products CURD page -->
<?php if($do == "manage"):?>
<!-- start all products page-->
<?php
/* to display the category name instead of cat_id using the join between products and 
    categories tables*/
    $stmt = $con->prepare("SELECT products.* , categories.cat_name FROM products
                            INNER JOIN categories ON categories.cat_id=products.cat_id
                        ");
    $stmt -> execute();
    $products = $stmt->fetchAll();

    // echo "<pre>";
    // print_r($products);
    // echo "</pre>";
    // exit();


?>

<div class="container">
    <h1 class="text-center">All Products</h1>
    <a class="btn btn-primary" href="?do=add"><i class="fas fa-user-plus"></i></a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">photo</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Price</th>
                <th scope="col">Description</th>
                <th scope="col">category</th>
                <th scope="col">control</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product):?>
            <tr>
                <!-- php echo => = -->
                <th scope="row">
                    <img style="height:15vh" src="public\imgs\uploads\products\<?= $product['path']?>" alt="<?= $product['path']?>">
                </th>
                <th scope="row"><?=$product['product_name'] ?></th>
                <td><?=$product['product_price']?></td>
                <td><?=$product['product_desc']?></td>
                <td><?=$product['cat_name']?></td>

                <td>
                    <a class="btn btn-info m-1" href="?do=show&productid=<?= $product['product_id']?>" title="Show">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a class="btn btn-warning m-1" href="?do=edit&productid=<?= $product['product_id']?>" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="btn btn-danger m-1" href="?do=delete&productid=<?= $product['product_id']?>" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach?>
        </tbody>
    </table>

</div>
<!--  all products page-->

<?php elseif($do == 'add'):?>
<!-- start add products page-->
<div class="container">
    <h1 class="text-center">Add Product</h1>
    <form method="post" action="?do=insert" enctype="multipart/form-data">
         <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" name="productName">
        </div>
        <div class="mb-3">
            <label class="form-label">Product price</label>
            <input type="text" class="form-control" name="productPrice">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control" name="desc">
        </div>
        <?php
            $stmt=$con->prepare("SELECT * FROM categories");
            $stmt->execute();
            $categories = $stmt->fetchAll();
        ?>
        <div class="mb-3">
        <select class="form-select" name="category">
            <option selected>Select Category</option>
            <?php foreach($categories as $category):?>
            <option value="<?=$category['cat_id']?>"><?= $category['cat_name'] ?></option>
            <?php endforeach?>
        </select>
        </div>
        <div class="mb-3">
  <label for="formFile" class="form-label">upload photo</label>
  <input class="form-control" type="file" id="formFile" name="avatar">
</div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php elseif($do == 'insert'):?>
<!-- start insert products page-->
<?php 
            if($_SERVER['REQUEST_METHOD']=="POST"){
                // get the photo informations in an array
                // $avatar = $_FILES['avatar'];
                // will call every single data in a variable
                $avatarName = $_FILES['avatar']['name'];
                $avatarType = $_FILES['avatar']['type'];
                $avatarTmpName = $_FILES['avatar']['tmp_name'];
                $avatarError = $_FILES['avatar']['error'];
                $avatarSize = $_FILES['avatar']['size'];


                // echo "<pre>";
                // print_r($avatar);
                // echo "</pre>";

                // to allow downloading only the img
                $avatarAllowedExtension = array("image/jpeg" , "image/png", "img/gif");
                if(in_array($avatarType , $avatarAllowedExtension)){
                    $avatar = rand(0 , 1000)."_".$avatarName;
                    // move_uploaded_file("$destination");
                     $destination = "public\imgs\uploads\products\\".$avatar;
                     move_uploaded_file($avatarTmpName ,$destination);
                }

                $productName = $_POST['productName'];
                $productPrice = $_POST['productPrice'];
                $productDesc = $_POST['desc'];
                $category=$_POST['category'];


                // start backend validation
        $formErrors = array();
        if(empty($productName)){
            $formErrors[]="productname must be not empty";
        }
        if(strlen($productName) > 20){
            $formErrors[]="productname must be not greater than 20";
        }
              // foreach($formErrors as $error){
        //     echo $error . "<br>";
        // }
        // end backend validation
        if(empty($formErrors)){
                $stmt = $con -> prepare("INSERT INTO products(product_name,product_price,path,product_desc,cat_id) VALUES (?,?,?,?,?)");
                $stmt -> execute(array($productName, $productPrice,$avatar, $productDesc,$category));
                header("location:products.php?do=add");
            }else{
                foreach($formErrors as $error){
                    echo $error ."<br>";
                    exit();
                 }
            }
        }else{
            header("location:products.php");
        }
        ?>



<?php elseif($do == "edit"):?>
        <?php 
            $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;
            $stmt = $con -> prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt -> execute(array($productid));
            $product = $stmt->fetch();
            $count = $stmt -> rowCount();
        ?>
        <?php if($count == 1):?>
        <div class="container">
            <h1 class="text-center">Edit Product</h1>
            <form method="post" action="?do=update">
                <div class="mb-3">
                <input type="hidden" class="form-control" value="<?= $product['product_id']?>" name="productid">
                <label for="exampleInputEmail1" class="form-label">Product Category</label>
                <input type="text" class="form-control" value="<?= $product['product_category']?>" name="productcategory">
                </div>
                <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Product Name</label> 
                <input type="text" class="form-control" value="<?= $product['product_name']?>" name="productName">
                </div>
                <div class="mb-3">
                 <label for="exampleInputEmail1" class="form-label">Product Price</label> 
                <input type="text" class="form-control" value="<?= $product['product_price']?>" name="productprice">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        <?php endif?>

        <?php elseif($do == "update"):?>
            <?php 
                if($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    $productid =$_POST['productid'];
                    $productName =$_POST['productName'];
                    $productCategory =$_POST['productcategory'];
                    $productPrice =$_POST['productprice'];
                    $stmt = $con -> prepare("UPDATE products SET product_category=? , product_name=? , product_price=? WHERE product_id=?");
                    $stmt -> execute(array($productCategory , $productName , $productPrice , $productid));
                    header("location:products.php");
                }
            ?>

<?php elseif($do == 'delete'):?>
<?php
    $productid=$_GET['productid'];
    $stmt =$con->prepare("DELETE FROM products WHERE product_id =?");
    $stmt->execute(array($productid));
    header("location:products.php");
?>

<?php elseif($do == 'show'):?>
<!-- start show products page-->
    <?php 
     $productid = $_GET['productid'];
        $stmt = $con->prepare("SELECT * FROM products WHERE product_id=?");
        $stmt->execute(array($productid));
        $product = $stmt->fetch();

        echo"<pre>";
        print_r($product);
        echo"</pre>";
     ?>
     <a href="products.php" class="btn btn-dark m-2">Back</a>
<?php endif?>

<?php include "resources/includes/footer.inc"?>
<?php else:?>
<?php header("location:index.php") ?>
<?php endif?>