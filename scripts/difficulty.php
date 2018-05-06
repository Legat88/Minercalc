<?php
require "db.php";
require_once('easybitcoin.php');
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);
$stmt = $dbh->query("SELECT * FROM coins");
while ($result = $stmt->fetch(PDO::FETCH_LAZY)) {
    $rpc_mode = $result->rpc;
    if ($rpc_mode == 0) {
        $url = $result->url;
        if (!$data = file_get_contents($url, false, stream_context_create($arrContextOptions))) {
            continue;
        } else {
            $coin[] = $result->code;
            $parameter = $result->parameter;
            $addition = $result->addition;
            $info = json_decode($data);
            if ($addition != NULL && $parameter != NULL) {
                $difficulty[] = $info->$addition->$parameter;
            } elseif ($addition == NULL && $parameter != NULL) {
                $difficulty[] = $info->$parameter;
            } elseif ($addition == NULL && $parameter == NULL) {
                $difficulty[] = $info;
            }
        }
    } else {
        $coin[] = $result->code;
        $rpcuser = $result->rpcuser;
        $rpcpassword = $result->rpcpassword;
        $rpcport = $result->rpcport;
        $rpc = new Bitcoin($rpcuser, $rpcpassword, 'localhost', $rpcport);
        $rpc->getinfo();
        $difficulty[] = $rpc->response['result']['difficulty'];
    }

}
$coins = implode(', ', $coin);
$difficulties = join(', ', $difficulty);
$dbh->query("INSERT INTO difficulty (datetime, $coins) VALUES (NOW(), $difficulties)");
?>