<?php
require "db.php";
$url='https://api.coinmarketcap.com/v1/ticker/?limit=0';
$data=file_get_contents($url);
$info = json_decode($data, true);

$stmt = $dbh->query("SELECT name FROM coins WHERE coinmarketcap=1");
while ($result=$stmt->fetch(PDO::FETCH_LAZY)) {
    $coin = $result->name;
    $coin_for_api = str_replace(" ", "-", $coin);
    $coin_for_api=strtolower($coin_for_api);
    foreach ($info as $item) {
        if ($coin_for_api==$item['id']) {
            $price=$item['price_usd'];
            if ($coin_for_api == 'bitcoin') {
                $BTC = $price;
            }
            break;
        }
    }
    $stmt_update = $dbh->prepare("UPDATE price SET datetime=NOW(), price=? WHERE coin=?");
    $stmt_update->execute(array($price, $coin));
}

$stmt = $dbh->query("SELECT name, code FROM coins WHERE coinmarketcap=0");
//Для Crypto-bridge.org
$url_cb = 'https://api.crypto-bridge.org/api/v1/ticker';
$data = file_get_contents($url_cb);
$info = json_decode($data, true);
while ($result = $stmt->fetch(PDO::FETCH_LAZY)) {
    $coin = $result->name;
    $code = $result->code;
    $id = $code . '_BTC';
    foreach ($info as $item) {
        if ($id == $item['id']) {
            $price = $item['last'] * $BTC;
            break;
        }
    }
    $stmt_update = $dbh->prepare("UPDATE price SET datetime=NOW(), price=? WHERE coin=?");
    $stmt_update->execute(array($price, $coin));
}