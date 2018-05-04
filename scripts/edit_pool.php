<?php
require "db.php";
$pool_name = $_POST['pool'];
$coin = $_POST['coin'];
$address = $_POST['address'];
$port = $_POST['port'];
$stmt = $dbh->prepare("UPDATE pools SET address=?, port=? WHERE name=? AND coin=?");
$stmt->execute(array($address, $port, $pool_name, $coin));