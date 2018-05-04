<?php
require "db.php";
$coin_name=$_POST['coin_name'];
$code=$_POST['code'];
$algo=$_POST['algo'];
$blockreward=$_POST['blockreward'];
$url=$_POST['url'];
$addition=$_POST['addition'];
$query="UPDATE coins SET code='$code', algo='$algo', block_reward=$blockreward, url='$url', addition='$addition' WHERE name='$coin_name'";
$dbh->query($query);
