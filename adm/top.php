<div class="header-bg">
					
	<div class="header-top">
	<div class="container" style="position:relative;">
		<div class="head-logo">
			<a href="/" style="color: #31708f;">BarterCoin - Бартерная платежная система</a>
			<?if($auth){?>
			<div class="btn-group" role="group" aria-label="...">
				<a class="btn btn-info" href="/adm/" >Админка<br> главная</a>
				<a class="btn btn-info" href="/adm/?settings=5" >История<br> транзакций</a>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Автопроплата
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="/adm/?settings=8">Настройка оплаты</a></li>
						<li><a href="/adm/?settings=9">История</a></li>
					</ul>
				</div>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Настройки
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="/adm/?settings=11">Автопополнение из 7-го в 1-й</a></li>
						<li><a href="/adm/?settings=12">Автопополнение из 5-го в 7-й</a></li>
                        <li><a href="/adm/?settings=13">Автопополнение из 9-го в 8-й</a></li>

                        <li><a href="/adm/?settings=4">Настройки банкоматов</a></li>
						<li><a href="/adm/?settings=2">Настройки приглашений</a></li>
						<li><a href="/adm/?settings=3">Рассылка</a></li>
						<li><a href="/adm/?settings=6">Настройка звонков</a></li>
						<li><a href="/adm/?settings=7">Комиссии</a></li>
					</ul>
				</div>
			</div>                             
			<br>
			<span class="label label-info"><?=$_SESSION['name']?></span>
			<a href="adm?logout" type="button" class="btn-xs btn-primary">Выход</a>
			<?}?>
		</div>
<div class="top-nav" style="position: absolute;margin-top: 0;right: 0;top: -15px;display:none;">
									<a href="/activate">Активация карты</a>
<a href="/check">Проверка баланса</a>
<a href="/send">Перевод с карты на карту</a>
								</div>

								<div class="clearfix"> </div>
							</div>
						</div>
			
		</div>
		<!-- //header -->
