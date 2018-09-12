<?php
function api_error($textLog)
{
    $file = $_SERVER['DOCUMENT_ROOT'] . '/logs/api_errors.log';
    $text = "=======================\n"; // Обязательно двойные кавычки, в одинарных не будет работать перевод строки
    $text .= $textLog;//Выводим переданную переменную
    $text .= "\n" . date('Y-m-d H:i:s') . "\n"; //Добавим актуальную дату после текста или дампа массива
    $fOpen = fopen($file, 'a');
    fwrite($fOpen, $text);
    fclose($fOpen);
}