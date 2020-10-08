<form action="/save_card" method="post" id="savecard">
	<div class="closeBtn" onclick="$('.clientLogin > form').toggleClass('clicked');">
		<i class="fa fa-close"></i>
	</div>
	<div class="h5">Введите данные вашей карты чтобы сохранить их</div>

	<? if (!empty($_SESSION['cardError'])): ?>
		<div class="alert alert-danger">Карта не найдена</div>
		<? unset($_SESSION['cardError']); ?>
	<? endif; ?>

	<input autofocus="" type="text" class="form-control cardnum" placeholder="Номер карты" name="savenum" required="">

	<br>
	<div class="row">
		<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="Месяц" name="savemonth" required=""></div>
		<div class="col-sm-2  col-xs-12 text-center" style="line-height: 34px;font-size: 20px;color: white;">/</div>
		<div class="col-sm-5  col-xs-12"><input type="text" class="form-control cardnum" placeholder="Год" name="saveyear" required=""></div>
	</div>

	<br>
	<div class="row">
		<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="CVC" name="savecvc" required=""></div>
		<div class="col-sm-7  col-xs-12"><input type="submit" style="line-height: 34px;width: 100%;padding: 0;" value="Сохранить"></div>
	</div>
</form>

<script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';

$('#savecard [name=savenum]').mask('9999 9999 9999 9999',{completed:function(){$('#savecard [name=savemonth]').focus();}});
$('#savecard [name=savemonth]').mask('99',{completed:function(){$('#savecard [name=saveyear]').focus();}});
$('#savecard [name=saveyear]').mask('99',{completed:function(){$('#savecard [name=savecvc]').focus();}});
$('#savecard [name=savecvc]').mask('999',{completed:function(){$('#savecard input[type=submit]').focus();}});

///$('[name=sum]').mask('000.000.000.000.000,00',{reverse: true,completed:function(){$('#submit123').focus();}});
});

</script>
