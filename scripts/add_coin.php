<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$code=$_POST['code'];
$algo=$_POST['algo'];
$blockreward=$_POST['blockreward'];
$url_btc = 'https://api.coinmarketcap.com/v1/ticker/bitcoin';
$data = file_get_contents($url_btc);
$info = json_decode($data, true);
$BTC = $info[0]['price_usd'];
if (isset($_POST['coinmarketcap'])) {
    $coinmarketcap = 1;
    $coin_for_api = str_replace(" ", "-", $coin_name);
    $url = 'https://api.coinmarketcap.com/v1/ticker/' . $coin_for_api;
    $data = file_get_contents($url);
    $info = json_decode($data, true);
    $price = $info[0]['price_usd'];
} else {
    $coinmarketcap = 0;
    $url_cb = 'https://api.crypto-bridge.org/api/v1/ticker';
    $data = file_get_contents($url_cb);
    $info = json_decode($data, true);
    $id = $code . '_BTC';
    foreach ($info as $item) {
        if ($id == $item['id']) {
            $price = $item['last'] * $BTC;
            break;
        }
    }
}
if (isset($_POST['rpc'])) {
    $rpc = 1;
    $rpcuser = $_POST['rpcuser'];
    $rpcpassword = $_POST['rpcpassword'];
    $rpcport = $_POST['rpcport'];
    $rpc_method = $_POST['rpc_method'];
    $rpc_parameter = $_POST['rpc_parameter'];
    $stmt = $dbh->prepare("INSERT INTO coins (name, code, algo, block_reward, rpc, rpcuser, rpcpassword, rpcport, rpc_method, rpc_parameter, coinmarketcap) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $rpc, $rpcuser, $rpcpassword, $rpcport, $rpc_method, $rpc_parameter, $coinmarketcap));
} else {
    $url = $_POST['url'];
    $parameter = $_POST['parameter'];
    $addition = $_POST['addition'];
    $stmt = $dbh->prepare("INSERT INTO coins (name, code, algo, block_reward, url,parameter, addition, coinmarketcap) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $url, $parameter, $addition, $coinmarketcap));
}
$stmt=$dbh->query("ALTER TABLE difficulty ADD $code DOUBLE");
$stmt=$dbh->prepare("INSERT INTO price (coin, price) VALUES (?, ?)");
$stmt->execute(array($coin_name, $price));