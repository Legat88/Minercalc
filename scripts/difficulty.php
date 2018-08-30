<?php
require "db.php";
require "api_call.php";
require_once('easybitcoin.php');
$stmt = $dbh->query("SELECT * FROM coins");
while ($result = $stmt->fetch(PDO::FETCH_LAZY)) {
    $rpc_mode = $result->rpc;
    if ($rpc_mode == 0) {
        $url = $result->url;
        $data = apiCall($url);
        if (!$data) {
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
        $rpc_method = $result->rpc_method;
        $rpc_parameter = $result->rpc_parameter;
        $rpc = new Bitcoin($rpcuser, $rpcpassword, 'localhost', $rpcport);
        if ($rpc_method == NULL && $rpc_parameter == NULL) {
            $rpc->getinfo();
            $difficulty[] = $rpc->response['result']['difficulty'];
        } elseif ($rpc_method != NULL && $rpc_parameter != NULL) {
            $rpc->$rpc_method();
            $difficulty[] = $rpc->response['result'][$rpc_parameter];
        } elseif ($rpc_method != NULL && $rpc_parameter == NULL) {
            $rpc->$rpc_method();
            $difficulty[] = $rpc->response['result']['difficulty'];
        } elseif ($rpc_method == NULL && $rpc_parameter != NULL) {
            $rpc->getinfo();
            $difficulty[] = $rpc->response['result'][$rpc_parameter];
        }
    }

}
$coins = implode(', ', $coin);
$difficulties = join(', ', $difficulty);
$query = "INSERT INTO difficulty (datetime, $coins) VALUES (NOW(), $difficulties)";
$dbh->query($query);
?>