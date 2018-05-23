<?php
require "db.php";
if(isset($_POST['get_asic'])) {
    $asic = $_POST['get_asic'];
    $algos_q = $dbh->query("SELECT name FROM algos");
    while ($result=$algos_q->fetch(PDO::FETCH_LAZY)) {
        $algo[]=$result->name;
    }
    $algos=implode(', ', $algo);
    $stmt = $dbh->prepare("SELECT $algos FROM ASIC WHERE name=?");
    $stmt->execute(array($asic)); //Обязательно массив, строку не возьмет
    $hashrate=$stmt->fetchAll();
    foreach ($hashrate as $key=>$value) {
        $result[$key]=$value;
    }
    $stmt = $dbh->prepare("SELECT tdp FROM ASIC WHERE name=?");
    $stmt->execute(array($asic));
    $tdp_q = $stmt->fetch(PDO::FETCH_LAZY);
    $tdp = $tdp_q->tdp;
    header('Content-type: application/json');
    echo json_encode(array('hashrate' => $result[0], 'tdp' => $tdp));
}