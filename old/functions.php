<?
function _mail($email,$title,$text){
$headers  = "From: ".$_SERVER['SERVER_NAME']." <robot@".$_SERVER['SERVER_NAME'].">\r\n"; 
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
mail($email, "=?utf-8?B?".base64_encode($title)."?=", $text, $headers);
}




function pagination_main($table,$func,$template,$num,$url,$getnext,$query='`id`'){
if($template=='')$template='%list%%pagination%';
global $mysqli;
$result=mysqli_query($mysqli,"SELECT * FROM `".mysqli_escape_string($mysqli,$table)."` WHERE ($query) AND ".pagination_query($getnext)." LIMIT ".(int)($num+1).";");
if(!$result | !mysqli_num_rows($result)){$template='<div class="alert alert-warning">Ничего не найдено</div>';}
$k=0;$list='';
while($data=mysqli_fetch_assoc($result)){
if($k<$num){
$list.=$func($data);
}$k++;
if($k==($num+1))$last=$data['id'];
}
$template=str_replace("%list%", $list, $template);
$off=1;if($getnext==-1)$off=2;
$previd1=mysqli_query($mysqli,"SELECT id FROM `".mysqli_escape_string($mysqli,$table)."` WHERE ($query) AND ".pagination_query($getnext,1)." LIMIT ".(int)$off.",".(int)($num)); 
if($previd1)while($previd2=mysqli_fetch_assoc($previd1)){$previd=$previd2;}
$template=str_replace("%pagination%", pagination($url,$previd[id],$last,$getnext), $template);
echo($template);
}


function pagination($url,$previd,$last,$getnext){

if($getnext==-1){
$showFirst=TRUE;$showPrevious=TRUE;
$temp=$last;$last=$first;$first=$temp;
}else{if($previd>0&$getnext>0){$showFirst=TRUE;$showPrevious=TRUE;}
if($last){$showNext=TRUE;$showLast=TRUE;}}
$return='<ul class="pager">
%list% 
</ul>';
if($showFirst){$return1=str_replace('%link%',$url,'<li><a href="%link%">Начало</a>');}
if($showPrevious){$return1.=str_replace('%link%',$url.$previd,'<li><a href="%link%">&larr; Предыдущая</a><li>&nbsp;&nbsp;&nbsp;');}
if($showNext){$return1.=str_replace('%link%',$url.$last,'<li>&nbsp;&nbsp;&nbsp;<li>    <a href="%link%">Следующая &rarr;</a>');}
if($showLast){$return1.=str_replace('%link%',$url.'-1','<li><a href="%link%">Конец</a>');}
return stripcslashes(str_replace('%list%',$return1,$return));
}
function pagination_query($getnext,$rev=FALSE){
if(!$rev){if($getnext==-1){
return '`id` ORDER BY `id`';
}else{if($getnext>0)return '`id`<='.(int)$getnext.' ORDER BY `id` DESC';else return '`id` ORDER BY `id` DESC';}
}else{
if($getnext==-1){
return '`id` ORDER BY `id`';
}else{if($getnext>0)return '`id`>='.(int)$getnext.' ORDER BY `id`';else return '`id` ORDER BY `id`';}
}
}




function getcard($num,$month = 0,$year = 0,$cvc = 0,$activated=1){global $mysqli;
$card=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM accounts WHERE number='".mysqli_escape_string($mysqli,str_replace(' ','',$num))."' AND activated='".(int)$activated."'"));

if(!$card['id'])return false;
if($cvc>0){
if($cvc!=$card['cvc'])return false;
if($month!=$card['expiremonth'])return false;
if($year!=$card['expireyear'])return false;
}
return $card;
}

function getcardbyid($num){global $mysqli;
$card=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM accounts WHERE id='".(int)$num."' AND activated='1'"));

if(!$card['id'])return false;
return $card;
}


