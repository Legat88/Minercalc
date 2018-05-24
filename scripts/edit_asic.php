<?php
require "db.php";
$asic_name=$_POST['asic_name'];
$tdp = $_POST['tdp'];
$algos = array_slice($_POST, 2);
foreach ($algos as $algo=>$value) {
    if ($value !=NULL) {
        $new_array_result[]=$algo.'='.$value;
    }
}
$result=implode(', ', $new_array_result);
$query = "UPDATE ASIC SET tdp=$tdp, $result WHERE name='$asic_name'";
$dbh->query($query);
