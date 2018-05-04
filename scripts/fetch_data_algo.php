<?php
require "db.php";
if (isset($_POST['get_algo'])) {
    $algo = $_POST['get_algo'];
    $stmt = $dbh->prepare("SELECT measure, miner FROM algos WHERE name=?");
    $stmt->execute(array($algo)); //Обязательно массив, строку не возьмет
    $result = $stmt->fetch(PDO::FETCH_LAZY);
    header('Content-type: application/json');
    echo json_encode($result);
}