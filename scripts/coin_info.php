<?php
require "db.php";
$coin_code=$_POST['coin_code'];
$stmt=$dbh->prepare("SELECT name, algo, code FROM coins WHERE code=?");
$stmt->execute(array($coin_code));
$info_coin=$stmt->fetch(PDO::FETCH_LAZY);
    $name=$info_coin['name'];
    $algo=$info_coin['algo'];
    $code=$info_coin['code'];
    $name_for_url=str_replace(" ", "-", $name);
    $coinmarketcap='https://coinmarketcap.com/currencies/'.$name_for_url;
$stmt=$dbh->prepare("SELECT miner FROM algos WHERE name=?");
$stmt->execute(array($algo));
$info_algo=$stmt->fetch(PDO::FETCH_LAZY);
    $miner=$info_algo['miner'];
$stmt=$dbh->prepare("SELECT name, address, port FROM pools WHERE coin=?");
$stmt->execute(array($code));
while ($info_pool=$stmt->fetch(PDO::FETCH_LAZY)) {
    $pool[]=$info_pool['name'];
    $address[]=$info_pool['address'];
    $port[]=$info_pool['port'];
}
$stmt = $dbh->query("SELECT datetime, $code FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 1 DAY)");
//$stmt->execute(array($code));
while ($diff_info = $stmt->fetch(PDO::FETCH_LAZY)) {
    if ($code != 'LUX') {
        $date[] = $diff_info['datetime'];
        $diff[] = $diff_info[$code];
    } else {
        if ($diff_info[$code] > 100) {
            $date[] = $diff_info['datetime'];
            $diff[] = $diff_info[$code];
        }
    }
}
$result = array('coin' => $name, 'algo' => $algo, 'url' => $coinmarketcap, 'miner' => $miner, 'pool' => $pool, 'address' => $address, 'port' => $port, 'date' => $date, 'diff' => $diff);
header('Content-type: application/json');
echo json_encode($result);
