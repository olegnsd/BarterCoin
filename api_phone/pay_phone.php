<?php
ini_set('display_errors', 0);

global $mysqli;

require('../inc/init.php');

$jsonStr = file_get_contents("php://input"); //read the HTTP body.
$jsonStr = json_decode($jsonStr, true);

if($jsonStr['token'] != '98jsHF8fhc') die('token false');

$phone_pay = $jsonStr['phone_pay'];
$pay_sum = $jsonStr['pay_sum'];
$check_bal = $jsonStr['check_bal'];
//данные банкомата
$info = mysqli_query($mysqli,"SELECT token, amount FROM settings WHERE title='bankomat' AND amount='7'");
$info = mysqli_fetch_assoc($info);
$token_proxy = json_decode($info["token"], true);
$token = ($token_proxy["token"]);
$proxy_ip = $token_proxy["ip"];
$proxy_port = $token_proxy["port"];
$proxy_usr = $token_proxy["usr"];
$proxy_pass = $token_proxy["pass"];

//$myecho = json_encode($info["token"]);
//`echo " info_bank_pay_phone: "  $myecho >>/home/bartercoin/tmp/qaz`;
//$myecho = json_encode($check_bal);
//`echo " check_bal_pay_phone: "  $myecho >>/home/bartercoin/tmp/qaz`;

//проверка счета в банкомате
if($check_bal == 1){
	
	`echo "                "   >>/home/bartercoin/tmp/qaz`;
	$myecho = date("d.m.Y H:i:s");;
	`echo ""  $myecho >>/home/bartercoin/tmp/qaz`;
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Bearer ' . $token)//$qiwi_token
	);
	curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
	curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
	curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
	$out_err = json_encode(curl_error($curl), JSON_UNESCAPED_UNICODE);
	$out_count = curl_exec($curl);
                
    `echo " out_count_pay_phone: "  $out_count >>/home/bartercoin/tmp/qaz`;
    `echo " out_err_pay_phone: "  $out_err >>/home/bartercoin/tmp/qaz`;

	curl_close($curl);
					
	$out_count = json_decode($out_count);
	$out_count = $out_count->accounts[0]->balance->amount;
	
	//записать в файл 7-го банкомата
    put_bank($mysqli, 7, $out_count);//file_put_contents('/home/bartercoin/tmp/bankbalance7', $out_count);

//    $myecho = json_encode(mysqli_error($mysqli));
//    `echo " mysqli_error: "  $myecho >>/tmp/qaz`;
	$myecho = json_encode($out_count);
	`echo " out_count_n_pay_phone: "  $myecho >>/home/bartercoin/tmp/qaz`;

	$out_count = json_encode(array('out_count' => $out_count, 'true' => true));
	echo($out_count);
	exit;

//$out_count = json_decode($out_count);
//$out_count = $out_count->accounts[0]->balance->amount;
}


$myecho = json_encode('phone_pay: '. $phone_pay . ' pay_sum: '. $pay_sum);
`echo ""  $myecho >>/home/bartercoin/tmp/qaz`;

//проверка идентификатора оператора
if($curl = curl_init()){
	curl_setopt($curl, CURLOPT_URL, "https://qiwi.com/mobile/detect.action");
	curl_setopt($curl, CURLOPT_POST, True);
	curl_setopt($curl, CURLOPT_POSTFIELDS, array(
	"phone" => '7'.$phone_pay,//79185298183',
	));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
	$code = curl_exec($curl);
}

$res = json_decode($code, true);

$myecho = json_encode('value: '. $res['code']['value'] . ' message: '. $res['message']);
`echo " res: "  $myecho >>/home/bartercoin/tmp/qaz`;

$identif = $res['message'];

//$info=mysqli_query($mysqli,"SELECT token, amount FROM settings WHERE title='bankomat' AND amount='7'");
//$info = mysqli_fetch_assoc($info);
//$token_proxy = json_decode($info["token"], true);
//$token = ($token_proxy["token"]);
//$proxy_ip = $token_proxy["ip"];
//$proxy_port = $token_proxy["port"];
//$proxy_usr = $token_proxy["usr"];
//$proxy_pass = $token_proxy["pass"];
$sms_send = "Пополнение телефона $phone_pay на $pay_sum";
$id = 1000 * time();

//пополнить счет;
if( $token != '' && $curl) {
	$json_data = '{"id":"' . $id . '","sum":{"amount":' . $pay_sum . ',"currency":"643"},"paymentMethod":{"type":"Account","accountId":"643"}, "comment":"' . $sms_send . '","fields":{"account":"' . $phone_pay . '"}}';
	
	$myecho = $json_data;
	`echo " json_data: "  $myecho >>/home/bartercoin/tmp/qaz`;
	
	curl_setopt($curl, CURLOPT_URL, "https://edge.qiwi.com/sinap/api/v2/terms/".$identif."/payments");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);    			
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($json_data),
	    'Authorization: Bearer ' . $token)//$qiwi_token
	); 
	curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
	curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
	curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
	curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);

	$pay_res = curl_exec($curl);
	curl_close($curl);
	
	$pay_save = json_encode($pay_res, JSON_UNESCAPED_UNICODE);
	$pay_res = json_encode(array('pay_res' => $pay_res, 'true' => true));
	
	$myecho = json_encode($pay_res);
	`echo " pay_res: "  $myecho >>/home/bartercoin/tmp/qaz`;
	$myecho = curl_error($curl);
	`echo " curl_error: "  $myecho >>/home/bartercoin/tmp/qaz`;
	
	echo($pay_res);
	
	$info=mysqli_query($mysqli,"INSERT INTO pay_phone (`id`, `answer`, `date`) VALUES(NULL, '$pay_save', CURRENT_TIMESTAMP)");
}
