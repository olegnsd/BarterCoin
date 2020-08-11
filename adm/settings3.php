<?php
//ini_set('display_errors', 1);
if($auth){
        $alert='';
    if($_POST['refresh']){
        $task_id = mysqli_escape_string($mysqli,(int)$_POST['refresh']);
        $query = "SELECT * FROM `tasks_tasks_sms` WHERE `id`='$task_id'";
        $task=mysqli_query($mysqli, $query);
        $task=mysqli_fetch_assoc($task);
        
        $data=unserialize($task['data']);
        
        $tmp_card = $data['card'];
        if($tmp_card == 1){
            $tmp_card = "^1100.*";
        }elseif($tmp_card == 2){
            $tmp_card = "^1000.*";
        }else{
            $tmp_card = ".*"; 
        }
        
        $tmp_from = $data['from'];
        $tmp_to = $data['to'];
        
        $sql = "SELECT COUNT(a.id) FROM accounts AS a WHERE a.number REGEXP '$tmp_card' AND a.balance>='$tmp_from'  AND a.balance<='$tmp_to' AND a.activated='1' AND a.black='0' AND a.id <> ALL (SELECT user_id FROM task_$task_id WHERE status<>1)";
        
        $phones = mysqli_fetch_array(mysqli_query($mysqli, $sql));
        
        $last_phone_id = $phones['COUNT(a.id)'];//mysqli_insert_id($mysqli);
        $sql = "UPDATE `tasks_tasks_sms` SET `t_all`='$last_phone_id' WHERE `id`='$task_id'";
        mysqli_query($mysqli, $sql);
        
		header('Location:?settings=3&page='.(int)$_GET['page']);
		die();
	}
    if($_POST['deletesmsid']){
        $tmp_id = (int)$_POST['deletesmsid'];
		mysqli_query($mysqli, "DELETE FROM `tasks_tasks_sms` WHERE `id`=".$tmp_id);
        mysqli_query($mysqli, "DROP TABLE task_$tmp_id");
		//$sql = "DELETE FROM `tasks_tasks_sms_sent` WHERE `task`=".(int)$_POST['deletesmsid'].";";
		//$site_db->query($sql);
		header('Location:?settings=3&page='.(int)$_GET['page']);
		die();
	}
	if($_POST['togglesmsid']){
		$sql = "SELECT * FROM tasks_tasks_sms WHERE `id` = ".(int)$_POST['togglesmsid']."";
		
		$res0 = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
		if($res0['id']){
			$sql = "UPDATE `tasks_tasks_sms` SET `status` = '0' WHERE `id`=".(int)$_POST['togglesmsid'].";";
			if($res0['status']==0  || $res0['status']==3)$sql = "UPDATE `tasks_tasks_sms` SET `status` = '-1' WHERE `id`=".(int)$_POST['togglesmsid'].";";
			mysqli_query($mysqli, $sql);
			header('Location:?settings=3&page='.(int)$_GET['page']);
			die();
		}
	}
	if($_POST['sms']){
		$sql = "INSERT INTO `tasks_tasks_sms` (`sms`, `sim`, `data`, `user`, `next`, `status`) VALUES ('".stripslashes($_POST['sms'])."', '".stripslashes($_POST['segment']['sim'])."', '".serialize($_POST['segment'])."', '".$_COOKIE['name']."', '0', '-1');";
        
		mysqli_query($mysqli, $sql);
        $last_task_id = mysqli_insert_id($mysqli);
        
        $tmp_card = mysqli_escape_string($mysqli,$_POST['segment']['card']);
        if($tmp_card == 1){
            $tmp_card = "^1100.*";
        }elseif($tmp_card == 2){
            $tmp_card = "^1000.*";
        }else{
            $tmp_card = ".*"; 
        }
        $tmp_from = (int)mysqli_escape_string($mysqli,$_POST['segment']['from']);
        $tmp_to = (int)mysqli_escape_string($mysqli,$_POST['segment']['to']);
//        $tmp_sim = mysqli_escape_string($mysqli,$_POST['segment']['sim']);
        $sql = "SELECT COUNT(id) FROM `accounts` WHERE `number` REGEXP '$tmp_card' AND `balance`>='$tmp_from'  AND `balance`<='$tmp_to' AND `activated`='1' AND `black`='0'";
        //SELECT * FROM `accounts` WHERE `number` REGEXP '^1100.*' AND `balance` >= '0' AND `balance` <= '5' AND `activated` = '1' AND `black` = '0'
        $phones = mysqli_fetch_array(mysqli_query($mysqli, $sql));
        
            $sql = "CREATE TABLE task_". $last_task_id ." (
                `id` INT(11) AUTO_INCREMENT KEY,
                `user_id` INT(11),
                `phone` VARCHAR(11),
                `zone` INT(2) DEFAULT NULL,
                `status` INT(2) NOT NULL DEFAULT '0' COMMENT '-1-ошибка передачи, 0-в процессе, 1-не та зона, 2-выполнено'
                ) ENGINE MyISAM";
            mysqli_query($mysqli, $sql);
        
            $sql = "INSERT INTO task_$last_task_id (`user_id`, `phone`, `status`) VALUES ('-9', '10000000000', '2')";
            mysqli_query($mysqli, $sql); 

        $last_phone_id = $phones['COUNT(id)'];//mysqli_insert_id($mysqli);
        
            $sql = "UPDATE `tasks_tasks_sms` SET `t_all`='$last_phone_id' WHERE `id`='$last_task_id'";
            mysqli_query($mysqli, $sql);
	}  
    
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    СМС рассылка
                </div>

                <div class="panel-body">
                    <div id="result"><?=$alert?></div>
                </div>
                <form class="form-horizontal" method="POST" action="?settings=3">

                    <div class="form-group">
                        <label for="sms" class="col-md-2 control-label">Текст СМС</label>
                        <div class="col-md-10">
                            <textarea id="sms" type="text" class="form-control" name="sms" rows=3 required autofocus></textarea>
                            <span class="help-block">
                                 $CARDNUM-номер карты, $SURNAME-фамилия, $NAME-имя, $MIDDELNAME-отчество, $BALANCE-баланс, $CREDIT-кредитный лимит, $MONTHLIM-месячный лимит, $WITHDRAWLIM-дневной лимит, $CARDLINK-ссылка на карту
                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="segment_card" class="col-md-2 control-label">Карты</label>
                        <div class="col-md-10">
                            <div class="radio">
                              <label>
                                <input type="radio" name="segment[card]" id="segment_card" value="1" required>
                                Виртуальные
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="segment[card]" id="card2" value="2" required>
                                Реальные
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="segment[card]" id="card3" value="3" required>
                                Виртуальные и Реальные
                              </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="segment_from" class="col-md-2 control-label">Предел баланса</label>
                        <div class="col-md-10">
                            <div class="col-md-5">
                                <input id="segment_from" type="number" class="form-control" name="segment[from]" required autofocus value=0>
                            </div>
                            <div class="col-md-5">
                                <input id="segment_to" type="number" class="form-control" name="segment[to]" required autofocus value=5>
                            </div>
                            <span class="help-block">

                            </span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="segment_sim" class="col-md-2 control-label">Сим карта</label>
                        <div class="col-md-10">
                            <div class="radio">
                              <label>
                                <input type="radio" name="segment[sim]" id="segment_sim" value="1" required>
                                Системная
                              </label>
                            </div>
                            <div class="radio">
                              <label>
                                <input type="radio" name="segment[sim]" id="segment_sim" value="2" required>
                                Рекламная
                              </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="send_butt" class="col-md-2 control-label">
                            <!--div class="g-recaptcha" data-sitekey="6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB"></div-->
                            <div id="html_element"></div>
                        </label>
                        <div class="col-md-10">
                            <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary"> <!--disabled--><!--убрать коммент для рекапчи-->
                                Добавить смс рассылку
                            </button>
                        </div>
                    </div>
                </form>
            

