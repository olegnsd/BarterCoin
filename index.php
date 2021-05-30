<?
ini_set('display_errors', 1);
// $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_REAL_IP'];

require('inc/init.php');

if (empty($_GET['page'])) {
    $_GET['page']='index';
}

ob_start();
include('inc/template/top.php');

[ $statusCode, $upd ] = include('inc/router.php');
handleStatusCode($statusCode);

include('inc/template/bottom.php');
header('Connection: close');
ob_end_flush();

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
curl_setopt($curl, CURLOPT_TIMEOUT, 20);
$infos=mysqli_query($mysqli,"SELECT token, amount FROM settings WHERE title='bankomat'");
foreach($infos as $info){
	//sleep(0.3);
    $token_proxy = json_decode($info["token"], true);
    $token = ($token_proxy["token"]);
    $proxy_ip = ($token_proxy["ip"]);
    $proxy_port = ($token_proxy["port"]);
    $proxy_usr = ($token_proxy["usr"]);
    $proxy_pass = ($token_proxy["pass"]);
    $b = $info["amount"];
    
    //`echo " b: "  $b >>/home/bartercoin/tmp/qaz`;
    //$myecho = $token;
    //`echo " token: "  $myecho >>/home/bartercoin/tmp/qaz`;
    //`echo " proxy_ip: "  $proxy_ip >>/home/bartercoin/tmp/qaz`;
    //`echo " proxy_port: "  $proxy_port >>/home/bartercoin/tmp/qaz`;
    //`echo " proxy_usr: "  $proxy_usr >>/home/bartercoin/tmp/qaz`;
    //`echo " proxy_pass: "  $proxy_pass >>/home/bartercoin/tmp/qaz`;
    
    
    if((time()-$upd*60)>strtotime(get_bank_time($mysqli, $b))){//if(time()+($upd*60)>filemtime('bankbalance'.$b) && $token != ""){
            //обновление счета
            if( $token != '' and $b !=8 and $b!=9) {
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $token)//$qiwi_token
                );
                //if( $proxy_ip != '') {
                    curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
                    curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
                    curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
                    curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
                    curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
                //}
                
                $out_count = curl_exec($curl);
                $out_err = json_encode(curl_error($curl), JSON_UNESCAPED_UNICODE);
                
                `echo "       "   >>/home/bartercoin/tmp/qaz_check_bal`;
				$myecho = date("d.m.Y H:i:s");
				`echo " date_now : "  $myecho >>/home/bartercoin/tmp/qaz_check_bal`;
                `echo " out_count: "  $out_count >>/home/bartercoin/tmp/qaz_check_bal`;
                `echo " out_err: "  $out_err >>/home/bartercoin/tmp/qaz_check_bal`;


        
            $out_count = json_decode($out_count);
            $out_count = $out_count->accounts[0]->balance->amount;
            
            //`echo " out_count: "  $out_count >>/home/bartercoin/tmp/qaz`;
            
    }
            else
            {           $curlP = curl_init();
                curl_setopt($curlP, CURLOPT_URL, 'http://ressssstapi:8000/payeer');
                $payeerId= $token_proxy['payeer'];

                $recipient=$_POST['target'];
                curl_setopt($curlP, CURLOPT_POST, 1);
                curl_setopt($curlP, CURLOPT_POSTFIELDS  ,
                    "hash=$token&sender=$payeerId&action=ballance");
                curl_setopt($curlP, CURLOPT_RETURNTRANSFER, true);
                $out_count = curl_exec($curlP);
                curl_close($curlP);
                $out_count = json_decode($out_count);
// var_dump($out_count);
                $out_count = $out_count->ball;
//    var_dump($out_count);

            }



        put_bank($mysqli, $b, $out_count);//file_put_contents('/home/bartercoin/tmp/bankbalance'.$b, $out_count);

    }
}
curl_close($curl);
