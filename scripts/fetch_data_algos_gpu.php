<?php
require "db.php";
if(isset($_POST['get_gpu'])) {
    $gpu = $_POST['get_gpu'];
    $algos_q = $dbh->query("SELECT name FROM algos");
    while ($result=$algos_q->fetch(PDO::FETCH_LAZY)) {
        $algo[]=$result->name;
    }
    $algos=implode(', ', $algo);
    $stmt = $dbh->prepare("SELECT $algos FROM GPU WHERE name=?");
    $stmt->execute(array($gpu)); //Обязательно массив, строку не возьмет
    $hashrate=$stmt->fetchAll();
    foreach ($hashrate as $key=>$value) {
        $result[$key]=$value;
    }
    header('Content-type: application/json');
    echo json_encode($result[0]);
}