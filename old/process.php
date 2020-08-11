<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>BarterCoin - Бартерная платежная система</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/styles.css?v=1.6" rel="stylesheet">
<!-- js -->
<script src="js/jquery.min.js"></script><script src="js/jquery.maskedinput.min.js"></script>
<script src="js/scripts.js?v=1.7"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	/*jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
		
                $("#submit123").click(function() {
                        var data = new FormData();
                        data.append('card', $("[name='fromnum']").val().replace(/ /g, "").trim());
                        data.append('expire_date', "20" + $("[name='fromyear']").val() + "-" + $("[name='frommonth']").val());
                        data.append('cvv', $("[name='fromcvv']").val());
                        data.append('lastname', $("[name='lastname']").val());
                        data.append('firstname', $("[name='firstname']").val());
                        data.append('middlename', $("[name='middlename']").val());
                        data.append('phone', $("[name='phone']").val().replace(/\D+/g,""));

                        var XHR = window.XDomainRequest || window.XMLHttpRequest
                        var xhr = new XHR();

                        xhr.open('POST', "http://api.bartercoin.ru/api/v1/accounts/checkActivate", true);

                        // замена onreadystatechange
                        xhr.onload = function() {
                                data = JSON.parse(this.response)
                                if (data.success) {
					$("[name='request_id']").val(data.request_id);
					$('.sms').show(1000);
					$('html, body').animate({
					        scrollTop: $(".sms").offset().top
					}, 1000);
				}
                                else
                                        alert("Произошла ошибка: "+data.error);
                        }

                        xhr.send(data);
                        return false;
                });

                $("#submit1234").click(function() {
                        var data = new FormData();
                        data.append('card', $("[name='fromnum']").val().replace(/ /g, "").trim());
                        data.append('expire_date', "20" + $("[name='fromyear']").val() + "-" + $("[name='frommonth']").val());
                        data.append('cvv', $("[name='fromcvv']").val());
                        data.append('lastname', $("[name='lastname']").val());
                        data.append('firstname', $("[name='firstname']").val());
                        data.append('middlename', $("[name='middlename']").val());
                        data.append('phone', $("[name='phone']").val().replace(/\D+/g,""));
			data.append('request_id', $("[name='request_id']").val());
			data.append('sms', $("[name='sms']").val());

                        var XHR = window.XDomainRequest || window.XMLHttpRequest
                        var xhr = new XHR();

                        xhr.open('POST', "http://api.bartercoin.ru/api/v1/accounts/activate", true);

                        // замена onreadystatechange
                        xhr.onload = function() {
                                data = JSON.parse(this.response);
                                if (data.success) {
					alert("Карта активирована");
					$('.sms').hide(1000);
				}
                                else
                                        alert("Произошла ошибка: "+data.error);
                        }

                        xhr.send(data);
                        return false;
                });

	});*/
</script>
<!-- start-smoth-scrolling --><!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = '6KCmuYT9SRmKqHrhN';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
        + '//call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->
</head>
	<body class="cbp-spmenu-push">
		<!-- header -->
		<div class="header-bg">
					
							<div class="header-top">
							<div class="container" style="position:relative;">
								<div class="head-logo">
									<a href="/" style="color: #31708f;">BarterCoin - Бартерная платежная система</a>
								</div>


								<div class="clearfix"> </div>
							</div>
						</div>
			
		</div>
		<!-- //header -->
		<!-- banner-bottom -->
		<div  class="banner-bottom">
			<!-- container -->
			<div class="container"><!--div class="alert alert-danger">Система начинает работу 15 января 2017 года</div-->
													<h2 style="text-align:center;">Для оплаты укажите сведения о своей карте BarterCoin</h2>
			</div>
			<!-- //container -->
		</div>
		<!-- //banner-bottom --><script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('[name=fromnum]').mask('9999 9999 9999 9999',{completed:function(){$('[name=frommonth]').focus();}});

$('[name=frommonth]').mask('99',{completed:function(){$('[name=fromyear]').focus();}});

$('[name=fromyear]').mask('99',{completed:function(){$('[name=fromcvv]').focus();}});

