<?php
ini_set('display_errors', 0);
require('../old/functions.php');
if($auth1){
	if($_POST['sum']){
		update_min_ball();
	}
    
    $balance = mysqli_query($mysqli, "SELECT * FROM balance ORDER BY sum ASC");
    
    $alert='';
    if(isset($_POST["delta_time"])){//сохранить изменения пополнения 1-го
        //$amount = htmlspecialchars($_POST["amount"]);
        //$amount_max = htmlspecialchars($_POST["amount_max"]);
        $delta_time = htmlspecialchars($_POST["delta_time"]);
        $token = htmlspecialchars($_POST["token"]);// донор
        $exp_token = htmlspecialchars($_POST["exp_token"]);
        $token_proxy = array();
        $token_proxy['token'] = mysqli_escape_string($mysqli, $_POST["token"]);
        $token_proxy['ip'] = mysqli_escape_string($mysqli, $_POST["ip"]);
        $token_proxy['port'] = mysqli_escape_string($mysqli, $_POST["port"]);
        $token_proxy['usr'] = mysqli_escape_string($mysqli, $_POST["usr"]);
        $token_proxy['pass'] = mysqli_escape_string($mysqli, $_POST["pass"]);
        $token_proxy = json_encode($token_proxy);
//        $token = $token_proxy['token'];
        $info=mysqli_query($mysqli,"UPDATE settings SET delta_time='$delta_time', token='$token_proxy', exp_token='$exp_token' WHERE title='add_br'");
        $alert = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $info=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='add_br'");
        $info=mysqli_fetch_assoc($info);
        //$amount = htmlspecialchars($info["amount"]);
        //$amount_max = htmlspecialchars($info["amount_max"]);
        $delta_time = htmlspecialchars($info["delta_time"]);
        //$token = htmlspecialchars($info["token"]);
        $exp_token = htmlspecialchars($info["exp_token"]);
        $token_proxy = json_decode($info["token"], true);
        $token = ($token_proxy["token"]);// донор
        $proxy_ip = ($token_proxy["ip"]);
        $proxy_port = ($token_proxy["port"]);
        $proxy_usr = ($token_proxy["usr"]);
        $proxy_pass = ($token_proxy["pass"]);
    }
    
    //проверка счета 7-го банкомата
    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token)
        ); 
        $out_count = curl_exec($curl); //my
        curl_close($curl);
    }
    $out_count = json_decode($out_count);
    $out_count = $out_count->accounts[0]->balance->amount;
    
    //проверка счета 5-го банкомата
    $out_count_5 = check_5($mysqli);
    
    $alert_7='';
    if(isset($_POST["amount_7"])){ //сохранить изменения пополнения 7-го с 5-го
        $amount_7 = (int)$_POST["amount_7"];
        $time_add = htmlspecialchars($_POST["time_add"]);
        $time_add_7 = json_encode(array("time_add" => $time_add));
        if($_POST['add_7']){
            $add_7 = 1;
        }else{
            $add_7 = 0;
        }
        
        $myecho = json_encode($amount." ".$time_add_7." ".$add_7);
        `echo "amount time_add add_7: "  $myecho >>/home/bartercoin/tmp/qaz_add_b`;
        
        $info=mysqli_query($mysqli,"UPDATE settings SET amount='$amount_7', delta_time='$add_7', token='$time_add_7' WHERE title='add_5_7'");
        $alert_7 = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $info=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='add_5_7'");
        $info=mysqli_fetch_assoc($info);
        $amount_7 = $info["amount"];
        $time_add = json_decode($info["token"], true);
        $time_add = $time_add["time_add"];
        $add_7 = $info["delta_time"];
    }
    
    $exp_day = intval((strtotime($exp_token) - time())/(60*60*24));
    $h_class = "alert-xs alert-success";
    
    if($exp_day < 2){
        $h_class = "alert-xs alert-danger";
        $exp_notice = "Обновите токен";
    }
    
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
<br>
<!-- Modal -->
<div class="modal" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Удаление мягкое(в конце необходимо сохранить)</h4>
      </div>
      <div class="modal-body">
        <label class="alert-link" id="del_info"></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <button type="button" id='del_butt' key1="" name="send_butt" class="btn btn-danger" >Подтвердить</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal" id="myModal_save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Сохранить все изменения</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Вернуться</button>
        <button type="button" id='send_butt' form="form_sim" class="btn btn-success" >Подтвердить</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal" id="myModal_diss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Отменить все изменения</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Вернуться</button>
		<a name="send_butt" href="/adm?settings=1" class="btn btn-danger">Подтвердить</a>
      </div>
    </div>
  </div>
