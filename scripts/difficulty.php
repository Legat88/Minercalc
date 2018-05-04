<?php
require "db.php";
$stmt=$dbh->query("SELECT * FROM coins");
while ($result=$stmt->fetch(PDO::FETCH_LAZY)) {
    $url=$result->url;
    if (!$data=file_get_contents($url)) {
        continue;
    } else {
        $coin[]=$result->code;
        $parameter=$result->parameter;
        $addition=$result->addition;
        $info=json_decode($data);
        if ($addition !=NULL && $parameter!=NULL) {
            $difficulty[]=$info->$addition->$parameter;
        } elseif ($addition==NULL && $parameter!=NULL) {
            $difficulty[]=$info->$parameter;
        } elseif ($addition==NULL && $parameter==NULL) {
            $difficulty[]=$info;
        }
    }
}
$coins=implode(', ', $coin);
$difficulties=join(', ', $difficulty);
$dbh->query("INSERT INTO difficulty (datetime, $coins) VALUES (NOW(), $difficulties)");
?>