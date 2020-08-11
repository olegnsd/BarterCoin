<?php
ini_set('display_errors', 0);
include('../old/config.php');
require('../old/functions.php');
require('../inc/session.php');//session_start();
require('auth.php');
//session_start();
$jsScript = false;
//ini_set('session.gc_maxlifetime', 86400);

//if(!isset($_GET[p]))$_GET[p] = 0;
if($_GET['sort'] && !isset($_GET[p])){
    if($_SESSION['sort'. (int)$_GET['sort']] == 'ASC'){
        $_SESSION['sort'. (int)$_GET['sort']] = 'DESC';
    }else{
        $_SESSION['sort'. (int)$_GET['sort']] = 'ASC';
    }
    $_SESSION['sorted'] = (int)$_GET['sort'];
}

if($_GET['card_id']){
	$card_id = (int)$_GET['card_id'];
	$_GET['sort'] = 33;
}?>

<!DOCTYPE html>
<html>
<head>
<title>BarterCoin - Бартерная платежная система</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/fixbootstrap.min.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/styles.css?v=1.6" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!-- js -->
<script src="../js/jquery.min.js"></script><script src="../js/jquery.maskedinput.min.js"></script>
<script src="../js/scripts.js?v=1.7"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="../js/move-top.js"></script>
<script type="text/javascript" src="../js/easing.js"></script>
<!--    рекапча-->
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : '6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB',
            'callback': 'activ_sub',
             'theme'  : 'light',
//            'size'    : 'compact'
        });
    };
    function activ_sub(token){
        $("#send_butt").prop("disabled", false);
    }
</script>
</head>