</div>
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Настройки автопооплнения 1-го банкомата. <b><i>На счету донора: <?=$out_count?>  руб.</i></b>
                    </div>

                    <div class="panel-body">
                        <div id="result"><?=$alert?></div>
                        </div>
                        <form class="form-horizontal" method="POST" action="/adm/?settings=1">

<!--
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label for="amount" class="col-md-4 control-label">Пополнять руб.</label>
                                <div class="col-md-6">
                                    <input id="amount" type="number" min="1" class="form-control" name="amount" value="<?$amount?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('amount_max') ? ' has-error' : '' }}">
                                <label for="amount_max" class="col-md-4 control-label">Максимум в банкомате руб.</label>
                                <div class="col-md-6">
                                    <input id="amount_max" type="number" min="1" class="form-control" name="amount_max" value="<?$amount_max?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
-->

                            <div class="form-group{{ $errors->has('delta_time') ? ' has-error' : '' }}">
                                <label for="delta_time" class="col-md-4 control-label">Интервал пополнения мин.</label>
                                <div class="col-md-6">
                                    <input id="delta_time" type="number" min="1" class="form-control" name="delta_time" value="<?=$delta_time?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
                                <label for="token" class="col-md-4 control-label">Токен донора Qiwi</label>
                                <div class="col-md-6">
                                    <input id="token" type="text" class="form-control" name="token" value="<?=$token?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('exp_token') ? ' has-error' : '' }}">
                                <label for="exp_token" class="col-md-4 control-label">Срок токена</label>
                                <div class="col-md-6">
                                    <input name="exp_token" id="exp_token" type="date" class="form-control" value="<?=$exp_token?>" required autofocus>
                                        <span class="help-block">
                                            <strong class="<?=$h_class?>">
                                                Осталось дней <?=$exp_day?> <?=$exp_notice?>
                                            </strong>
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
        
<!--форма пополнения 7-го с 5-го    -->
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				Настройки попоплнения 7-го банкомата с 5-го. <b><i>На счету 5-го банкомата: <?=$out_count_5?>  руб.</i></b>
			</div>

			<div class="panel-body">
				<div id="result"><?=$alert_7?></div>
			</div>
			<form class="form-horizontal" method="POST" action="/adm/?settings=1">

				<div class="form-group{{ $errors->has('amount_7') ? ' has-error' : '' }}">
					<label for="amount_7" class="col-md-4 control-label">Пополнять руб.</label>
					<div class="col-md-6">
						<input id="amount_7" type="number" min="1" class="form-control" name="amount_7" value="<?=$amount_7?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
				</div>

				<div class="form-group{{ $errors->has('time_add') ? ' has-error' : '' }}">
					<label for="time_add" class="col-md-4 control-label">Время пополнения</label>
					<div class="col-md-6">
						<input id="time_add" type="time" class="form-control" name="time_add" value="<?=$time_add?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
				</div>
                
                <div class="form-group{{ $errors->has('add_7') ? ' has-error' : '' }}">
					<label for="add_7" class="col-md-4 control-label">Пополнять</label>
					<div class="col-md-6">
                        <? $check = "";
                        if($add_7)$check = "checked";?>
						<input id="add_7" type="checkbox" name="add_7" <?=$check?>>
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
 
