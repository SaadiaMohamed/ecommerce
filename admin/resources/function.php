<?php
    // function countItem($id,$table){
    //     global $con;
    //     $stmt = $con->prepare("SELECT COUNT($id) FROM $table WHERE groupid=0");
    //     $stmt->execute();
    //     $count=$stmt->fetchColumn();
    //     return $count;
    // }  
?>


<?php
function countItem(){
global $con;
$stmt2 = $con->prepare("SELECT COUNT(*) FROM users WHERE groupid=0
UNION
SELECT COUNT(*) FROM products WHERE categoryid=2");
$stmt2->execute();
$count=$stmt2->fetchColumn();
return $count;
}
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