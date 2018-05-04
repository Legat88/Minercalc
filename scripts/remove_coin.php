<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$stmt=$dbh->prepare("SELECT code FROM coins WHERE name=?");
$stmt->execute(array($coin_name));
$code_q=$stmt->fetch(PDO::FETCH_LAZY);
$code=$code_q['code'];
$stmt=$dbh->query("ALTER TABLE difficulty DROP $code");
$stmt=$dbh->prepare("DELETE FROM coins WHERE name=?");
$stmt->execute(array($coin_name));