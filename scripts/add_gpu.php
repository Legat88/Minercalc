<?php
require "db.php";
$gpu_name=$_POST['gpu_name'];
$tdp = $_POST['tdp'];
$algos = array_slice($_POST, 2);
foreach ($algos as $algo=>$value) {
    if ($value !=NULL) {
        $new_array_algo[]=$algo;
        $new_array_hashes[]=$value;
    }
}
$algos=implode(', ', $new_array_algo);
$hashes=implode(', ', $new_array_hashes);
$dbh->query("INSERT INTO GPU (name, tdp, $algos) VALUES ('$gpu_name', $tdp, $hashes)");
