<?php
exit;
ini_set('display_errors', 1);

$json_data = "makmak";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://shares.holding.bz/my_test_curl.php');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:66.0) Gecko/20100101 Firefox/66.0");
//$headers = array();
//$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
//$headers[] = "Accept-Encoding: gzip, deflate, br";
//$headers[] = "Accept-Language: en-US,en;q=0.5";
//$headers[] = "Upgrade-Insecure-Requests: 1";
//$headers[] = "Connection: keep-alive";
//$headers[] = "Cookie: _ym_uid=1548667471513889872; _ym_d=1548667471; _ga=GA1.2.970841148.1553681390; _ym_isad=2; PHPSESSID=hn5c32hbmh9g57adc6n6nup6e3";
//$headers[] = "Host: shares.holding.bz";
//$headers[] = "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:66.0) Gecko/20100101 Firefox/66.0";
//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($curl, CURLOPT_PORT, 443);
//curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);  
//curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    //'Accept: application/json',
                    //'Content-Length: ' . strlen($json_data)
                    //'Authorization: Bearer ' . "e44f58215ca20ef4ba25f30da81decdd")//$qiwi_token
                //);
//curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(
     //[
          //"id" => '402',
          //"sum" => '10',
          //"comment" => $_GET['comment'],
          //"secret" => 'fuyjhfkgdt'
     //]
//));
//curl_setopt ($curl, CURLOPT_CAINFO, dirname(__FILE__)."/cert.pem");
//curl_setopt($curl, CURLOPT_SSLVERSION, 2);
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);

$data1 = curl_exec($curl);

//$out_count = json_decode($data1);
//$out_count = $out_count->accounts[0]->balance->amount;

echo ("                " );
echo('<br>');
$myecho = date("d.m.Y H:i:s");
echo ("" . $myecho);
echo('<br>');
$myecho = json_encode($data1);
echo (" data1: " . $myecho);
echo('<br>');
$c_info = curl_getinfo($curl);
$myecho = json_encode($c_info);
echo (" curl_getinfo: " . $myecho);
echo('<br>');
$myecho = json_encode(curl_getinfo($curl, CURLINFO_SSL_VERIFYRESULT));
echo (" CURLINFO_SSL_VERIFYRESULT: " . $myecho);
echo('<br>');
$myecho = json_encode($c_info['certinfo']);
echo (" certinfo: " . $myecho);
echo('<br>');
$myecho = curl_error($curl);
echo (" curl_error: " . $myecho);
echo('<br>');
$myecho = curl_errno($curl);
echo (" curl_errno: " . $myecho);
echo('<br>');
$myecho = curl_copy_handle($curl);
echo (" curl_copy_handle: " . $myecho);
echo('<br>');



curl_close($curl);

exit;


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://holding.bz/my_test_curl.php');
//curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
//curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//curl_setopt($curl, CURLOPT_PORT, 443);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . "e44f58215ca20ef4ba25f30da81decdd")//$qiwi_token
                );
//curl_setopt($curl, CURLOPT_POSTFIELDS, array(
//"id" => '402',
//"sum" => '10',
////"comment" => $_GET['comment'],
//"secret" => 'fuyjhfkgdt',
//));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);

$data1 = curl_exec($curl);

//$out_count = json_decode($data1);
//$out_count = $out_count->accounts[0]->balance->amount;

echo ("                " );
echo('<br>');
$myecho = date("d.m.Y H:i:s");
echo ("" . $myecho);
echo('<br>');
$myecho = json_encode($data1);
echo (" data1: " . $myecho);
echo('<br>');
$c_info = curl_getinfo($curl);
$myecho = json_encode($c_info);
echo (" curl_getinfo: " . $myecho);
echo('<br>');
$myecho = json_encode(curl_getinfo($curl, CURLINFO_SSL_VERIFYRESULT));
echo (" CURLINFO_SSL_VERIFYRESULT: " . $myecho);
echo('<br>');
$myecho = json_encode($c_info['certinfo']);
echo (" certinfo: " . $myecho);
echo('<br>');
$myecho = curl_error($curl);
echo (" curl_error: " . $myecho);
echo('<br>');

curl_close($curl);
exit;


