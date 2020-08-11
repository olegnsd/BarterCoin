<?php
ini_set('display_errors', 0);
if($auth){
    $alert='';
	//выгрузка файла звука
	if(is_uploaded_file($_FILES["file_wav"]["tmp_name"])){
//            $myecho = json_encode($_FILES["Filedata"]["tmp_name"]);
//            `echo " tmp_name:    " >>/tmp/qaz`;
//            `echo "$myecho" >>/tmp/qaz`;

		$user_id = (int)($_POST["user_id"]);
		$file_parts = pathinfo($_FILES['file_wav']['name']);
		$tmp = mysqli_escape_string($mysqli, $_FILES['file_wav']['tmp_name']);
		// Расширение файла
		$extension = $file_parts['extension'];
		$size = mysqli_escape_string($mysqli, $_FILES["file_wav"]["size"]);
		$err = mysqli_escape_string($mysqli, $_FILES["file_wav"]["error"]);
		//расширение не wav
		if($extension != 'wav' || !(preg_match("(WAVE)", file_get_contents($tmp)))){
			$error['file'] = 'файл не wav';
//                exit;
		}//размер файла больше 10М
		if($size > 10485760){
			$error['file'] = 'размер файла больше 10М';
//                exit;
		}
		if($err != 0){
			$error['file'] = 'ошибка загрузки файла';
//                exit;
		}
		if(!$error){
			$file_name = mysqli_escape_string($mysqli, $_FILES["file_wav"]["name"]);
			$targetFolder = '/home/bartercoin/tmp/audio';//'/temp/audio';
			$targetPath = $targetFolder;//$_SERVER['DOCUMENT_ROOT'] . $targetFolder;
			$targetFile =  $targetPath. '/' . mysqli_escape_string($mysqli, $_FILES['file_wav']['name']);//rtrim($targetPath,'/')

			// Сохраняем api settings
			$sql = mysqli_query($mysqli, "SELECT user_id, file_name FROM tasks_user_api_calls");//." WHERE user_id='$user_id'";
			$row = mysqli_fetch_assoc($sql);
			if(!isset($row['user_id'])){
				$sql = "INSERT INTO tasks_user_api_calls 
					(user_id, file_name) 
					VALUES 
					('$user_id','$file_name')
					";
				mysqli_query($mysqli, $sql);  
			}else{
				unlink($targetPath . '/' . $row['file_name']);
				$sql = "UPDATE tasks_user_api_calls SET
					file_name = '$file_name'";
					//WHERE user_id='$user_id'";
				mysqli_query($mysqli, $sql);  
			}

			move_uploaded_file($tmp,$targetFile);			 

//            echo $targetFolder . '/' . $_FILES['Filedata']['name'];

		}else{
			$err_echo = implode(', ', $error);
			$alert2 = "<div class='alert alert-danger'>Ошибка: $err_echo</div>";
		}
	}
	else{
//           $myecho = "error";
//            `echo " error:    " >>/tmp/qaz`;
//            `echo "$myecho" >>/tmp/qaz`; 
//            $error_file = 'ошибка загрузки файла';
	}
    if(isset($_POST["mode"])){
        $user_id = (int)($_POST['user_id']);
		$mode = (int)($_POST['mode']);
        $api_key = mysqli_escape_string($mysqli, $_POST['api_key']);
        $timefrom = mysqli_escape_string($mysqli, $_POST['timefrom']);
        $timeto = mysqli_escape_string($mysqli, $_POST['timeto']);
        $prefix = mysqli_escape_string($mysqli, $_POST['prefix']);
        $prior = (int)($_POST['prior']);
        $caller = mysqli_escape_string($mysqli, $_POST['caller']);
        $sms_enable = (int)($_POST['sms_enable']);
        $sms_text = mysqli_escape_string($mysqli, $_POST['sms_text']);
		$sql = mysqli_query($mysqli, "SELECT file_name FROM tasks_user_api_calls");
		$file_name = mysqli_fetch_assoc($sql);
		$file_name = $file_name['file_name'];
        
        if(!$user_id)
		{
			$error['error'] = "Ошибка";
		}
		// Проверка на ошибки
        $error = false;
		if($api_key=='')
		{
			$error['api_key'] = "Ключ АПИ не задан";
		}
//        if($timefrom < '10:00')
//		{
//			$error['timefrom'] = 1;
//		}
        if($timefrom == '')
		{
			$error['timefrom'] = "Время обзвона не задано";
		}
//        if($timeto > '21:00')
//		{
//			$error['timeto'] = 1;
//		}
        if($timeto == '')
		{
			$error['timeto'] = "Время обзвона не задано";
		}
//        if($timefrom > $timeto)
//		{
//			$error['timefromto'] = 1;
//		}
		if(strlen($prefix) > 5)
		{
			$error['prefix'] = "Префикс телефона не правильный";
		}
        if(!preg_match('/^\d+\+$/', $prefix))
		{
			$error['prefix'] = "Префикс телефона не правильный";
		}
		if($prefix == ''){
            unset($error['prefix']);
        }
        if(strlen($caller) > 4)
		{
			$error['caller'] = "Канал не правильный";
		}
        if(preg_match('/\W+/', $caller))
		{
			$error['caller'] = "Канал не правильный";
		}
		if(strlen($caller) == '')
		{
			$error['caller'] = "Канал не задан";
		}
		if($sms_enable == 1 && $sms_text == '')
        {
            $error['sms_text'] = "Текст СМС не задан";
        }
        
        // Если ошибок не обнаружено - сохраняем изменения профиля
		if(!$error)
		{
            // Сохраняем api settings
            $sql = mysqli_query($mysqli, "SELECT user_id FROM tasks_user_api_calls");//." WHERE user_id='$user_id'";
			$row = mysqli_fetch_assoc($sql);
            if(!isset($row['user_id'])){
                 $sql = "INSERT INTO tasks_user_api_calls 
					(user_id,
					mode,
                    api_key,
					timefrom,
					timeto,
					prefix,
					prior,
                    caller,
					sms_enable,
					sms_text) 
                    VALUES 
                    ('$user_id',
					'$mode',
                    '$api_key', 
					'$timefrom',
					'$timeto',
					'$prefix',
					'$prior',
                    '$caller',
					'$sms_enable',
					'$sms_text'
					)";
                $site_db->query($sql);  
            }else{
                $sql = mysqli_query($mysqli, "UPDATE tasks_user_api_calls SET
					mode = '$mode',
					api_key = '$api_key', 
					timefrom = '$timefrom',
					timeto = '$timeto',
					caller = '$caller',
                    prefix = '$prefix',
                    prior = '$prior',
					sms_enable = '$sms_enable',
					sms_text = '$sms_text'"); 
					//WHERE user_id='$user_id'";
            }			 
			
//			if(!mysql_error() && $password_chenge && $current_user_id==$user_id)
//			{
//				$auth->set_cookie_user_hash($user_hash);
//			}
			
			$success = 1;
			$alert = "<div class='alert alert-success'>Изменения сохранены</div>";
        }else{
			$err_echo = implode(', ', $error);
			$alert = "<div class='alert alert-danger'>Ошибка: $err_echo</div>";
		}   
    }else{
        $set=mysqli_query($mysqli,"SELECT * FROM tasks_user_api_calls");
        $set=mysqli_fetch_assoc($set);
		$user_id = (int)($set['user_id']);
		$mode = (int)($set['mode']);
        $api_key = mysqli_escape_string($mysqli, $set['api_key']);
        $timefrom = mysqli_escape_string($mysqli, $set['timefrom']);
        $timeto = mysqli_escape_string($mysqli, $set['timeto']);
        $prefix = mysqli_escape_string($mysqli, $set['prefix']);
        $prior = (int)($set['prior']);
        $caller = mysqli_escape_string($mysqli, $set['caller']);
        $sms_enable = (int)($set['sms_enable']);
        $sms_text = mysqli_escape_string($mysqli, $set['sms_text']);
		$file_name = mysqli_escape_string($mysqli, $set['file_name']);
    }
	if($sms_enable == 1){
        $SMS_ENABLE1 = '';
        $SMS_ENABLE2 = 'selected';
    }
	if($prior == ''){
		$PRIOR_SELECTED = '0';
	}
	else{
	   $PRIOR_SELECTED = $prior; 
	}
    
    if($mode == 1){
        $mode1 = '';
        $mode2 = 'selected';
    }
    
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
<br>
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Настройки звонков при операциях перевода BCR.
                    </div>

                    <div class="panel-body">
                        <div id="result"><?=$alert?></div>
						<div id="result2"><?=$alert2?></div>
                        </div>
                        <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="/adm/?settings=6">
							<div class="form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
                                <label for="mode" class="col-md-4 control-label">Режим</label>
                                <div class="col-md-6">
									<select id="mode" name="mode" class="form-control">
										<option value="0" <?=$mode1?>>Откл
										<option value="1" <?=$mode2?>>Вкл
									</select>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
							
                            <div class="form-group{{ $errors->has('api_key') ? ' has-error' : '' }}">
                                <label for="api_key" class="col-md-4 control-label">Ключ АПИ</label>
                                <div class="col-md-6">
                                    <input id="api_key" type="text" class="form-control" name="api_key" value="<?=$api_key?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('timefrom') ? ' has-error' : '' }}">
                                <label for="timefrom" class="col-md-4 control-label">Временной диапазон обзвона</label>
                                <div class="col-md-6">
									<input type="time" id="timefrom" name="timefrom" class="form-control" value="<?=$timefrom?>" />
									<input type="time" id="timeto" name="timeto" class="form-control" value="<?=$timeto?>" />
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
                                <label for="prefix" class="col-md-4 control-label">Префикс телефона</label>
                                <div class="col-md-6">
									<input type="text" id="prefix" name="prefix" class="form-control" style="width:5em" placeholder="XX+" maxlength="5" value="<?=$prefix?>">
									<input type="text" class="form-control" style="width:12em" placeholder="7(XXX)XXXXXXX" disabled>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('prior') ? ' has-error' : '' }}">
                                <label for="prior" class="col-md-4 control-label">Приоритет обзвона</label>
                                <div class="col-md-6">
									<select id="prior" name="prior" class="form-control">
										<option value="-3">-3
										<option value="-2">-2
										<option value="-1">-1
										<option value="0">0
										<option value="1">1
										<option value="2">2
										<option value="3">3
									</select>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('caller') ? ' has-error' : '' }}">
                                <label for="caller" class="col-md-4 control-label">Канал</label>
                                <div class="col-md-6">
									<input type="text" id="caller" name="caller" class="form-control" style="width:5em" placeholder="XXGX" maxlength="4" value="<?=$caller?>">
                                        <span class="help-block">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>
							<div class="form-group{{ $errors->has('sms_enable') ? ' has-error' : '' }}">
                                <label for="sms_enable" class="col-md-4 control-label">Отправлять SMS</label>
                                <div class="col-md-6">
									<select id="sms_enable" name="sms_enable" class="form-control">
										<option value="0" <?=$SMS_ENABLE1?>>Нет
										<option value="1" <?=$SMS_ENABLE2?>>Да
									</select>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
							<div class="form-group{{ $errors->has('sms_text') ? ' has-error' : '' }}">
                                <label for="sms_text" class="col-md-4 control-label">Текст SMS</label>
                                <div class="col-md-6">
									<textarea id="sms_text" name="sms_text" class="form-control" placeholder="<?=$sms_text?>"><?=$sms_text?></textarea>
                                        <span class="help-block">
                                            <strong>
												$user1 - ФИО кто переводит<br>
												$sum1 - сумма перевода<br>
												$balance2 - баланс получателя, после перевода<br>
												$card2 - карта получателя<br>
											</strong>
                                        </span>
                                </div>
                            </div>
							<div class="form-group{{ $errors->has('file_wav') ? ' has-error' : '' }}">
                                <label for="file_wav" class="col-md-4 control-label">Звуковой файл</label>
                                <div class="col-md-6">
									<input id="file_wav" class="form-control" name="file_wav" type="file" multiple="false" /><small>Обязательно в формате WAV для астериска. </small><small>Загружен: <?=$file_name?> </small>
                                        <span class="help-block">
                                            <strong></strong>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="send_butt" class="col-md-6 control-label">
                                    <!--div class="g-recaptcha" data-sitekey="6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB"></div-->
                                    <div id="html_element"></div>
                                </label>
                                <div class="col-md-4">
                                    <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary"> <!--disabled--><!--убрать коммент для рекапчи-->
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
	</div>
	<script type="text/javascript">
		$('#prior>option[value $= <?=$PRIOR_SELECTED?>]').attr('selected', 'selected');
	</script>    
</body>
<?
}
function value_proc($value, $iconv=1, $allowable_tags)
{
	if($allowable_tags)
	{
		$value = trim(htmlspecialchars(strip_tags($value, "<h1><h2><h3><h4><h5><h6><strong><em><sup><sub><blockquote><div></pre><p><table><thead><th><tbody><tr><td>")));
	}
    else 
	{
		$value = trim(htmlspecialchars(strip_tags($value)));
	}
	
	if (!get_magic_quotes_gpc()) 
	{
		$value = addslashes($value);
	}
	
	if($iconv)
	{
		$value = iconv('utf-8//IGNORE', 'cp1251//IGNORE', $value);
	}
	 
	return $value;
}
?>