<!-- Table -->
<div class="col-sm-2 col-md-3 col-xs-1"></div>
<div class="col-sm-8 col-md-6 col-xs-12">
<div class='table-responsive'>
<table class="table table-bordered table-fixed">
	<caption class="bg-info">
		<h3 class="text-center">Настройка минимальных балансов</h3>
	</caption>
	<tr>
		<div class="row">
			<th>Сумма на счету донора<br>(BCR) меньше(&lt;)</th>
			<th>Пополнять, руб</th>
			<th>Максимум в<br>банкомате, руб</th>
		</div>
	</tr>
	<form method="POST" id="form_sim" name="form_sim">
		<?
		foreach($balance as $key1 => $var){
		?>
			<tr id="add_ch<?=$key1?>" key1="<?=$key1?>">
				<div class="row">
					
					<td>
						<input class="form-control" type="text"  name="sum[]" style="//width: 55px;" value="<?=$var['sum']?>" required form="form_sim">
						<input type="hidden" name="action[]" action="action" value="0">
						<input type="hidden" name="id[]" value="<?=$var['id']?>">
					</td>

					<td>
						<input class="form-control" type="text" name="add_sum[]" value="<?=$var['add_sum']?>" required>
					</td>
					<td>
						<input class="form-control" type="text" name="max[]" value="<?=$var['max']?>" required>
					</td>
					<td>
						<button class="btn btn-danger btn-xs" type="button" name="del" del_key1="<?=$key1?>" data-toggle="modal" data-target="#myModal_del">Удалить</button>
					</td>
				</div>
			</tr>
		<?}
		?>
	</form>
	<tr id="add_row"></tr>
	<tr>
		<td colspan = "2">
			<div class="input-group">
				<button class="btn btn-success btn-xs" name="add" add_j="<?=$key1+1?>" add_key1="<?=!$key1?-1:$key1?>">Добавить строку</button>
			</div>
		</td>
	</tr>
	
</table>
</div>
<button class="btn btn-success" name="save" data-toggle="modal" data-target="#myModal_save">Сохранить</button>
<button class="btn btn-default" name="diss" data-toggle="modal" data-target="#myModal_diss">Отмена</button>
</div>
<div class="col-sm-2 col-md-3 col-xs-1"></div>
<br><br>
</body>
<script>
	$("button[name='add']").click(function(){
	var key1 = $(this).attr('add_key1');
	if(!key1)key1 = -1;
	key1 = parseInt(key1);
	key1++;
	$(this).attr('add_key1', key1);
	
	var content = `
				<td>
					<input class="form-control" type="text"  name="sum[${key1}]" style="//width: 55px;"  required form="form_sim">
					<input type="hidden" name="action[${key1}]" action="action" value="2" form="form_sim">
					<input type="hidden" name="id[${key1}]" value="0" form="form_sim">
				</td>
				<td>
					<input class="form-control" type="text" name="add_sum[${key1}]" form="form_sim" required>
				</td>
				<td>
					<input class="form-control" type="text" name="max[${key1}]" form="form_sim" required>
				</td>
				<td>
					<button class="btn btn-danger btn-xs" name="del" del_key1="${key1}" onclick="del_btn($(this));" data-toggle="modal" data-target="#myModal_del">Удалить</button>
				</td>
	`;
	
	$(`#add_row`).append(content);
	$(`#add_row`).after('<tr id="add_row1"></tr>');
	$(`#add_row`).attr('id', `add_ch${key1}`);
	$(`#add_row1`).attr('id', `add_row`);
	$("a[href='adm?update=1']").remove();

	}); 

	$("button[name='del']").click(function(){
		var key1 = $(this).attr('del_key1');
		var mark = $(`#add_ch${key1} :first-child :first-child`).val();
		var number = $(`#add_ch${key1} :nth-child(2) :first-child`).val();
		$('#del_info').html("Удаление предела: менее "+mark+" BCR");
		$('#del_butt').attr("key1", key1);
	});

	function del_btn(this_btn){
		var key1 = this_btn.attr('del_key1');
		var mark = $(`#add_ch${key1} :first-child :first-child`).val();
		var number = $(`#add_ch${key1} :nth-child(2) :first-child`).val();
		$('#del_info').html("Удаление предела: менее "+mark+" BCR");
		$('#del_butt').attr("key1", key1);
	};

	$('#del_butt').on('click', function () {
		var key1 = $(this).attr("key1");
		$('#myModal_del').modal('hide');
		$(`#add_ch${key1}`).css('display', 'none');//$(`#add_ch${key1}`).remove();
		$("a[href='adm?update=1']").remove();
		$(`#add_ch${key1} input[action='action']`).val('3');
	});

	$('#send_butt').on('click', function () {
		$('#myModal_save').modal('hide');
		$("#form_sim").submit();
	});

	$("table").find('input').change(function(){
		var key1 = $(this).parents("tr").attr('key1');

		if($(`#add_ch${key1} input[action='action']`).val() < 1){
			$(`#add_ch${key1} input[action='action']`).val('1');
		}
	});

</script>
<?
}?>
