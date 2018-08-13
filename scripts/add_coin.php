<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$code=$_POST['code'];
$algo=$_POST['algo'];
$blockreward=$_POST['blockreward'];
$coinmarketcap = $_POST['coinmarketcap'];
if ($coinmarketcap == 1) {
    $coin_for_api = str_replace(" ", "-", $coin_name);
    $url = 'https://api.coinmarketcap.com/v1/ticker/' . $coin_for_api;
    $data = file_get_contents($url);
    $info = json_decode($data, true);
    $price = $info[0]['price_usd'];
    if ($coin_for_api == 'bitcoin') {
        $BTC = $price;
    }
} else {
    $url_cb = 'https://api.crypto-bridge.org/api/v1/ticker';
    $data = file_get_contents($url_cb);
    $info = json_decode($data, true);
    foreach ($info as $item) {
        if ($code == $item['id']) {
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
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $rpc, $rpcuser, $rpcpassword, $rpcport, $rpc_method, $rpc_parameter));
} else {
    $url = $_POST['url'];
    $parameter = $_POST['parameter'];
    $addition = $_POST['addition'];
    $stmt = $dbh->prepare("INSERT INTO coins (name, code, algo, block_reward, url,parameter, addition, coinmarketcap) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($coin_name, $code, $algo, $blockreward, $url, $parameter, $addition));
}
$stmt=$dbh->query("ALTER TABLE difficulty ADD $code DOUBLE");
$stmt=$dbh->prepare("INSERT INTO price (coin, price) VALUES (?, ?)");
$stmt->execute(array($coin_name, $price));