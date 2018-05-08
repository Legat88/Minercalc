<?php
require "db.php";
$algo_name=$_POST['algo_name'];
$stmt=$dbh->prepare("DELETE FROM algos WHERE name=?");
$result=$stmt->execute(array($algo_name));
$stmt = $dbh->query("ALTER TABLE GPU DROP $algo_name");
$stmt = $dbh->query("ALTER TABLE ASIC DROP $algo_name");