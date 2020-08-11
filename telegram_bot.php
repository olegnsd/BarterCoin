<?php

ini_set('display_errors', 1);

require('inc/init.php');

// сюда нужно вписать токен вашего бота
define('TELEGRAM_TOKEN', '949409117:AAEIxMN9oKjS6qU0Sz3jmxlpMCRfaZ8KUvA');

// сюда нужно вписать ваш внутренний айдишник
define('TELEGRAM_CHATID', '568026375');//568026375 my 809982080 my2  949409117 bot  -357189405 chat 216720947 nsd

//message_to_telegram('barter_2');
get_chat();
//set_webhook();

function message_to_telegram($text)
{
	$proxy_ip = PROXY_IP;//'192.168.37.36';//'192.168.37.23';
	$proxy_usr = PROXY_USR;
	$proxy_pass = PROXY_PASS;
    $json_data = json_encode(array(
                'chat_id' => TELEGRAM_CHATID,
                'text' => $text,
            ));
    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
            CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json_data)),
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_PROXY => $proxy_ip,
            //CURLOPT_PROXYPORT => $proxy_port,
            CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5,
            CURLOPT_PROXYAUTH => CURLAUTH_BASIC,
            CURLOPT_PROXYUSERPWD => $proxy_usr.':'.$proxy_pass
        )
    );
    $res = curl_exec($ch);
    
    echo('res: ' .json_encode(json_decode($res), JSON_UNESCAPED_UNICODE));
    echo('<br>');
    echo('err: ' .json_encode(json_decode(curl_error($ch)), JSON_UNESCAPED_UNICODE));
//    echo(iconv('cp1251', 'utf-8', $res));
}

function get_chat()
{
	$proxy_ip = PROXY_IP;//'192.168.37.36';//'192.168.37.23';
	$proxy_usr = PROXY_USR;
	$proxy_pass = PROXY_PASS;
    $json_data = array(
                'chat_id' => TELEGRAM_CHATID,
            );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/getUpdates');
    curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
                    'Content-Type: multipart/form-data'));
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
	//curl_setopt($ch, CURLOPT_PROXYPORT , $proxy_port);
	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
    
    $res = curl_exec($ch);
    
    echo('<pre>');
    var_dump(json_decode(json_encode(json_decode($res), JSON_UNESCAPED_UNICODE)), true);
    echo('</pre>');
//    echo(iconv('cp1251', 'utf-8', $res));
}

function set_webhook()
{
	$proxy_ip = PROXY_IP;//'192.168.37.36';//'192.168.37.23';
	$proxy_usr = PROXY_USR;
	$proxy_pass = PROXY_PASS;
    $json_data = array(
                'url' => "$proxy_ip/telegram_recive.php",
            );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/setWebhook');
    curl_setopt($ch, CURLOPT_HTTPHEADER,  array(
                    'Content-Type: multipart/form-data'));
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
	//curl_setopt($ch, CURLOPT_PROXYPORT , $proxy_port);
	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
    
    $res = curl_exec($ch);
    
    echo('<pre>');
    var_dump(json_decode(json_encode(json_decode($res), JSON_UNESCAPED_UNICODE)), true);
    echo('</pre>');
//    echo(iconv('cp1251', 'utf-8', $res));
}
