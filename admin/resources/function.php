<?php
    function countItem($id,$table,$condition = null){
        global $con;
        if($condition == "groupid =0"){
            $stmt = $con->prepare("SELECT COUNT($id) FROM $table WHERE condition");
            $stmt->execute();
            $count=$stmt->fetchColumn();
            return $count;
        }else{
            $stmt = $con->prepare("SELECT COUNT($id) FROM $table");
            $stmt->execute();
            $count=$stmt->fetchColumn();
            return $count;
        }
        
    }  
?>

<?php
    // function countItem($id){
    //     global $con;
    //     $tablenames=array("users","products");
    //     foreach($tablenames as $table){
    //         if($table == "users WHERE groupid=0"){
    //             $stmt = $con->prepare("SELECT COUNT($id) FROM users");
    //             $stmt->execute();
    //             $count=$stmt->fetchColumn();
    //             return $count;
    //         }elseif($table == "products WHERE categoryid=0"){
    //             $stmt = $con->prepare("SELECT COUNT($id) FROM products");
    //             $stmt->execute();
    //             $count=$stmt->fetchColumn();
    //             return $count;
    //         }
    //     }
    // }  
?>




<?php

// function countItem(){
// global $con;
// $stmt2 = $con->prepare("SELECT
// (SELECT COUNT(*) FROM users WHERE groupid=0) as table1Count, 
// (SELECT COUNT(*) FROM products WHERE categoryid=2) as table2Count");
// $stmt2->execute();
// $count=$stmt2->fetchColumn();
// return $count;
// }
?>


<?php


?>