<?
$_GET['page']=(int)$_GET['page'];
	if($_GET['page']<1)$_GET['page']=1;
	define('DEALS_PER_PAGE',15);
	$begin_pos = DEALS_PER_PAGE * ($_GET['page']-1);
	$limit = " LIMIT ".$begin_pos.",".DEALS_PER_PAGE;
    
    update_tasks($limit, $mysqli);

	$sql = "SELECT * FROM tasks_tasks_sms ORDER BY id DESC $limit";

	$res0 = (mysqli_query($mysqli, $sql));
	
	while($row0 = mysqli_fetch_assoc($res0)){
		$flag=1;
		// Заполнение элемента клиента
     
		$status='';
        if($row0['status']==0)$status='success';
		if($row0['status']==1)$status='success';
		if($row0['status']==-1)$status='danger';
		$data=unserialize($row0['data']);
		$query='';$segment='';$pause='';
		if($row0['status']==0){
			$pause=
			'<form method=post>
                <button type="submit" class="btn btn-default">Пауза</button>
				<input type="hidden" name="togglesmsid" value="'.$row0['id'].'" class="btn_cont">
			</form>';
		}
		if($row0['status']==-1){
			$pause=
			'<form method=post>
				<button type="submit" class="btn btn-success">Старт</button>
				<input type="hidden" name="togglesmsid" value="'.$row0['id'].'" class="btn_cont">
			</form>';
		}
        $sim_tmp = "";
        if($data['sim'] == 1)$sim_tmp = "системная";
        if($data['sim'] == 2)$sim_tmp = "рекламная";
        $card_tmp = "";
        if($data['card'] == 1)$card_tmp = "виртуальные";
        if($data['card'] == 2)$card_tmp = "реальные";
        if($data['card'] == 3)$card_tmp = "виртуальные и реальные";
        
        $segment.=" Карты: ".$card_tmp.";";
        $segment.=" Баланс: от ".$data['from']." до ".$data['to'].";";
        $segment.=" Сим: ".$sim_tmp.";";
		
		if(($row0['status']==1)){ // & ($col1['COUNT(*)']<$col['COUNT(*)']))
			$pause=
				'<form method=post>
                    <button type="submit" class="btn btn-warning">Возобновить</button>
					<input type="hidden" name="togglesmsid" value="'.$row0['id'].'" class="btn_cont">
				</form>';
		}
        if(($row0['status']==2)){ // & ($col1['COUNT(*)']<$col['COUNT(*)']))
			$pause='';
		}
        if($row0['status']==3){
            $task_id = htmlspecialchars($row0["id"]);
            $status_1 = mysqli_query($mysqli, "SELECT `status` FROM `task_$task_id` WHERE `status`='1'");
			$pause = "<div class='label label-info' role='alert'>".'Автопауза: ' . $status_1->num_rows . ' тел. не в зоне'. '</div><br><br>';
            $pause.=
			'<form method=post>
                <button type="submit" class="btn btn-default btn-xs">Пауза</button>
				<input type="hidden" name="togglesmsid" value="'.$row0['id'].'" class="btn_cont">
			</form>';
            
		}
        $next_tmp = $row0['next'];
		$sms_list.= 
		'<tr class='.$status.'>
			<td class="task_name"> '.htmlspecialchars($row0['sms']).'</td>
			<td>
			     '.$row0['user'].'	
			</td>
		    <td>'.$segment.'</td>
		    <td >
                <form method=post>
                    <button type="submit" title="Обновить" class="">'.$row0['t_all'].'</button>/'.$next_tmp.'
					<input type="hidden" name="refresh" value="'.$row0['id'].'" class="btn_cont">
				</form>
            </td>
		    <td>'.$pause.'</td>
			<td>
				<form method=post>
                    <button type="submit" class="btn btn-danger">Удалить</button>
					<input type="hidden" name="deletesmsid" value="'.$row0['id'].'" class="btn_cont">
				</form>
			</td>
		</tr>';
	}
	if(!$flag)$sms_list="<tr><td colspan=10 align=center style=\"padding:15px;\">Ничего не найдено";
	$pag='';
	if($_GET['page']>1){
		$pag.="<a href=\"?settings=3&page=".($_GET['page']-1)."\">Назад</a>&nbsp;&nbsp;";
	}
	$next=mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) FROM tasks_tasks_sms"));
	$begin_pos1 = DEALS_PER_PAGE * ($_GET['page']);
	if(($next["COUNT(*)"]-$begin_pos1)>0){
		$pag.="&nbsp;&nbsp;<a href=\"?settings=3&page=".($_GET['page']+1)."\">Вперёд</a>";
	}
	$sms_list.="<tr><td align=center colspan=10 style=\"padding:15px;\">".$pag;		

