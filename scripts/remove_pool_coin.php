<?php
require "db.php";
$pool_name = $_POST['pool_name'];
$coin_name = $_POST['coin_name'];
$stmt = $dbh->prepare("DELETE FROM pools WHERE name=? AND coin=?");
$stmt->execute(array($pool_name, $coin_name));