function transaction($card1,$card2,$sum,$comment='',$iswithdraw=false, $comission='1.0', $mincomission='0'){
global $mysqli;
if($comment=='')$comment="Перевод на карту ".$card2[number];
$out=round((float)$sum*$comission,0);
$in=round((float)$sum,2);
if(($sum*($comission-1))<$mincomission)$out=round($in+$mincomission,0);


$balance1=(float)$card1[balance]-$out;
$balance2=(float)$card2[balance]+$in;

mysqli_query($mysqli,"UPDATE `accounts` SET `balance`='".str_replace(',','.',$balance1)."' WHERE `accounts`.`id` = ".(int)$card1[id].";");
mysqli_query($mysqli,"UPDATE `accounts` SET `balance`='".str_replace(',','.',$balance2)."' WHERE `accounts`.`id` = ".(int)$card2[id].";");
mysqli_query($mysqli,"INSERT INTO `transactions` (`id`, `fromid`, `toid`, `sum`, `timestamp`, `comment`,`iswithdraw`) VALUES (NULL, '".(int)$card1[id]."', '".(int)$card2[id]."', '".str_replace(',','.',(float)$in)."', CURRENT_TIMESTAMP, '".mysqli_escape_string($mysqli,$comment)."', '".(int)$iswithdraw."');");

$card0=mysqli_query($mysqli,"SELECT * FROM accounts WHERE id=-1");
$card0=mysqli_fetch_assoc($card0);$balance3=$card0[balance]+($out-$in);
mysqli_query($mysqli,"UPDATE `accounts` SET `balance`='".str_replace(',','.',$balance3)."' WHERE `accounts`.`id` =-1;");
mysqli_query($mysqli,"INSERT INTO `transactions` (`id`, `fromid`, `toid`, `sum`, `timestamp`, `comment`) VALUES (NULL, '".(int)$card1[id]."', '".(int)$card0[id]."', '".str_replace(',','.',(float)($out-$in))."', CURRENT_TIMESTAMP, 'Комиссия за перевод на карту ".mysqli_escape_string($mysqli,$card2[number])."');");


sms($card1[phone],'Karta *'.substr($card1[number],-4).'; Spisanie; Uspeshno; Summa: '.number_format($out, 2, ',', ' ').' BCR (RUB); Ostatok '.number_format($balance1, 2, ',', ' ').' BCR (RUB); '.date('d.m.Y H:i:s').'; Limit: '.number_format($card1[lim], 2, ',', ' '));
sms($card2[phone],'Karta *'.substr($card2[number],-4).'; Popolnenie; Uspeshno; Summa: '.number_format($in, 2, ',', ' ').' BCR (RUB); '.mb_strtoupper(trim($card1[name1].' '.$card1[name2].' '.$card1[name3]),'utf-8').'; Ostatok '.number_format($balance2, 2, ',', ' ').' BCR (RUB); '.date('d.m.Y H:i:s').'; Limit: '.number_format($card2[lim], 2, ',', ' '));
return true;
}

function clear_phone($person_phone){
    $phone = preg_replace("/\D{1,}/", "", $person_phone);
    return $phone;
}

function luhn_test($num) {
    $str = '';
    foreach( array_reverse( str_split( $num ) ) as $i => $c ) $str .= ($i % 2 ? $c * 2 : $c );
    return array_sum( str_split($str) ) % 10 == 0;
}

function luhn_create($num) {
    $str = '';
    $str_arr = array_reverse( str_split( $num ) );
    foreach($str_arr as $i => $c ) $str .= ($i % 2 ? $c * 2 : $c );
    $res = array_sum( str_split($str) ) * 9;
    $latest = $res % 10;
    $str_tmp = $str_arr[0] + $latest;
    if($str_tmp >= 10){
       $str_tmp = $str_arr[0] - (10 - $latest); 
    } 
    $str_arr[0] = $str_tmp < 0 ? $str_arr[0] : $str_tmp;
    $num = implode(array_reverse($str_arr));
    return $num;
}

function add_card($target, $system, $card1){
    global $mysqli;
    $target = mysqli_escape_string($mysqli,$target);
    $target = clear_phone($target);
    $system = mysqli_escape_string($mysqli,$system);
    $card1 = mysqli_escape_string($mysqli,$card1);
    
    
    $myecho = json_encode($target);
    `echo " target: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($system);
    `echo " system: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($card1);
    `echo " card1: "  $myecho >>/tmp/qaz`;
    
    
    if($system == 'qiwi') $system_base = 'qiwi';
    if($system == 'ya') $system_base = 'yandex';
    
//    $string = "UPDATE accounts SET ". $system_base ." = " .$target. " WHERE id = ".(int)$card1;
//    $myecho = json_encode($string);
//    `echo " string: "  $myecho >>/tmp/qaz`;
    
    mysqli_query($mysqli,"UPDATE accounts SET ". $system_base ." = " .$target. " WHERE id = ".(int)$card1);
}

