<?php
require "db.php";
$code = $_POST['code'];
$stmt = $dbh->query("SELECT datetime, $code FROM difficulty WHERE datetime > DATE_SUB(NOW(), INTERVAL 30 DAY)");
$data = [];
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
for ($i = 0; $i < count($data); $i++) {
    $key = $data[$i][0];
    $value = $data[$i][1];
    if ($i != count($data) - 1) {
        echo '[' . $key . ', ' . $value . '], ';
    } else {
        echo '[' . $key . ', ' . $value . ']';
    }
}
