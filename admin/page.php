<?php
$do= "";
if(isset($_GET['do'])){
    $do = $_GET['do'];
}else{
    // echo "sorry";
    $do = "manage";
}


if($do == "manage"){
    echo "hello from". $do . " page" . "<br>";
    echo "<a href='?do=add'>add member</a>";
}elseif($do == "add"){
    echo "hello from ". $do . " page" ."<br>";
    echo "<a href='?do=insert'>insert member</a>";
}elseif($do == 'insert'){
    echo "hello from ". $do . " page";
}elseif($do == 'edit'){
    echo "hello from ". $do . " page";
}elseif($do == 'update'){
    echo "hello from ". $do . " page";
}elseif($do == 'delete'){
    echo "hello from ". $do . " page";
}elseif($do == 'show'){
    echo "hello from ". $do . " page";
}