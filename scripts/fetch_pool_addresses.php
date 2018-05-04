<?php
require "db.php";
$pool_name=$_POST['pool_name'];
$coin_name=$_POST['coin_name'];
$stmt=$dbh->prepare("SELECT address, port FROM pools WHERE name=? AND coin=?");
$stmt->execute(array($pool_name, $coin_name));
$result = $stmt->fetch(PDO::FETCH_LAZY);
header('Content-type: application/json');
echo json_encode($result);
