<?php
require "db.php";
$algo_name = $_POST['algo_name'];
$measure = $_POST['measure'];
$miner = $_POST['miner'];
$dbh->query("INSERT INTO algos (name, measure, miner) VALUES ('$algo_name', '$measure', '$miner')");
$dbh->query("ALTER TABLE GPU ADD $algo_name INT(11)");
$dbh->query("ALTER TABLE ASIC ADD $algo_name INT(11)");
