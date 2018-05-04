<?php
require "db.php";
$algo_name=$_POST['algo_name'];
$stmt=$dbh->prepare("DELETE FROM algos WHERE name=?");
$result=$stmt->execute(array($algo_name));