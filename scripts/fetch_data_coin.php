<?php
require "db.php";
if (isset($_POST['get_coin'])) {
    $coin = $_POST['get_coin'];
    $stmt = $dbh->prepare("SELECT code, algo, block_reward, url, parameter, addition FROM coins WHERE name=?");
    $stmt->execute(array($coin)); //Обязательно массив, строку не возьмет
    $result = $stmt->fetch(PDO::FETCH_LAZY);
    header('Content-type: application/json');
    echo json_encode($result);
}