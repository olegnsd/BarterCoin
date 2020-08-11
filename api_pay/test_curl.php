<?php

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://shares.holding.bz:8080/stock_alrt2.php');
//curl_setopt($curl, CURLOPT_POST, 1);
//curl_setopt($curl, CURLOPT_POSTFIELDS, array(
//"id" => (int)($_GET['id']),
//"sum" => (float)$_GET['sum'],
//"secret" => md5($_GET['shop'].$data['key2'].$_GET['id'].(float)$_GET['sum']),
//));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$data1 = curl_exec($curl);

echo($data1);
