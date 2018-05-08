<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$coin_for_api = str_replace(" ", "-", $coin_name);
$url='https://api.coinmarketcap.com/v1/ticker/'.$coin_for_api;
$data=file_get_contents($url);
$info = json_decode($data, true);
$price=$info[0]['price_usd'];
$code=$_POST['code'];
$algo=$_POST['algo'];
$blockreward=$_POST['blockreward'];
if (isset($_POST['rpc'])) {
    $rpc = 1;
    $rpcuser = $_POST['rpcuser'];
    $rpcpassword = $_POST['rpcpassword'];
    $rpcport = $_POST['rpcport'];
    $rpc_method = $_POST['rpc_method'];
    $rpc_parameter = $_POST['rpc_parameter'];
    $stmt = $dbh->prepare("INSERT INTO coins (name, code, algo, block_reward, rpc, rpcuser, rpcpassword, rpcport, rpc_method, rpc_parameter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $rpc, $rpcuser, $rpcpassword, $rpcport, $rpc_method, $rpc_parameter));
} else {
    $url = $_POST['url'];
    $parameter = $_POST['parameter'];
    $addition = $_POST['addition'];
    $stmt = $dbh->prepare("INSERT INTO coins (name, code, algo, block_reward, url,parameter, addition) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $url, $parameter, $addition));
}
$stmt=$dbh->query("ALTER TABLE difficulty ADD $code DOUBLE");
$stmt=$dbh->prepare("INSERT INTO price (coin, price) VALUES (?, ?)");
$stmt->execute(array($coin_name, $price));