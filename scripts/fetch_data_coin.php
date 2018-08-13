<?php
require "db.php";
if(isset($_POST['get_coin'])) {
    $coin = $_POST['get_coin'];
    $stmt = $dbh->prepare("SELECT rpc FROM coins WHERE name=?");
    $stmt->execute(array($coin));
    $rpc = $stmt->fetch(PDO::FETCH_LAZY);
    if ($rpc['rpc'] == 0) {
        $stmt = $dbh->prepare("SELECT code, algo, block_reward, url, parameter, addition, rpc, coinmarketcap FROM coins WHERE name=?");
        $stmt->execute(array($coin)); //Обязательно массив, строку не возьмет
        $result = $stmt->fetch(PDO::FETCH_LAZY);
    } else {
        $stmt = $dbh->prepare("SELECT code, algo, block_reward, rpc, rpcuser, rpcpassword, rpcport, rpc_method, rpc_parameter, coinmarketcap FROM coins WHERE name=?");
        $stmt->execute(array($coin)); //Обязательно массив, строку не возьмет
        $result = $stmt->fetch(PDO::FETCH_LAZY);
    }
    header('Content-type: application/json');
    echo json_encode($result);
}