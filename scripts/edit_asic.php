<?php
require "db.php";
$asic_name=$_POST['asic_name'];
$algos=array_slice($_POST, 1);
foreach ($algos as $algo=>$value) {
    if ($value !=NULL) {
        $new_array_result[]=$algo.'='.$value;
    }
}
$result=implode(', ', $new_array_result);
$query="UPDATE ASIC SET $result WHERE name='$asic_name'";
$dbh->query($query);