$('[name=fromcvv]').mask('999',{completed:function(){$('#submit123').focus();}});


});</script> <style>
.card{border: 2px dashed #dddfe0;
    border-radius: 14px;margin:0 auto;
    transition: .3s ease all;height: 276px;width:420px;}
.card.ae{background-color: #007cc2;background-image:url(images/ae.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.visa{background-color: #ffa336;background-image:url(images/visa.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.mc{background-color: #971010;background-image:url(images/mc.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.ma{background-color: #0079f0;background-image:url(images/ma.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.mi{background-color: #4ca847;background-image:url(images/mi.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.bc{background-color: #3d2b1f;background-image:url(images/bc.png);background-position: 230px 210px;background-repeat:no-repeat;}

.from.ae p{display:block !important;}
.from.visa p{display:block !important;}
.from.mc p{display:block !important;}
.from.ma p{display:block !important;}
.from.mi p{display:block !important;}
</style>
		<div class="container">
<div class="col-md-5"><div class="card from"><div class="row">
<div class="col-xs-offset-1 col-xs-10 logo" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input autofocus type="text" onkeydown="setTimeout(function(){
$('.card.from').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=fromnum]').val().charAt(0)==3)$('.card.from').addClass('ae');
if($('[name=fromnum]').val().charAt(0)==2)$('.card.from').addClass('mi');
if($('[name=fromnum]').val().charAt(0)==4)$('.card.from').addClass('visa');
if($('[name=fromnum]').val().charAt(0)==5)$('.card.from').addClass('mc');
if($('[name=fromnum]').val().charAt(0)==6)$('.card.from').addClass('ma');
if($('[name=fromnum]').val().charAt(0)==1)$('.card.from').addClass('bc');
},1);" class="form-control cardnum" placeholder="Номер карты" name="fromnum"></div>
<div class="col-xs-offset-1 col-xs-10 form-inline"><input type="num" name="frommonth" class="form-control" style="width:90px;display: inline;" placeholder="Месяц"> / <input type="num" name="fromyear" class="form-control" style="width:90px;display: inline;" placeholder="Год"> <div style="float:right;">СVV: <input type="num" name="fromcvv" class="form-control" style="width:90px;" placeholder="CVV"></div></div>
<p style="color:red;padding: 30px;display:none;">Оплата только<br>с карт BarterCoin</p>
</div>
</div></div>
<div class="col-md-2"><i style="font-size: 30px;padding-top: 100px;text-align:center;display:block;" class="glyphicon glyphicon-chevron-right"></i></div>
<div class="col-md-5"><div class="to"><div class="row">
<div class="col-xs-offset-1 col-xs-10" style="height:20px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;">
<h2>Информация о заказе</h2>
<table border=0>
<tr><td style="font-weight:bold;" align=right>Магазин:&nbsp;<td>
<tr><td style="font-weight:bold;" align=right>Валюта:&nbsp;<td>BCR
<tr><td style="font-weight:bold;" align=right>Сумма:&nbsp;<td>100
<tr><td style="font-weight:bold;" align=right>Описание заказа:&nbsp;<td>
<tr><td style="font-weight:bold;" align=right>Номер заказа:&nbsp;<td>
</table>


</div>

</div>
</div></div><div class="clearfix"></div><div style="text-align:center;padding-top:20px;"><a href="javascript:void(0);" id="submit123" class="btn btn-success btn-lg">Оплатить <i class="glyphicon glyphicon-chevron-right"></i></a><!--button type="submit" id="submit123" class="btn btn-success btn-lg">Перевести валюту <i class="glyphicon glyphicon-chevron-right"></i></button-->
<div class="sms" style="display:none;"><br><br>
<input type="text" class="form-control" placeholder="Код из СМС" name="sms" style="width:200px;margin:0 auto;margin-bottom:15px;"><a href="#" id="submit1234" class="btn btn-success btn-lg">Подтвердить <i class="glyphicon glyphicon-chevron-right"></i></a><!--button type="submit" id="submit123" class="btn btn-success btn-lg">Перевести валюту <i class="glyphicon glyphicon-chevron-right"></i></button-->
</div>
</div><br><br><div class="alert alert-success status" style="display:none;"></div><!alert-success менять на alert-danger при ошибке -->
</div><br><br><br>

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
</html>
