<?php
require "db.php";
$algo_name = $_POST['algo_name'];
$measure = $_POST['measure'];
$miner = $_POST['miner'];
$query = "UPDATE algos SET measure='$measure', miner='$miner' WHERE name='$algo_name'";
$dbh->query($query);
