<?php
require "db.php";

$stmt = $dbh->query("SELECT code FROM coins");
while ($codes = $stmt->fetch(PDO::FETCH_LAZY)) {
    $coin_code[] = $codes['code'];
}
foreach ($coin_code as $c) {
    $stmt = $dbh->prepare("SELECT name, algo, code FROM coins WHERE code=?");
    $stmt->execute(array($c));
    $info_coin = $stmt->fetch(PDO::FETCH_LAZY);
    $name = $info_coin['name'];
    $algo = $info_coin['algo'];
    $code = $info_coin['code'];
    $name_for_url = str_replace(" ", "-", $name);
    $coinmarketcap = 'https://coinmarketcap.com/currencies/' . $name_for_url;
    $stmt = $dbh->prepare("SELECT miner FROM algos WHERE name=?");
    $stmt->execute(array($algo));
    $info_algo = $stmt->fetch(PDO::FETCH_LAZY);
    $miner = $info_algo['miner'];
    $stmt = $dbh->prepare("SELECT name, address, port FROM pools WHERE coin=?");
    $stmt->execute(array($code));
    while ($info_pool = $stmt->fetch(PDO::FETCH_LAZY)) {
        $pool = $info_pool['name'];
        $address = $info_pool['address'];
        $port = $info_pool['port'];
    }
    $stmt = $dbh->query("SELECT datetime, $code FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $data = [];
//$stmt->execute(array($code));
    while ($diff_info = $stmt->fetch(PDO::FETCH_LAZY)) {
        if ($code != 'LUX') {
            $date = strtotime($diff_info['datetime']) * 1000;
            $diff = $diff_info[$code];
            if ($diff != NULL) {
                $data[] = array($date, $diff);
            }

        } else {
            if ($diff_info[$code] > 100) {
                $date = strtotime($diff_info['datetime']) * 1000;
                $diff = $diff_info[$code];
                if ($diff != NULL) {
                    $data[] = array($date, $diff);
                }
            }
        }
    }
//     $data=array_combine($date, $diff);
    $result[$c] = array('coin' => $name, 'algo' => $algo, 'url' => $coinmarketcap, 'miner' => $miner, 'pool' => $pool, 'address' => $address, 'port' => $port, 'data' => $data);
}

//$coin_code=$_POST['coin_code'];


if ($result && file_exists('../json/result.json')) {
    unlink('../json/result.json'); //delete file
    $fp = fopen('../json/results.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
//    createFile($result);
} elseif ($result && !file_exists('../json/result.json')) {
//    createFile($result);
    $fp = fopen('../json/results.json', 'w');
    fwrite($fp, json_encode($result));
    fclose($fp);
}

//header('Content-type: application/json');

//function createFile($result) {
//    $fp=fopen('../json/results.json', 'w');
//    fwrite($fp, json_encode($result));
//    fclose($fp);
//}

