<?php
require "db.php";
$url = 'https://api.coinmarketcap.com/v1/ticker/?limit=0';
$data = file_get_contents($url);
$info = json_decode($data, true);

$stmt = $dbh->query("SELECT name FROM coins");
while ($result = $stmt->fetch(PDO::FETCH_LAZY)) {
    $coin = $result->name;
    $coin_for_api = str_replace(" ", "-", $coin);
    $coin_for_api = strtolower($coin_for_api);
    foreach ($info as $item) {
        if ($coin_for_api == $item['id']) {
            $price = $item['price_usd'];
            break;
        }
    }
    $stmt_update = $dbh->prepare("UPDATE price SET price=? WHERE coin=?");
    $stmt_update->execute(array($price, $coin));
}
