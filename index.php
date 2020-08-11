<?
$_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_REAL_IP'];
require('inc/init.php');
ini_set('display_errors', 0);
if($_GET['page']=='')$_GET['page']='index';
/*function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включен в error_reporting,
        // так что пусть обрабатываются стандартным обработчиком ошибок PHP
        return false;
    }

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>Пользовательская ОШИБКА</b> [$errno] $errstr<br />\n";
        echo "  Фатальная ошибка в строке $errline файла $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Завершение работы...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>Пользовательское ПРЕДУПРЕЖДЕНИЕ</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>Пользовательское УВЕДОМЛЕНИЕ</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Неизвестная ошибка: [$errno] $errstr<br />\n";
        break;
    }


    return true;
}



// переключаемся на пользовательский обработчик
$old_error_handler = set_error_handler("myErrorHandler");
*/


ob_start();$upd=30;
include('inc/template/top.php');
$no404=false;
if($_GET['page']=='index'){$no404=true;include('pages/index.php');}
if($_GET['page']=='send'){$no404=true;include('pages/send.php');}
if($_GET['page']=='check'){$no404=true;include('pages/check.php');}
if($_GET['page']=='activate'){$no404=true;include('pages/activate.php');}
if($_GET['page']=='deposit'){$no404=true;include('pages/deposit.php');}
if($_GET['page']=='withdraw7'){$upd=3;$no404=true;include('pages/withdraw7.php');}
if($_GET['page']=='withdraw'){$upd=3;$no404=true;include('pages/withdraw.php');}
if($_GET['page']=='faq'){$no404=true;include('pages/faq.php');}//;$uc=true
if($_GET['page']=='api'){$no404=true;include('pages/api.php');}
if($_GET['page']=='create'){$no404=true;include('pages/create.php');}
if($_GET['page']=='create/save'){$no404=true;include('pages/save.php');}
if($_GET['page']=='loan'){$no404=true;ini_set('display_errors', 0);include('pages/loan.php');}
if($_GET['page']=='referals'){$no404=true;include('pages/referals.php');}
if($_GET['page']=='restore'){$no404=true;include('pages/restore.php');}
if($_GET['page']=='pay_card'){$no404=true;include('pages/pay_card.php');}
if($_GET['page']=='pay_phone'){$no404=true;include('pages/pay_phone.php');}
if($_GET['page']=='activate2'){$no404=true;include('pages/activate.php');}


//if($_GET['page']=='test_server'){$no404=true;include('pages/test_server.php');}
if(!$no404){header("HTTP/1.0 404 Not Found");
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");?>
<div class="errorArea secPdng">

<div class="row errRow">
    			<div class="col-lg-5 col-lg-offset-1 col-md-6 col-md-offset-1">
    				<div class="errorContent">
    					<div class="h1 errorTitle">Ошибка 404!.</div>
    					<span>Страница не найдена!. <br>Вы можете перейти <a href="javascript:history.go(-1);">назад</a> или на <a href="<?=$baseHref;?>">главную страницу</a>.</span>
    					
    					<!--a href="#"><i class="icofont"></i> Go back to home</a-->
    				</div>
    			</div>
    			<div class="col-lg-5 col-md-4 errCol">
    				<div class="eSearchImg">
<i class="fa fa-ban" style="    font-size: 16vw;"></i>
    				</div>
    			</div>
    		</div>
</div>
<?}
elseif($uc){header("HTTP/1.0 404 Not Found");
header("HTTP/1.1 404 Not Found");
header("Status: 404 Not Found");?>
<div class="errorArea secPdng">

<div class="row errRow">
    			<div class="col-lg-5 col-lg-offset-1 col-md-6 col-md-offset-1">
    				<div class="errorContent">
    					<div class="h1 errorTitle">Раздел находится в разработке!</div>
    					<span>Вы можете перейти <a href="javascript:history.go(-1);">назад</a> или на <a href="<?=$baseHref;?>">главную страницу</a>.</span>
    					
    					<!--a href="#"><i class="icofont"></i> Go back to home</a-->
    				</div>
    			</div>
    			<div class="col-lg-5 col-md-4 errCol">
    				<div class="eSearchImg">
<i class="fa fa-hourglass" style="    font-size: 16vw;"></i>
    				</div>
    			</div>
    		</div>
</div>
<?}


include('inc/template/bottom.php');
echo(ob_get_clean());

header('Connection: close');
ob_end_flush();
ob_flush();
flush();

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

?>
