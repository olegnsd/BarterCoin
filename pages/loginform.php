
<div class="alert alert-info">Для доступа к разделу введите данные вашей карты <?=$notice?></div>
<?if($_POST['savenum']){?><div class="alert alert-danger">Карта не найдена</div><?}?>
<form method="post" id="savecard1">
    							<input autofocus="" type="text" class="form-control cardnum" placeholder="Номер карты" name="savenum"  onkeydown="setTimeout(function(){
$('#savecard1').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('#savecard1 [name=savenum]').val().charAt(0)==3)$('#savecard1').addClass('ae');
if($('#savecard1 [name=savenum]').val().charAt(0)==2)$('#savecard1').addClass('mi');
if($('#savecard1 [name=savenum]').val().charAt(0)==4)$('#savecard1').addClass('visa');
if($('#savecard1 [name=savenum]').val().charAt(0)==5)$('#savecard1').addClass('mc');
if($('#savecard1 [name=savenum]').val().charAt(0)==6)$('#savecard1').addClass('ma');
if($('#savecard1 [name=savenum]').val().charAt(0)==1)$('#savecard1').addClass('bc');
},1);" required=""><br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="Месяц" name="savemonth" required=""></div>
<div class="col-sm-2  col-xs-12 text-center" style="line-height: 34px;font-size: 20px;color: white;">/</div>
<div class="col-sm-5  col-xs-12"><input type="text" class="form-control cardnum" placeholder="Год" name="saveyear" required=""></div>
</div>

<br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="CVC" name="savecvc" required=""></div>
<div class="col-sm-7  col-xs-12"><input type="submit" class="btn btn-success btn-block" value="Войти"></div>
</div>
<p style="color:red;padding: 30px;display:none;">Вход возможен<br>только картам BarterCoin</p><script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('#savecard1 [name=savenum]').mask('9999 9999 9999 9999',{completed:function(){$('#savecard1 [name=savemonth]').focus();}});

$('#savecard1 [name=savemonth]').mask('99',{completed:function(){$('#savecard1 [name=saveyear]').focus();}});

$('#savecard1 [name=saveyear]').mask('99',{completed:function(){$('#savecard1 [name=savecvc]').focus();}});

$('#savecard1 [name=savecvc]').mask('999',{completed:function(){$('#savecard1 input[type=submit]').focus();}});

///$('[name=sum]').mask('000.000.000.000.000,00',{reverse: true,completed:function(){$('#submit123').focus();}});



});</script><style>
#savecard1{border: 2px dashed #dddfe0;    padding: 30px;
    border-radius: 14px;margin:0 auto;
    transition: .3s ease all;min-height: 276px;max-width:420px;}
#savecard1.ae{background-color: #007cc2;background-image:url(img/cards/ae.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.visa{background-color: #ffa336;background-image:url(img/cards/visa.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.mc{background-color: #971010;background-image:url(img/cards/mc.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.ma{background-color: #0079f0;background-image:url(img/cards/ma.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.mi{background-color: #4ca847;background-image:url(img/cards/mi.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.bc{background-color: #3d2b1f;background-image:url(img/cards/bc.png);background-position: 97% 97%;background-repeat:no-repeat;}

#savecard1.ae p{display:block !important;}
#savecard1.visa p{display:block !important;}
#savecard1.mc p{display:block !important;}
#savecard1.ma p{display:block !important;}
#savecard1.mi p{display:block !important;}
</style>

    						</form>
