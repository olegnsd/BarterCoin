<?php
ini_set('display_errors', 0);
include('../old/config.php');
require('../inc/session.php');//session_start();
require('../adm/auth.php');


if($auth){

if(isset($_GET['user_id'])){
	$akcioner = mysqli_fetch_row(mysqli_query($mysqli, "SELECT * FROM accounts WHERE id=". (int)$_GET['user_id'] ." LIMIT 1;"));
	echo json_encode($akcioner);//, JSON_UNESCAPED_UNICODE
	exit;
}

if(isset($_GET['trans_all'])){
	// Определяем общее число сообщений в базе данных
	$posts = mysqli_fetch_array(mysqli_query($mysqli, "SELECT MAX(id) FROM transactions"));

	// Находим общее число страниц
	$trans_all = $posts['MAX(id)'];
	
	if((int)$_GET['trans_all'] < $trans_all){
		$trans_get = (int)$_GET['trans_all'] + 1;
		$num = $trans_all - $trans_get + 1;
		
		$myecho = json_encode($trans_all ."  ". $trans_get ."  ". $num);
		`echo "trans_all trans_get num: "  $myecho >>/var/www/tmp/qaz`;	
		
		$result = mysqli_query($mysqli, "SELECT * FROM transactions WHERE id>='$trans_get' LIMIT $num;");
		// В цикле переносим результаты запроса в массив $postrow
		while ( $postrow[] = mysqli_fetch_array($result));
	}
	if(!isset($postrow))$postrow[]='n';
	echo json_encode($postrow);//, JSON_UNESCAPED_UNICODE
	exit;
}

if(isset($_GET['trans_id'])){
	$user = mysqli_fetch_row(mysqli_query($mysqli, "SELECT * FROM util WHERE id=". (int)$_GET['trans_id'] ." LIMIT 1;"));
	echo json_encode($user);//, JSON_UNESCAPED_UNICODE
	exit;
}

}
