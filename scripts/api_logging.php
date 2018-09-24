<?php

function api_error($textLog)
{
    $query = "INSERT INTO logs (datetime, message) VALUES (NOW(), '$textLog')";
    global $dbh;
    $dbh->query($query);

//    $file = __DIR__ . '/../logs/api_errors.log';
//    $text = "=======================\n"; // Обязательно двойные кавычки, в одинарных не будет работать перевод строки
//    $text .= $textLog;//Выводим переданную переменную
//    $text .= "\n" . date('Y-m-d H:i:s') . "\n"; //Добавим актуальную дату после текста или дампа массива
//    $fOpen = fopen($file, 'a');
//    fwrite($fOpen, $text);
//    fclose($fOpen);
}