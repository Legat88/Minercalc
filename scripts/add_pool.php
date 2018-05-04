<?php
require "db.php";
$pool_name = $_POST['pool_name'];
$coin = $_POST['coin'];
$address = $_POST['address'];
$port = $_POST['port'];

$stmt = $dbh->prepare("INSERT INTO pools (name, address, port, coin) VALUES (?, ?, ?, ?)");
$stmt->execute(array($pool_name, $address, $port, $coin));
