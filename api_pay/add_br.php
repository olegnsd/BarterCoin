#!/usr/bin/php
<?php

//КИВИ-БОТ или Резервное финансирование:
//4) Козырев Данис Дамирович - КИВИ-БОТ (ИНН: 732712124897)
//13G4 - +79295893547 :
//Киви - 9295893547 пароль g04qtFxKz6
//ЯД - danis.cozyrev@yandex.ru пароль R6MTHGtGrH 
//( номер кошелька 410017150193980 )
//делать систему материальной поддержки с рекапчей где 1 кошель можно раз 1 день получить 1р.

//6р подливает каждую минуту
//если 10 мин прошло и никто не снял - еще 6р
//и так до 50р подлвиать
//6р раз в 10 мин

ini_set('display_errors', 1);

//if (!$_GET['cron']) {
//    die();
//}

require('../inc/init.php');

ini_set('display_errors', 1);

//проверка базы логов
//mysqli_query($mysqli, "DELETE FROM qaz_add_br WHERE date>".time()-60*60*24*3);

//`echo "       "   >>/home/bartercoin/tmp/qaz_add_br`;
//$myecho = date("d.m.Y H:i:s");
//`echo " date_now : "  $myecho >>/home/bartercoin/tmp/qaz_add_br`;
$myecho = "pusk ";
mysqli_query($mysqli, "INSERT INTO qaz_add_br (event) values('$myecho')");



