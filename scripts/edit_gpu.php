<?php
require "db.php";
$gpu_name=$_POST['gpu_name'];
$tdp = $_POST['tdp'];
$algos = array_slice($_POST, 2);
foreach ($algos as $algo=>$value) {
    if ($value !=NULL) {
        $new_array_result[]=$algo.'='.$value;
    }
}
$result=implode(', ', $new_array_result);
$query = "UPDATE GPU SET tdp=$tdp, $result WHERE name='$gpu_name'";
$dbh->query($query);