<? 
//require('../inc/SxGeo.php');
if($auth){
//header('Content-Type: image/jpeg');
if($_GET['settings']=="11"){
    if($auth){
        $no404=true;
        include('settings11.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="12"){
    if($auth){
        $no404=true;
        include('settings12.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="13"){
    if($auth){
        $no404=true;
        include('settings13.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
            <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="2"){
    if($auth){
        $no404=true;
        include('settings2.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="3"){
    if($auth){
        $no404=true;
        include('settings3.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="4"){
    if($auth){
        $no404=true;
        include('settings4.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="5"){
    if($auth){
        $no404=true;
        include('settings5.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="6"){
    if($auth){
        $no404=true;
        include('settings6.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="7"){
    if($auth){
        $no404=true;
        include('settings7.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['settings']=="8"){
    if($auth){
        $no404=true;
        if($account['util']){
            include('settings8.php');
        }else{?>
            <body class="cbp-spmenu-push">
            <!-- header -->
            <? include('top.php');?>
                <h3><span class="label label-warning center-block">Нет доступа</span></h3> 
        <?}
    }
}elseif($_GET['settings']=="9"){
    if($auth){
        $no404=true;
        if($account['util']){
            include('settings9.php');
        }else{?>
            <body class="cbp-spmenu-push">
            <!-- header -->
            <? include('top.php');?>
                <h3><span class="label label-warning center-block">Нет доступа</span></h3> 
        <?}
    }
}elseif($_GET['loan']){
    if($auth){
        $no404=true;
        include('loan.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}
}elseif($_GET['loan_add']){
    if($auth){
        ini_set('display_errors', 0);
        $no404=true;
        include('loan_add.php');
    }else{?>
        <form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
        <br><br>
        <form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
        <input type="submit" class="btn btn-success" value="Войти">
        </form>
    <?}

}else{?>
	<body class="cbp-spmenu-push">
		<!-- header -->
		<? include('top.php');?>
		<!-- banner-bottom -->
		<div  class="banner-bottom">
			<!-- container -->
			<div class="container"><!--div class="alert alert-danger">Система начинает работу 15 января 2017 года</div-->
						<?if($auth){
	for($i = 1; $i <= 32; $i++){
		if($_SESSION['sort'. $i] == 'ASC'){
			$class_s[] = 'up';
		}else{
			$class_s[] = 'down';
		}

	}
	$sort_up_dwn_1=' <a href="?sort=1"><i class="fa fa-chevron-'. $class_s[0] .'"></i></a>';
	$sort_up_dwn_2=' <a href="?sort=2"><i class="fa fa-chevron-'. $class_s[1] .'"></i></a>';
	$sort_up_dwn_3=' <a href="?sort=3"><i class="fa fa-chevron-'. $class_s[2] .'"></i></a>';
	$sort_up_dwn_4=' <a href="?sort=4"><i class="fa fa-chevron-'. $class_s[3] .'"></i></a>';
	$sort_up_dwn_5=' <a href="?sort=5"><i class="fa fa-chevron-'. $class_s[4] .'"></i></a>';
	$sort_up_dwn_6=' <a href="?sort=6"><i class="fa fa-chevron-'. $class_s[5] .'"></i></a>';
	$sort_up_dwn_7=' <a href="?sort=7"><i class="fa fa-chevron-'. $class_s[6] .'"></i></a>';
	$sort_up_dwn_8=' <a href="?sort=8"><i class="fa fa-chevron-'. $class_s[7] .'"></i></a>';
	$sort_up_dwn_9=' <a href="?sort=9"><i class="fa fa-chevron-'. $class_s[8] .'"></i></a>';
	$sort_up_dwn_10=' <a href="?sort=10"><i class="fa fa-chevron-'. $class_s[9] .'"></i></a>';
	$sort_up_dwn_11=' <a href="?sort=11"><i class="fa fa-chevron-'. $class_s[10] .'"></i></a>';
	$sort_up_dwn_12=' <a href="?sort=12"><i class="fa fa-chevron-'. $class_s[11] .'"></i></a>';
	$sort_up_dwn_13=' <a href="?sort=13"><i class="fa fa-chevron-'. $class_s[12] .'"></i></a>';
	$sort_up_dwn_14=' <a href="?sort=14"><i class="fa fa-chevron-'. $class_s[13] .'"></i></a>';
	$sort_up_dwn_15=' <a href="?sort=15"><i class="fa fa-chevron-'. $class_s[14] .'"></i></a>';
	$sort_up_dwn_16=' <a href="?sort=16"><i class="fa fa-chevron-'. $class_s[15] .'"></i></a>';
	$sort_up_dwn_17=' <a href="?sort=17"><i class="fa fa-chevron-'. $class_s[16] .'" title="активированные"></i></a>';
	$sort_up_dwn_18=' <a href="?sort=18"><i class="fa fa-chevron-'. $class_s[17] .'" title="активированные"></i></a>';
	$sort_up_dwn_19=' <a href="?sort=19"><i class="fa fa-chevron-'. $class_s[18] .'" title="активированные"></i></a>';
	$sort_up_dwn_20=' <a href="?sort=20"><i class="fa fa-chevron-'. $class_s[19] .'" title="активированные"></i></a>';
	$sort_up_dwn_21=' <a href="?sort=21"><i class="fa fa-chevron-'. $class_s[20] .'" title="активированные"></i></a>';
	$sort_up_dwn_22=' <a href="?sort=22"><i class="fa fa-chevron-'. $class_s[21] .'" title="активированные"></i></a>';
	$sort_up_dwn_23=' <a href="?sort=23"><i class="fa fa-chevron-'. $class_s[22] .'" title="активированные"></i></a>';
	$sort_up_dwn_24=' <a href="?sort=24"><i class="fa fa-chevron-'. $class_s[23] .'" title="активированные"></i></a>';
	$sort_up_dwn_25=' <a href="?sort=25"><i class="fa fa-chevron-'. $class_s[24] .'" title="активированные"></i></a>';
	$sort_up_dwn_26=' <a href="?sort=26"><i class="fa fa-chevron-'. $class_s[25] .'" title="активированные"></i></a>';
	$sort_up_dwn_27=' <a href="?sort=27"><i class="fa fa-chevron-'. $class_s[26] .'" title="активированные"></i></a>';
	$sort_up_dwn_28=' <a href="?sort=28"><i class="fa fa-chevron-'. $class_s[27] .'" title="активированные"></i></a>';
	$sort_up_dwn_29=' <a href="?sort=29"><i class="fa fa-chevron-'. $class_s[28] .'" title="активированные"></i></a>';
	$sort_up_dwn_30=' <a href="?sort=30"><i class="fa fa-chevron-'. $class_s[29] .'" title="активированные"></i></a>';
	$sort_up_dwn_31=' <a href="?sort=31"><i class="fa fa-chevron-'. $class_s[30] .'" title="активированные"></i></a>';
	$sort_up_dwn_32=' <a href="?sort=32"><i class="fa fa-chevron-'. $class_s[31] .'" title="активированные"></i></a>';

	$query = array('', 'ORDER BY `number`', 'ORDER BY `expiremonth`, `expireyear`', 'ORDER BY `cvc`', 'ORDER BY `activated`', 'ORDER BY `black`', 'ORDER BY `name1`', 'ORDER BY `info_ip`', 'ORDER BY `phone`', 'ORDER BY `balance`', 'ORDER BY `bankomats`', 'ORDER BY `lim`', 'ORDER BY `monthlim`', 'ORDER BY `withdrawlim`', 'ORDER BY `lim_one`', 'ORDER BY `withdraw_int`', 'ORDER BY `amount_ref`', 'WHERE `activated`=1 ORDER BY `number`', 'WHERE `activated`=1 ORDER BY `expiremonth`, `expireyear`', 'WHERE `activated`=1 ORDER BY `cvc`', 'WHERE `activated`=1 ORDER BY `activated`', 'WHERE `activated`=1 ORDER BY `black`', 'WHERE `activated`=1 ORDER BY `name1`', 'WHERE `activated`=1 ORDER BY `info_ip`', 'WHERE `activated`=1 ORDER BY `phone`', 'WHERE `activated`=1 ORDER BY `balance`', 'WHERE `activated`=1 ORDER BY `bankomats`', 'WHERE `activated`=1 ORDER BY `lim`', 'WHERE `activated`=1 ORDER BY `monthlim`', 'WHERE `activated`=1 ORDER BY `withdrawlim`', 'WHERE `activated`=1 ORDER BY `lim_one`', 'WHERE `activated`=1 ORDER BY `withdraw_int`', 'WHERE `activated`=1 ORDER BY `amount_ref`', "WHERE `id`= '$card_id'");

	$query1 = 'ORDER BY id DESC';
	if(isset($_SESSION['sorted'])){
		$query1 = $query[(int)$_SESSION['sorted']] ." ". $_SESSION['sort'. (int)$_SESSION['sorted']];
	}
	if(array_key_exists((int)$_GET['sort'], $query)){
		$query1 = $query[(int)$_GET['sort']] ." ". $_SESSION['sort'. (int)$_GET['sort']];
	}
?>						
<h2 style="text-align:center;">Счета</h2>
<?$info=mysqli_query($mysqli,"SELECT SUM(balance),SUM(lim) FROM accounts");
$info=mysqli_fetch_assoc($info);
$info2=mysqli_query($mysqli,"SELECT SUM(balance) FROM accounts WHERE balance>0");
$info2=mysqli_fetch_assoc($info2);

$info3=mysqli_query($mysqli,"SELECT SUM(balance) FROM accounts WHERE balance<0");
$info3=mysqli_fetch_assoc($info3);?><p>Общая сумма: <?=$info["SUM(balance)"];?>; Общий лимит: <?=$info["SUM(lim)"];?>; Сумма + балансов: <?=$info2["SUM(balance)"];?>; Сумма - балансов: <?=$info3["SUM(balance)"];?>
</p>
<?$_GET[p]=(int)$_GET[p];
$offset=100*$_GET[p];
$orders=array('','ORDER BY `activated` DESC ','ORDER BY `balance` DESC ','ORDER BY `balance`','ORDER BY `black` DESC ','WHERE info_ip NOT LIKE CONCAT("%" , phone_utc , "%") ', 
              'SELECT a.*, l.sum_loan, l.sum_issuse, l.decision, l.id AS loan_id FROM accounts a, loans l WHERE a.id = l.user_id ORDER BY l.user_id DESC ', 
              'SELECT a.*, l.sum_loan, l.sum_issuse, l.decision, l.id AS loan_id FROM accounts a, loans l WHERE a.id = l.user_id AND (l.decision = 3 OR l.decision = 5) ORDER BY l.user_id DESC ', 
              'SELECT a.*, l.sum_loan, l.sum_issuse, l.decision, l.id AS loan_id FROM accounts a, loans l WHERE a.id = l.user_id AND (l.decision = 0  OR l.decision = 6) ORDER BY l.user_id DESC ', 
              'SELECT a.*, l.sum_loan, l.sum_issuse, l.decision, l.id AS loan_id FROM accounts a, loans l WHERE a.id = l.user_id AND l.decision = 1 ORDER BY l.user_id DESC ',
              'SELECT a.*, l.sum_loan, l.sum_issuse, l.decision, l.id AS loan_id FROM accounts a, loans l WHERE a.id = l.user_id AND l.decision = 2 ORDER BY l.user_id DESC ');
$order=$orders[$_GET[order]];
//$result=mysqli_query($mysqli,"SELECT * FROM accounts ".$order."LIMIT ".(int)$offset.",100;");
if(isset($_GET[order]) & $_GET[order] <= 5){
    $result=mysqli_query($mysqli,"SELECT * FROM accounts ".$order."LIMIT ".(int)$offset.",100;");
}elseif(isset($_GET[order])){
    $result=mysqli_query($mysqli, $order."LIMIT ".(int)$offset.",100;");
}elseif(isset($_GET['sort'])){
    $result=mysqli_query($mysqli,"SELECT * FROM accounts ".$query1." LIMIT ".(int)$offset.",100;");
}else{
	$result=mysqli_query($mysqli,"SELECT * FROM accounts ".$order."LIMIT ".(int)$offset.",100;");
}
if(!$result | !mysqli_num_rows($result))echo('<div class="alert">не найдены</div>');else{ 
$account=mysqli_fetch_assoc($result);
?>
<a href="?order=0"<?if($_GET[order]==0)echo(' style="font-weight:bold;"');?>>Без сортировки</a> | 
<a href="?order=1"<?if($_GET[order]==1)echo(' style="font-weight:bold;"');?>>Активированные сверху</a> | 
<a href="?order=2"<?if($_GET[order]==2)echo(' style="font-weight:bold;"');?>>Наибольший баланс сверху</a> | 
<a href="?order=3"<?if($_GET[order]==3)echo(' style="font-weight:bold;"');?>>Наименьший баланс сверху</a> |
<a href="?order=4"<?if($_GET[order]==4)echo(' style="font-weight:bold;"');?>>Черный список сверху</a> | 
<a href="?order=5"<?if($_GET[order]==5)echo(' style="font-weight:bold;"');?>>Зона телеф != ip</a> | 
<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <? if($_GET[order]==6){?><span class="btn btn-default btn-xs">Займы все</span>
    <?}elseif($_GET[order]==7){?><span class="btn btn-success btn-xs">Займы выданные</span>
    <?}elseif($_GET[order]==8){?><span class="btn btn-warning btn-xs">Займы на рассмотр</span>
    <?}elseif($_GET[order]==9){?><span class="btn btn-default btn-xs success_s">Займы разреш</span>
    <?}elseif($_GET[order]==10){?><span class="btn btn-danger btn-xs">Займы запрещ</span>
    <?}else{?>Займы<?}?>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dLabel">
    <li><a href="?order=6" class="btn btn-default btn-xs">Займы все</a></li>
    <li><a href="?order=8" class="btn btn-warning btn-xs">Займы на рассмотр</a></li>
    <li><a href="?order=9" class="btn btn-default btn-xs success_s">Займы разреш</a></li>
    <li><a href="?order=7" class="btn btn-success btn-xs">Займы выданные</a></li>
    <li><a href="?order=10" class="btn btn-danger btn-xs">Займы запрещ</a></li>
  </ul>
</div>
<table class="table">
<thead><th>Карта<th>Мес/Год<th>CVC<th>Актив.<th>Черн.<br>Спис.<th>ФИО<th>ip info<th>Тел.<th>Баланс<th>Банкоматы(через,)<th>Кред. Лимит<th>Мес. лимит<th>Суточный лимит на вывод<th>Разовый лимит на вывод<th>Интервал на вывод мин<th>Кол-во пригла-шений в день<th>
</thead>
<tr>
	<td><?=$sort_up_dwn_1?><?=$sort_up_dwn_17?></td>
	<td><?=$sort_up_dwn_2?><?=$sort_up_dwn_18?></td>
	<td><?=$sort_up_dwn_3?><?=$sort_up_dwn_19?></td>
	<td><?=$sort_up_dwn_4?><?=$sort_up_dwn_20?></td>
	<td><?=$sort_up_dwn_5?><?=$sort_up_dwn_21?></td>
	<td><?=$sort_up_dwn_6?><?=$sort_up_dwn_22?></td>
	<td><?=$sort_up_dwn_7?><?=$sort_up_dwn_23?></td>
	<td><?=$sort_up_dwn_8?><?=$sort_up_dwn_24?></td>
	<td><?=$sort_up_dwn_9?><?=$sort_up_dwn_25?></td>
	<td><?=$sort_up_dwn_10?><?=$sort_up_dwn_26?></td>
	<td><?=$sort_up_dwn_11?><?=$sort_up_dwn_27?></td>
	<td><?=$sort_up_dwn_12?><?=$sort_up_dwn_28?></td>
	<td><?=$sort_up_dwn_13?><?=$sort_up_dwn_29?></td>
	<td><?=$sort_up_dwn_14?><?=$sort_up_dwn_30?></td>
	<td><?=$sort_up_dwn_15?><?=$sort_up_dwn_31?></td>
	<td><?=$sort_up_dwn_16?><?=$sort_up_dwn_32?></td>
</tr>   
<?do{
	$info_ip = json_decode($account['info_ip'], true);
//    $utc_phone = utc_phone($account['phone'], $mysqli); //узнать зону телефона
    $utc_phone = $account['phone_utc']; //узнать зону телефона
    $war_zone = "";
    $war_class = "alert-xs alert-success";
    if($utc_phone <> $info_ip['region']['utc']){ //зона по ип и телефона не совпали
        $war_zone = "не совпала с ip";
        $war_class = "alert-xs alert-danger";
    }
    if($utc_phone=="" || $info_ip['region']['utc']==""){ //зона не определена
        $war_zone = "не определено";
        $war_class = "alert-xs alert-default";
    }
    $bankomats = json_decode($account['bankomats'], true);
    $bankomats = implode(',', $bankomats['allow']);
?>
<tr><form id="form<?=$account[id];?>" method=post  onsubmit="var msg   = $('#form<?=$account[id];?>').serialize();
        $.ajax({
          type: 'POST',
          url: 'do.php',
          data: msg,
          success: function(data) {
            exchange(data, '<?=$account['id'];?>', '<?=$account['black_wallet'];?>'); 
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });return false;">   
        <td><input type="hidden" name="id" value="<?=$account[id];?>"><?=$account[number];?><br>ip: <a href="https://yandex.ru/search/?text=<?=$account['ip_reg']?>"  target="_blank"><?=$account['ip_reg']?></a>
	    <br>
	    <div id="black<?=$account[id];?>">
	       <?if($account[black]==1){
	            echo('<span class="alert-xs alert-danger">В Черном Списке, попытка вывести на '. $account['black_wallet'] .'</span>'); 
	        }?>
	    </div>
	    <td><?=$account[expiremonth];?>/<?=$account[expireyear];?>
	    <td style="min-width:50px;"><?=$account[cvc];?>
	    <td><input type="checkbox" name="activated" id="activated<?=$account[id];?>" value="1" <?if($account[activated]==1)echo(" CHECKED");?>>
	    <td><input type="checkbox" name="black" id="activated<?=$account[id];?>" value="1" <?if($account[black]==1)echo(" CHECKED");?>>
	    <td style="min-width:150px;"><input type="text" class="form-control" name="name1" value="<?=htmlspecialchars($account[name1]);?>"> <input type="text" class="form-control" name="name2" value="<?=htmlspecialchars($account[name2]);?>"> <input type="text" class="form-control" name="name3" value="<?=htmlspecialchars($account[name3]);?>">
	    <td style="min-width:100px;"><span class="<?=$war_class?>">Город: <?=$info_ip['city']?><br>utc: <?=$info_ip['region']['utc']?><br>Регион: <?=$info_ip['region']['name_ru']?><br>Страна: <?=$info_ip['country']['name_ru']?></span>
	    <td style="min-width:100px;"><input type="text" class="form-control" name="phone_main" value="<?=htmlspecialchars($account[phone]);?>"><br><span class="<?=$war_class?>">utc: <?=$utc_phone?><br><?=$war_zone?></span>
	    <td><?=htmlspecialchars($account[balance]);?>
	    <td style="min-width:100px;"><input type="text" class="form-control" name="bankomats" value="<?=$bankomats;?>">
	    <td style="min-width:100px;"><input type="text" class="form-control" name="lim" value="<?=htmlspecialchars($account[lim]);?>">
	    <?  $attr_hid="";
        $class2 = '';
	    if(!$account['loan_id']){$attr_hid="hidden";
	    }elseif($account['decision'] == 0){$class="warning"; $title="На рассмотр";
	    }elseif($account['decision'] == 1){$class="default"; $class2="success_s"; $title="Разрешен";
	    }elseif($account['decision'] == 2){$class="danger"; $title="Запрещен";
	    }elseif($account['decision'] == 3 || $account['decision'] == 5){
        $class="success"; $title="Выдан";
	    }elseif($account['decision'] == 6){$class="warning"; $title="Доп доки";}
	    ?>
	    <a href="?loan=<?=$account['loan_id']?>" type="" class="btn btn-<?=$class?> btn-xs <?=$class2?> <?=$attr_hid?>" title="<?=$title?>">
	        Займ <?=$account['sum_loan']?>
	        <? if($account['sum_loan'] > $account['sum_issuse'] && $account['sum_issuse'] > 0){?>
	            (<?=$account['sum_issuse']?>)
	        <?}?>
	    </a>
	    <td style="min-width:100px;"><input type="text" class="form-control" name="monthlim" value="<?=htmlspecialchars($account[monthlim]);?>">
	    <td style="min-width:100px;"><input type="text" class="form-control" name="withdrawlim" value="<?=htmlspecialchars($account[withdrawlim]);?>">
	    <td style="min-width:100px;"><input type="text" class="form-control" name="lim_one" value="<?=htmlspecialchars($account[lim_one]);?>">
	    <td style="min-width:80px;"><input type="number" class="form-control" name="withdraw_int" min='1' value="<?=htmlspecialchars($account[withdraw_int]);?>">
	    <td style="min-width:80px;"><input type="number" class="form-control" name="amount_ref" min='0' value="<?=htmlspecialchars($account[amount_ref]);?>">
	    <td><input type="submit" value="Сохранить" class="btn btn-success"><br><br><div class="ajax<?=$account[id];?>">
	    </div></form>
<?}while($account=mysqli_fetch_assoc($result));?></table>

<?}?><? $sub_ques = "order=0";
	if($_GET['order'])$sub_ques = "order=".(int)$_GET['order'];
	if($_GET['sort'])$sub_ques = "sort=".(int)$_GET['sort'];
	if($_GET[p]!=0){?><a href="?p=0&<?=$sub_ques;?>">В начало</a><?}
?> 
<a href="?p=<?=$_GET[p]+1;?>&<?=$sub_ques?>">Следующая</a>


<?}else{?>

<form method=post><input type="submit" class="btn btn-warning" name="newsms" value="Выслать новый код"></form>
<br><br>
<form method=post><input type="text" name="code2" placeholder="СМС код" class="form-control">
<input type="submit" class="btn btn-success" value="Войти">
</form>

<?}?>

</div></div>
<br><br><br>
		<!-- footer -->
		<div class="footer">
			<!-- container -->
			<div class="container">
				<div class="footer-info">

					<!--div class="store-buttons">
<center>			<a href="javascript:alert('Приложение в разработке');" class="btn btn-appstore" target="_blank"><img src="images/btn-appstore.png" alt="App Store"></a>
						<a href="javascript:alert('Приложение в разработке');" class="btn btn-googleplay" target="_blank"><img src="images/btn-googleplay.png" alt="Google Play"></a></center>
					</div-->
				</div>
				<div class="copyright">
					<p> © <a href="http://ksri.info">ПАО "Конструктор Империй"</a></p>
				</div>
			</div>
			<!-- //container -->
		</div>
		<!-- //footer -->
		<script type="text/javascript">
									$(document).ready(function() {
										/*
										var defaults = {
								  			containerID: 'toTop', // fading element id
											containerHoverID: 'toTopHover', // fading element hover id
											scrollSpeed: 1200,
											easingType: 'linear' 
								 		};
										*/
										
										$().UItoTop({ easingType: 'easeOutQuart' });
										
									});
								</script>
									<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- content-Get-in-touch -->
	</body>
<?}?>
<script src="../js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () { <?= $jsScript ?> })
</script>
<!--script src="../js/dropdown.js"></script-->
<script>
    function exchange(data, acc_id, acc_black){
		//alert(data);
        data = JSON.parse(data);
        $('.ajax' + acc_id).html(data[0]);
        if(data[1] == 0){
           $('#black' + acc_id).html("");
        }else if(data[1] == 1){
            $('#black' + acc_id).html("<span class='label-xs label-danger'>В Черном Списке, попытка вывести на " + acc_black + "</span>");
        }
    };
</script> 
<style>
    .success_s{background-color: #aaf0aa;}
</style> 
    
</html>

<?}else{?>
	<div class="row">
	
	<div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
    <div class="page-header">
      <h1>Админпанель Бартеркоин</h1>
    </div>
	<div class="panel panel-default">
	<div class="panel-heading">Вход</div>
	<div class="panel-body">
	
	<form method="post"> 
	<div class="form-group"> <input id="phone1" type="text" name="phone" class="form-control" placeholder="Номер телефона"> </div>
	
	<div class="row"><div class="col-md-4"><div class="form-group"> <input type="number" name="pin" class="form-control" placeholder="КОД"> </div></div>
	    <div class="col-md-8" id="btn1">Забыли код? <a class="btn btn-info submit-button" onclick="if($(this).hasClass('disabled'))return false;$('#btn1 a').addClass('disabled');$('.ajax1').load('<?=$baseHref?>adm/ajaxreg.php?btn=1&phone='+encodeURI($('#phone1').val()),function(){$('#btn1 a').removeClass('disabled');});return false;">Выслать новый</a></div>
	</div>
	
	<div class="ajax1"></div>
	<?if($_POST[phone] | $_POST[pin]){?><div class="alert alert-danger">Введены неверные данные</div><?}?>
	<div id="html_element"></div>
	<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer> 
    </script><!--убрать коммент для рекапчи-->
	<button type="submit" id='send_butt' class="btn btn-success submit-button" disabled>Войти</button> </form>
	</div></div></div>
	</div>
	
<?
	exit; 
}