?>
                <div class='table-responsive'>
                    <table class="table  table-hover">
                        <thead>
                            <th>Текст СМС</th>
                            <th>Автор</th>
                            <th>Сегмент</th>
                            <th>
                                Статус
                                осталось/сделано
                            </th>
                            <th></th> <th></th>
                            <!--/tr-->
                        </thead>
                        <tbody id="tasks_list_body">
                            <?=$sms_list?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?}
//function clear_phone($person_phone){
    //$phone = preg_replace("/\D{1,}/", "", $person_phone);
    //return $phone;
//}

function update_tasks($limit, $mysqli){
    $sql = "SELECT * FROM tasks_tasks_sms $limit";// WHERE (status='2' OR status='1' OR status='3')
	$tasks = (mysqli_query($mysqli, $sql));
	
	while($task = mysqli_fetch_assoc($tasks)){
        
        $task_id = $task['id'];
        
        $data=unserialize($task['data']);
        
        $tmp_card = $data['card'];
        if($tmp_card == 1){
            $tmp_card = "^1100.*";
        }elseif($tmp_card == 2){
            $tmp_card = "^1000.*";
        }else{
            $tmp_card = ".*"; 
        }
        
        $tmp_from = $data['from'];
        $tmp_to = $data['to'];
        
        $sql = "SELECT COUNT(a.id) FROM accounts AS a WHERE a.number REGEXP '$tmp_card' AND a.balance>='$tmp_from'  AND a.balance<='$tmp_to' AND a.activated='1' AND a.black='0' AND a.id <> ALL (SELECT user_id FROM task_$task_id WHERE status<>1)";
        
        $phones = mysqli_fetch_array(mysqli_query($mysqli, $sql));
        
        $last_phone_id = $phones['COUNT(a.id)'];//mysqli_insert_id($mysqli);
        
        if($last_phone_id > 0){
            $status_b = "";
            
            if($task['status'] == 2)$status_b = ", status=1 ";
            $sql = "UPDATE tasks_tasks_sms SET t_all='$last_phone_id' $status_b WHERE id='$task_id'";
            
            mysqli_query($mysqli, $sql);
        }
    }
}
?>



