<?php
require "db.php";
$pool_name=$_POST['pool_name'];
$stmt=$dbh->prepare("DELETE FROM pools WHERE name=?");
$stmt->execute(array($pool_name));