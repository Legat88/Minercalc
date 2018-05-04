<?php
require "db.php";
$gpu_name = $_POST['gpu_name'];
$algos = array_slice($_POST, 1);
foreach ($algos as $algo => $value) {
    if ($value != NULL) {
        $new_array_algo[] = $algo;
        $new_array_hashes[] = $value;
    }
}
$algos = implode(', ', $new_array_algo);
$hashes = implode(', ', $new_array_hashes);
$dbh->query("INSERT INTO GPU (name, $algos) VALUES ('$gpu_name', $hashes)");
