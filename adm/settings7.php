<?php

ini_set('display_errors', 0);

//require('../old/functions.php');

if($auth){
if($_POST['sum']){
	update_comiss();
}

$comissions = mysqli_query($mysqli, "SELECT * FROM comissions ORDER BY sum DESC");
    
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
		<a name="send_butt" href="/adm/?settings=7" class="btn btn-danger">Подтвердить</a>
      </div>
    </div>
  </div>
</div>
	
<!-- Table -->
<div class="col-sm-3 col-md-4 col-xs-1"></div>
<div class="col-sm-6 col-md-4 col-xs-12">
<div class='table-responsive'>
<table class="table table-bordered table-fixed">
	<caption class="bg-info">
		<h2 class="text-center">Управление комиссиями</h2>
	</caption>
	<tr>
		<div class="row">
			<th>Сумма на счету(BCR) более или равно(>=)</th>
			<th>Комиссия, %</th>
		</div>
	</tr>
	<form method="POST" id="form_sim" name="form_sim">
		<?
		foreach($comissions as $key1 => $sim){
		?>
			<tr id="add_ch<?=$key1?>" key1="<?=$key1?>">
				<div class="row">
					
					<td>
						<input class="form-control" type="text"  name="sum[]" style="//width: 55px;" value="<?=$sim['sum']?>" required form="form_sim">
						<input type="hidden" name="action[]" action="action" value="0">
						<input type="hidden" name="id[]" value="<?=$sim['id']?>">
					</td>

					<td>
						<input class="form-control" type="text" name="comission[]" value="<?=$sim['comission']?>" required>
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
<div class="col-sm-3 col-md-4 col-xs-1"></div>

<br><br>
</body>
<script type="text/javascript" src="../js/settings7.js"></script>
<?}
$jsScript = false;


