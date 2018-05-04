<?php
require "db.php";
$gpu_name = $_POST['gpu_name'];
$algos = array_slice($_POST, 1);
foreach ($algos as $algo => $value) {
    if ($value != NULL) {
        $new_array_result[] = $algo . '=' . $value;
    }
}
$result = implode(', ', $new_array_result);
$query = "UPDATE GPU SET $result WHERE name='$gpu_name'";
$dbh->query($query);
