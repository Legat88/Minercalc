<?php
require "db.php";
$pool_name = $_POST['pool_name'];
$stmt = $dbh->prepare("SELECT coin FROM pools WHERE name=?");
$stmt->execute(array($pool_name));

while ($coin_q = $stmt->fetch(PDO::FETCH_LAZY)) {
    $coin[] = $coin_q['coin'];
}
//foreach ($coin as $c) {
//    echo "<option>".$c."</option>";
//}
header('Content-type: application/json');
echo json_encode($coin);
