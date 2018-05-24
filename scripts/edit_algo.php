<?php
require "db.php";
$algo_name=$_POST['algo_name'];
$measure=$_POST['measure'];
$miner=$_POST['miner'];
$coef = $_POST['power_coef'];
$query = "UPDATE algos SET measure='$measure', miner='$miner', power_coef=$coef WHERE name='$algo_name'";
$dbh->query($query);
