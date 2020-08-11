<?php
require('../inc/config.php');

$targets = htmlspecialchars($_GET['targets']);
$comment = htmlspecialchars($_GET['comment']);
$account = htmlspecialchars($_GET['account']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BarterCoin</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
	
<body>
	<div class="panel panel-default">
		<div class="panel-body">
			<form method="GET" target="_blank" action="<?=$baseHref?>/do">
				<input type="hidden" class="form-control" name="pay2" value="">
				<div class="form-group">
<!--					<p class="form-control-static text-muted">Назначение перевода</p>-->
					<h4><label class="control-label"><?=$comment?></label></h4>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1" class="text-muted">Сумма, BCR</label>
					<input type="number" class="form-control" id="exampleInputEmail1" name="sum">
				</div>
				<input type="hidden" class="form-control" name="card_form" value="<?=$account?>">
				<input type="hidden" class="form-control" name="comment" value="<?=$comment?>">
				<input type="hidden" class="form-control" name="targets" value="<?=$targets?>">
			  <button type="submit" class="btn btn-default">Перевести</button>
			</form>
		</div>
	</div>
</body>

