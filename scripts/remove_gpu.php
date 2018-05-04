<?php
require "db.php";
$gpu_name = $_POST['gpu_name'];
$stmt = $dbh->prepare("DELETE FROM GPU WHERE name=?");
$result = $stmt->execute(array($gpu_name));