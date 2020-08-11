<?php
 
include('../old/config.php');

$phone=phone($_GET[phone]);
if($phone){
	if((substr($phone,0,1)==7) & strlen($phone)==11){
		$test=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `adminy` WHERE phone='".mysqli_escape_string($mysqli,$phone)."' LIMIT 1;"));
		if($test[phone]){
			$pass=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
			mysqli_query($mysqli,'UPDATE `adminy` SET `password` = \''.password_hash($pass, PASSWORD_DEFAULT).'\' WHERE `adminy`.`id` = '.(int)$test[id].';');
			if(sms($phone, "Код входа bartercoin: ".$pass)){
				?>
				<div class="alert alert-success">Новый код отправлен на ваш телефон</div><script>$('#btn<?=(int)$_GET[btn];?>').html('<a class="btn disabled btn-block btn-info submit-button">&nbsp;</a>');</script>
			<?}else{?>
				<div class="alert alert-danger">Произошла ошибка при отправке СМС. Попробуйте ещё раз.</div>
			<?}
		}else{?>
			<div class="alert alert-danger">Аккаунт акционера не найден</div>
		<?}
	}else{
		if(strlen($phone)==11){?>
			<div class="alert alert-danger">Разрешена регистрация только номерам из России</div>
		<?}else{?>
			<div class="alert alert-danger">Неверный формат номера</div>
		<?}
	}
}else{?>
	<div class="alert alert-danger">Не введён номер телефона</div>
<?}
?>