function recipient($target, $system, $card1){
    global $mysqli;
    $target = mysqli_escape_string($mysqli,$target);
    $target = clear_phone($target);
    $system = mysqli_escape_string($mysqli,$system);
    $card1 = mysqli_escape_string($mysqli,$card1);
    
    
    $myecho = json_encode($target);
    `echo " target_recipient: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($system);
    `echo " system_recipient: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($card1);
    `echo " card1_recipient: "  $myecho >>/tmp/qaz`;
    
    
    if($system == 'qiwi'){
        $system_base = 'qiwi';
        
    } 
    if($system == 'ya') $system_base = 'yandex';
    
    $string = "SELECT id FROM accounts WHERE ". $system_base ." = '$target'";
    
    $myecho = json_encode($string);
    `echo " string: "  $myecho >>/tmp/qaz`;
    
    $id_donor = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT id FROM accounts WHERE ". $system_base ." = '". $target ."' limit 1"));
    
    $myecho = json_encode($id_donor['id']);
    `echo " id_donor: "  $myecho >>/tmp/qaz`;
    
    if($id_donor['id'] == $card1){
        return true;
    }elseif(!$id_donor['id']){
        return true;
    }else{
        mysqli_query($mysqli, "UPDATE accounts SET black = 1, black_wallet='$target' WHERE id = '$card1'");
        return false;
    }
}

