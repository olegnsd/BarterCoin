<?php
ini_set('display_errors', 0);
//require('../old/functions.php');
if($auth){
    
    $myecho = json_encode($_POST);
    `echo " _POST_settings8: "  $myecho >>/tmp/qaz`;
    
	if($_POST['util_id_recip']){
		update_util();
	}

	$util = mysqli_query($mysqli, "SELECT * FROM util ORDER BY prior DESC");//ORDER BY prior DESC
	
    $alert='';
    if(isset($_POST["contragent"])){//сохранить изменения банкомата-донора
        $contragent = (int)($_POST["contragent"]);
        $info=mysqli_query($mysqli,"UPDATE settings SET amount='$contragent' WHERE title='util'");
        $alert = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $info=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='util'");
        $info=mysqli_fetch_assoc($info);
        $contragent = htmlspecialchars($info["amount"]);
    }
    $amount_d = get_bank($mysqli, $contragent);//$amount_d = file_get_contents('/home/bartercoin/tmp/bankbalance'.$contragent);
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
		<a name="send_butt" href="/adm?settings=8" class="btn btn-danger">Подтвердить</a>
      </div>
    </div>
  </div>
</div>
<div class="container">
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				Настройки донора <b>на счету: <?=$amount_d?> руб</b>
			</div>

			<div class="panel-body">
				<div id="result"><?=$alert?></div>
			</div>
			<form class="form-horizontal" method="POST" action="/adm/?settings=8">
				<div class="form-group{{ $errors->has('contragent') ? ' has-error' : '' }}">
					<label for="contragent" class="col-md-4 control-label">Банкомат-донор</label>
					<div class="col-md-6">
						<input id="contragent" type="text" min="1" class="form-control" name="contragent" value="<?=$contragent?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label for="send_butt" class="col-md-6 control-label">
						<div id="html_element"></div>
					</label>
					<div class="col-md-4">
						<button type="submit" id='send_butt' name="send_butt" class="btn btn-primary">
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
<div class="col-lg-10 col-lg-offset-1 col-sm-12 col-md-10 col-md-offset-1 col-xs-12">
<div class='table-responsive'>
<table class="table table-bordered table-fixed">
	<caption class="bg-info">
		<h3 class="text-center">Настройка автопроплаты</h3>
	</caption>
	<tr>
		<div class="row">
			<th>Название</th>
			<th>ID услуги<br>куда платить</th>
            <th>Идентификатор<br>провайдера киви</th>
			<th>Пополнять, руб</th>
            <th>Пополнять раз в, дней</th>
            <th>Время пополнения<br>(проверяет только часы)</th>
            <th>Приоритет</th>
            <th>Минимум донора,<br>при котором пополнять, руб</th>
            <th>Пополнять</th>
            <th>Последнее пополнение</th>
            <th>Запуск<br>крона</th>
		</div>
	</tr>
	<form method="POST" id="form_sim" name="form_sim">
		<?
		foreach($util as $key1 => $var){
            $time = date('H:i', strtotime($var['util_time']));
            $last_pay = date('d.m.Y H:i', strtotime($var['last_pay']));
		?>
			<tr id="add_ch<?=$key1?>" key1="<?=$key1?>">
				<div class="row">
					
					<td>
						<input class="form-control" type="text"  name="name[]" style="width: 255px;" value="<?=$var['name']?>" required form="form_sim">
						<input type="hidden" name="action[]" action="action" value="0">
						<input type="hidden" name="id[]" value="<?=$var['id']?>">
					</td>
					<td>
						<input class="form-control" type="text" name="util_id_recip[]" style="width: 125px;" value="<?=$var['util_id_recip']?>" required>
					</td>
                    <td>
						<input class="form-control" type="text" name="util_id_prov[]" style="width: 125px;" value="<?=$var['util_id_prov']?>" required>
					</td>
					<td>
						<input class="form-control" type="text" name="util_value[]" value="<?=$var['util_value']?>" required>
					</td>
                    <td>
						<input class="form-control" type="text" name="util_day[]" value="<?=$var['util_day']?>" required>
					</td>
                    <td>
						<input class="form-control" type="time" name="util_time[]" value="<?=$time?>" step="3600" required>
					</td>
                    <td>
						<input class="form-control" type="text" name="prior[]" value="<?=$var['prior']?>" required>
					</td>
					<td>
						<input class="form-control" type="text" name="min_fiat[]" value="<?=$var['min_fiat']?>" required>
					</td>
                    <td>
						<div class="checkbox">
							<label>
								<? $check = "";
								if($var['pay'])$check = "checked";?>
								<input  type="checkbox"  name="pay[<?=$key1?>]" <?=$check?>>
							</label>
						</div>
					</td>
                    <td>
						<input class="form-control" type="datetime" style="width: 140px;" value="<?=$last_pay?>" disabled>
					</td>
                    <td>
						<?=$var['num_launch']?>
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
					<input class="form-control" type="text"  name="name[${key1}]" style="width: 255px;"  required form="form_sim">
					<input type="hidden" name="action[${key1}]" action="action" value="2" form="form_sim">
					<input type="hidden" name="id[${key1}]" value="0" form="form_sim">
				</td>
				<td>
					<input class="form-control" type="text" name="util_id_recip[${key1}]" style="width: 125px;" form="form_sim" required>
				</td>
                <td>
					<input class="form-control" type="text" name="util_id_prov[${key1}]" style="width: 125px;" form="form_sim" required>
				</td>
				<td>
					<input class="form-control" type="text" name="util_value[${key1}]" form="form_sim" required>
				</td>
                <td>
					<input class="form-control" type="text" name="util_day[${key1}]" form="form_sim" required>
				</td>
                <td>
					<input class="form-control" type="time" name="util_time[${key1}]" form="form_sim" required>
				</td>
                <td>
					<input class="form-control" type="text" name="prior[${key1}]" form="form_sim" required>
				</td>
				<td>
					<input class="form-control" type="text" name="min_fiat[${key1}]" form="form_sim" required>
				</td>
                <td>
					<div class="checkbox">
						<label>
							<input  type="checkbox"  name="pay[${key1}]" form="form_sim">
						</label>
					</div>
				</td>
                <td></td>
                <td></td>
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
		$('#del_info').html("Удаление: "+mark);
		$('#del_butt').attr("key1", key1);
	});

	function del_btn(this_btn){
		var key1 = this_btn.attr('del_key1');
		var mark = $(`#add_ch${key1} :first-child :first-child`).val();
		var number = $(`#add_ch${key1} :nth-child(2) :first-child`).val();
		$('#del_info').html("Удаление: "+mark);
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
<style>
    @media only screen and (max-width : 1570px) {
        
        
    }
</style>
<?
    
}?>
