<?php
// Îòïðàâêà ñìñ ñîîáùåíèÿ
function send_sms_msg($phone, $sms_text, $sender_text_name='')
{ 
	//	ini_set('display_errors', 1);
	//include_once $_SERVER['DOCUMENT_ROOT']."/classes/class.Sms.php";
	include_once $_SERVER['DOCUMENT_ROOT']."/inc/ssms_su.php";
	//include_once $_SERVER['DOCUMENT_ROOT']."/classes/transport.php";
	 
	//$api = new Transport(); 
	
	// Âàëèäàöèÿ òåë. íîìåðà
	$phone = valid_user_phone_for_sms($phone);
	
	 
	if(!$phone)
	{
		return false;
	}
        
	$email = "bartercoin";//"hrm-militcorp";
	$password = "223mxzeq";//"63ghjz1y";
	
	if(preg_match('/\+38/', $phone) || $sender_text_name)
	{
		$sender_phone = 'EasyWork24';
	}
	else
	{
		$sender_phone = TRANSACTION_SMS; //ROUND_SENDER_NAME;
	}
	  
	// Ëîã
//	sms_to_log($phone, $sms_text);
	
	
	// Åñëè âêëþ÷åíà îïöèÿ îòïðàâêè ñìñ
	if(!SMS)
	{
		return false;
	}
	
	/*if(!$sender_text_name)
	{
		$sms_text = substr($sms_text,0,70);
	}*/

	##### transport.php
	//if($sender_text_name)
//	{
//		$api->send(array('text' => iconv('cp1251', 'utf-8',$sms_text), 'source' => 'easywork24'), array($phone));
//	}
//	else
//	{
//		$api->send(array('text' => iconv('cp1251', 'utf-8',$sms_text), 'onlydelivery' => 1, 'use_alfasource' => 0), array($phone));
//	}
	####
 
	
	$r = smsapi_push_msg_nologin($email, $password, $phone, $sms_text, array("sender_name"=>$sender_phone));

 // print_r($r);
 
	return $r;

}

// Çàïèñü â ëîã
function sms_to_log($phone, $text)
{
	global $site_db, $current_user_id;
	
	//$text = value_proc($text, 0);
	
	$sql = "INSERT INTO ".SMS_LOG_TB." (date, user_id, phone, text) VALUES (NOW(), '$current_user_id', '$phone', '$text')";
	 
	$site_db->query($sql);
}

// Âàëèäàöèÿ íîìåðà òåëåôîíà äëÿ îòïðàâêè ÷åðåç ñìñ
function valid_user_phone_for_sms($phone)
{
	return $phone;
	
	
	$phone = preg_replace('/[^\+0-9]+/', '', $phone);
	
	if(strlen($phone)==11 && $phone[0]==8)
	{
		$phone = substr($phone,1,11);
	}
	if(strlen($phone)==10)
	{
		$phone = '+7'.$phone;
	}

	// Åñëè íîìåð òåëåôîíà íåêîððåêòíî çàäàí, âîçâðàùàåì false
	 
	return $phone;
	
}
?>
