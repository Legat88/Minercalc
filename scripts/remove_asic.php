<?php
require "db.php";
$asic_name = $_POST['asic_name'];
$stmt = $dbh->prepare("DELETE FROM ASIC WHERE name=?");
$result = $stmt->execute(array($asic_name));