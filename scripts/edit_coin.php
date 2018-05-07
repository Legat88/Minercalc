<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$code=$_POST['code'];
$algo=$_POST['algo'];
$blockreward=$_POST['blockreward'];
if (isset($_POST['rpc'])) {
    $rpc = 1;
    $rpcuser = $_POST['rpcuser'];
    $rpcpassword = $_POST['rpcpassword'];
    $rpcport = $_POST['rpcport'];
    $query = "UPDATE coins SET code='$code', algo='$algo', block_reward=$blockreward, rpc=$rpc, rpcuser='$rpcuser', rpcpassword='$rpcpassword', rpcport=$rpcport WHERE name='$coin_name'";
    $dbh->query($query);
} else {
    $rpc = 0;
    $url = $_POST['url'];
    $parameter = $_POST['parameter'];
    $addition = $_POST['addition'];
    $query = "UPDATE coins SET code='$code', algo='$algo', block_reward=$blockreward, rpc=$rpc, url='$url', parameter='$parameter', addition='$addition' WHERE name='$coin_name'";
    $dbh->query($query);
}

