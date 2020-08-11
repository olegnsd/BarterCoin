</div>

<div class="homeArea animated fadeInUp" style="background:#eee">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-5">
    				<div class="homeContent" style="color:#333;">
    					<span class="topTxt" style="background: #eeeeee96;">шаг вперёд в сфере расчетных взаимоотношений</span>
    					<span class="h2 homeTitle" style="color:#333;background: #eeeeee96;font-size: 65px;">BarterCoin</span>
    					<p style="background: #eeeeee96;">Универсальная, многофункциональная расчетная система, дающая широкий спектр возможностей для физических и юридических лиц, сталкивающихся с дефицитом наличных денежных средств.</p>
    					<div class="homeBtn">
    						<a href="javascript:void(0);" onclick="$('.modal3').show(0);" class="btnOne Btn"><i class="fa fa-send"></i>Заказать карту</a>
    						<!--a href="<?=$baseHref;?>#more" class="btnTwo Btn">Узнать подробнее</a-->
    					</div>
    				</div>
    			</div>
    			<div class="col-md-7">
    				<div class="homeImgTable">
						<div class="homeImg">
							<img src="img/card.png" alt="">
						</div>
    				</div>
    			</div>
    		</div>
			<div class="clouds">
				<img src="img/card1.png" style="width:80px;" alt="" class="cloud1">
				<img src="img/card1.png" style="width:100px;margin-top: 20px;" alt="" class="cloud2">
				<img src="img/card2.png" style="width:100px;" alt="" class="cloud3">
				<img src="img/card1.png" style="width:95px;" alt="" class="cloud4">
				<img src="img/card1.png" style="width:90px;" alt="" class="cloud5">
			</div>
    	</div>
    </div><a name="more"></a>
<div style="background:#333;padding:60px 0;">
<div class="container">
<div class="row">
<div class="col-md-4 text-center" style="color:white;font-size:20px;"><?$result=mysqli_fetch_array(mysqli_query($mysqli,"SELECT COUNT(*) FROM accounts WHERE `activated`=1 and `black`=0;"));?><b style="font-size:40px;"><?echo(number_format($result['COUNT(*)'],0,',',' '));?></b><br>активированных карт</div>
<div class="col-md-4 text-center" style="color:white;font-size:20px;"><?$info2=mysqli_query($mysqli,"SELECT SUM(balance) FROM accounts WHERE balance>0  and  `activated`=1 and `black`=0");$info2=mysqli_fetch_assoc($info2);?><b style="font-size:40px;"><?echo(number_format($info2['SUM(balance)'],0,',',' '));?> БР</b><br>лежит на активированных картах</div>
<div class="col-md-4 text-center" style="color:white;font-size:20px;"><?$info=mysqli_query($mysqli,"SELECT SUM(lim) FROM accounts WHERE `activated`=1 and `black`=0");$info=mysqli_fetch_assoc($info);?><b style="font-size:40px;"><?echo(number_format($info['SUM(lim)'],0,',',' '));?> БР</b><br>сумма кредитных лимитов</div>
</div>
</div>
</div>
<div class="container">
