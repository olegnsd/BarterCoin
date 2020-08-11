<?php

require('inc/init.php');

$recive = $_REQUEST;
$recive = json_encode($recive);//json_encode(json_decode($recive), JSON_UNESCAPED_UNICODE);

//$file = fopen('/home/api.goip/tmp/qaz_telegram', 'a');
//fwrite($file, '     '. PHP_EOL);
//fwrite($file, date("d.m.Y H:i:s", time()). PHP_EOL);
//fwrite($file, $recive. PHP_EOL);
//fclose($file);

//file_put_contents('/home/api.goip/tmp/qaz_telegram', '       '. PHP_EOL, FILE_APPEND);
//file_put_contents('/home/api.goip/tmp/qaz_telegram', date("d.m.Y H:i:s", time()). PHP_EOL, FILE_APPEND);
//file_put_contents('/home/api.goip/tmp/qaz_telegram', $recive. PHP_EOL, FILE_APPEND);

$myecho = " recive: " . $recive;
mysqli_query($mysqli, "INSERT INTO qaz_barter (event) values('$myecho')");

echo('Ok');