function recipient_oldest($target, $system, $card1){
    global $mysqli;
    $target = mysqli_escape_string($mysqli,$target);
    $target = clear_phone($target);
    $system = mysqli_escape_string($mysqli,$system);
    $card1 = $card1;
    
    
    $myecho = json_encode($target);
    `echo " target_recipient_oldest: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($system);
    `echo " system_recipient_oldest: "  $myecho >>/tmp/qaz`;
    $myecho = json_encode($card1);
    `echo " card1_recipient_oldest: "  $myecho >>/tmp/qaz`;
    
    
    if($system == 'qiwi'){
        $system_base = 'qiwi';  
    } 
    if($system == 'ya') $system_base = 'yandex';
    
    $string = "SELECT ". $system_base ." FROM accounts WHERE ". $system_base ." = '". $target ."' limit 1";
    
    $myecho = json_encode($string);
    `echo " string_oldest: "  $myecho >>/tmp/qaz`;
    
    $id_donor = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT ". $system_base ." FROM accounts WHERE ". $system_base ." = '". $target ."' limit 1"));
    
    $myecho = json_encode($id_donor["$system_base"]);
    `echo " id_donor_oldest: "  $myecho >>/tmp/qaz`;
    
    if($id_donor["$system_base"] == $card1["$system_base"]){
        return true;
    }else{
//        mysqli_query($mysqli, "UPDATE accounts SET black = 1 WHERE id = '$card1'");
        return false;
    }
}

function phone_utc($user_phone){
    global $mysqli;
    $phone = $user_phone;
    $phone = preg_replace("/^[8]/", '+7', $phone);
    $phone = preg_replace("/[^0-9]/", '', $phone);
    $phone=substr($phone,0,11);//echo($phone.'<hr>');
    $user_id = $user['id'];

    $ph_cod = substr($phone, 1, 3);
    $ph_numb = substr($phone, 4, 7);

    $sql = "SELECT `zone` FROM `time_zone` WHERE `phone_cod`='$ph_cod' AND `phone_from`<'$ph_numb' AND `phone_to`>'$ph_numb' LIMIT 1";
    $zone = mysqli_query($mysqli, $sql);
    $zone = mysqli_fetch_array($zone);
    $zone = $zone['zone'];
    
    return $zone;
}

function info_ip($ip_reg){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://ru.sxgeo.city/json/'.$ip_reg);//32b748942f69e9e841dc812be6b1e578
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $out = json_decode(curl_exec($curl), true);

        $out_fix = array('city' => $out['city']['name_ru'], 
                         'region'  => array('name_ru'=>$out['region']['name_ru'], 'timezone'=>$out['region']['timezone'], 'utc'=>$out['region']['utc']),
                        'country'  => array('name_ru'=>$out['country']['name_ru'], 'timezone'=>$out['country']['timezone'], 'utc'=>$out['country']['utc'])
                    );
        $info_ip = json_encode($out_fix, JSON_UNESCAPED_UNICODE);

        curl_close($curl);
    
        return $info_ip;
}


function get_in_translate_to_en($string, $gost=false)
{
    if($gost)
    {
        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");
    }
    else
    {
        $arStrES = array("ае","уе","ое","ые","ие","эе","яе","юе","ёе","ее","ье","ъе","ый","ий");
        $arStrOS = array("аё","уё","оё","ыё","иё","эё","яё","юё","ёё","её","ьё","ъё","ый","ий");        
        $arStrRS = array("а$","у$","о$","ы$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$","@","@");

        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                "Е"=>"Ye","е"=>"e","Ё"=>"Ye","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                "Й"=>"Y","й"=>"y","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
                "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
                "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"Kh","х"=>"kh","Ц"=>"Ts","ц"=>"ts","Ч"=>"Ch","ч"=>"ch",
                "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
                "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye");

        $string = str_replace($arStrES, $arStrRS, $string);
        $string = str_replace($arStrOS, $arStrRS, $string);
    }

    return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}

function update_comiss(){
	global $mysqli;
    foreach($_POST['id'] as $key1 => $id){
        $sum = (int)$_POST['sum'][$key1];
        $comission = (int)$_POST['comission'][$key1];
        $id = (int)$id;

        if($_POST['action'][$key1] == 2){
            $sql = "INSERT INTO comissions (sum, comission) values ('$sum', '$comission')";
            mysqli_query($mysqli, $sql);

        }elseif($_POST['action'][$key1] == 1){
            $sql = "UPDATE comissions SET `sum`='$sum', `comission`='$comission' WHERE `id`=$id";
            mysqli_query($mysqli, $sql);

        }elseif($_POST['action'][$key1] == 3 && $_POST['id'][$key1] != 0){
            $sql = "DELETE FROM comissions WHERE `id`='$id'";
            mysqli_query($mysqli, $sql);
        }
    }
}

function update_min_ball($table){
	global $mysqli;
	foreach($_POST['id'] as $key1 => $id){
		$sum = (int)$_POST['sum'][$key1];
		$add_sum = (int)$_POST['add_sum'][$key1];
		$max = (int)$_POST['max'][$key1];
		$id = (int)$id;

		if($_POST['action'][$key1] == 2){
			$sql = "INSERT INTO $table (sum, add_sum, max) values ('$sum', '$add_sum', '$max')";
			mysqli_query($mysqli, $sql);

		}elseif($_POST['action'][$key1] == 1){

			$sql = "UPDATE $table SET `sum`='$sum', `add_sum`='$add_sum', `max`='$max' WHERE `id`=$id";
			mysqli_query($mysqli, $sql);

		}elseif($_POST['action'][$key1] == 3 && $_POST['id'][$key1] != 0){
			$sql = "DELETE FROM $table WHERE `id`='$id'";
			mysqli_query($mysqli, $sql);
		}
	}
}

function check_5($mysqli){
	$info_5=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='bankomat' AND amount='5'");
    if($info_5){
        $info_5=mysqli_fetch_assoc($info_5);
        $token_proxy = json_decode($info_5["token"], true);
        $token = ($token_proxy["token"]);
        $proxy_ip = ($token_proxy["ip"]);
        $proxy_port = ($token_proxy["port"]);
        $proxy_usr = ($token_proxy["usr"]);
        $proxy_pass = ($token_proxy["pass"]);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token) //$qiwi_token
        ); 
        curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
        curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
        curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
        $out_count_5 = curl_exec($curl); //my
        $out_count_5 = json_decode($out_count_5);
        $out_count_5 = $out_count_5->accounts[0]->balance->amount;
        
        $myecho = json_encode($out_count_5);
        `echo "out_count_5: "  $myecho >>/home/bartercoin/tmp/qaz_add_b`;
    }
    curl_close($curl);
    return $out_count_5;
}

function check_9($mysqli){
    $info_5=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='bankomat' AND amount='9'");
    if($info_5){
        $info_5=mysqli_fetch_assoc($info_5);
        $token_proxy = json_decode($info_5["token"], true);
        $token = ($token_proxy["token"]);
        $proxy_ip = ($token_proxy["ip"]);
        $proxy_port = ($token_proxy["port"]);
        $proxy_usr = ($token_proxy["usr"]);
        $proxy_pass = ($token_proxy["pass"]);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://ressssstapi:8000/payeer');
        $payeerId= $token_proxy['payeer'];

        $recipient=$_POST['target'];
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS  ,
            "hash=$token&sender=$payeerId&action=ballance");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out_count = curl_exec($curl);
        curl_close($curl);
        $out_count = json_decode($out_count);
// var_dump($out_count);
        $out_count = $out_count->ball;
//    var_dump($out_count);

        $myecho = json_encode($out_count);
        `echo "out_count_9: "  $myecho >>/home/bartercoin/tmp/qaz_add_b`;
    }
    curl_close($curl);
    return $out_count;
}





function update_util(){
	global $mysqli;
    
    //$myecho = json_encode($_POST);
    //`echo " _POST_update_util: "  $myecho >>/tmp/qaz`;
    
	foreach($_POST['id'] as $key1 => $id){
		$name = mysqli_escape_string($mysqli, $_POST['name'][$key1]);
		$util_id_recip = mysqli_escape_string($mysqli, $_POST['util_id_recip'][$key1]);
        $util_id_prov = mysqli_escape_string($mysqli, $_POST['util_id_prov'][$key1]);
		$util_value = (int)$_POST['util_value'][$key1];
        $util_day = (int)$_POST['util_day'][$key1];
        $util_time = date('H:i:s', strtotime($_POST['util_time'][$key1]));
        $prior = (int)$_POST['prior'][$key1];
        $min_fiat = (int)$_POST['min_fiat'][$key1];
        if($_POST['pay'][$key1]){
            $pay = 1;
        }else{
            $pay = 0;
        }
		$id = (int)$id;

		if($_POST['action'][$key1] == 2){
			$sql = "INSERT INTO util (name, util_id_recip, util_id_prov, util_value, util_day, util_time, prior, min_fiat, pay) values ('$name', '$util_id_recip', '$util_id_prov', '$util_value', '$util_day', '$util_time', '$prior', '$min_fiat', '$pay')";
			$res = mysqli_query($mysqli, $sql);
		}elseif($_POST['action'][$key1] == 1){
			$sql = "UPDATE util SET `name`='$name', `util_id_recip`='$util_id_recip', `util_id_prov`='$util_id_prov', `util_value`='$util_value', `util_day`='$util_day', `util_time`='$util_time', `prior`='$prior', `min_fiat`='$min_fiat', `pay`='$pay' WHERE `id`=$id";
			mysqli_query($mysqli, $sql);
		}elseif($_POST['action'][$key1] == 3 && $_POST['id'][$key1] != 0){
			$sql = "DELETE FROM util WHERE `id`='$id'";
			mysqli_query($mysqli, $sql);
		}
	}
}

//банкоматы
function get_bank($mysqli, $num){
    $sql = "SELECT amount_max FROM settings WHERE `title`='bankomat' AND `amount`='".(int)$num."'";
    $res = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
    //sql_err($mysqli, 'SELECT amount_max FROM settings bankomat');
    $sum = $res['amount_max'];
    return $sum;
}
function get_bank_time($mysqli, $num){
    $sql = "SELECT last_time FROM settings WHERE `title`='bankomat' AND `amount`='".(int)$num."'";
    $res = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
    //sql_err($mysqli, 'SELECT last_time FROM settings bankomat');
    $last_time = $res['last_time'];
    return $last_time;
}
function put_bank($mysqli, $num, $sum){
    $sql = "UPDATE settings SET amount_max='".(float)$sum."', last_time=CURRENT_TIMESTAMP WHERE title='bankomat' AND amount='".(int)$num."'";
    $res = mysqli_query($mysqli, $sql);
    //sql_err($mysqli, 'UPDATE settings SET amount_max bankomat');
    
    if($res){
        return true; 
    }else{
        return false;
    }
}

?>
