<? include('../inc/init.php');

$card_id=(int)$_GET['card'];
$res = mysqli_query($mysqli,"SELECT p.*, a.phone FROM per_room AS p, accounts AS a WHERE p.acc_id='".$card_id."' AND p.acc_id=a.id LIMIT 1;");
$test=mysqli_fetch_assoc($res);
sql_err($mysqli, 'per_room');

$myecho = $phone;
`echo "phone: "  $myecho >>/var/www/tmp/qaz`;
$myecho = clear_phone($test['phone']);
`echo " test[phone]): "  $myecho >>/var/www/tmp/qaz`;

$phone = clear_phone($test['phone']);
if(!$phone){
    $res = mysqli_query($mysqli,"SELECT a.id, a.phone FROM accounts AS a WHERE a.id='".$card_id."' LIMIT 1;");
    $test=mysqli_fetch_assoc($res);
    sql_err($mysqli, 'accounts');
    $phone = clear_phone($test['phone']);
    $phone_ins = 1;
}

if($phone){
    $pass=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    if($phone_ins == 1){
        mysqli_query($mysqli,'INSERT INTO `per_room` (acc_id, password) values ('.$test[id].', \''.password_hash($pass, PASSWORD_DEFAULT).'\');');
        sql_err($mysqli, 'INSERT per_room');
    }else{
        mysqli_query($mysqli,'UPDATE `per_room` SET `password` = \''.password_hash($pass, PASSWORD_DEFAULT).'\' WHERE `per_room`.`acc_id` = '.(int)$test[acc_id].';');
        sql_err($mysqli, 'UPDATE per_room');
    }
    
    if(sms($phone, "Код bartercoin: ".$pass)!='null'){
        ?>
        <div class="alert alert-success">Новый код отправлен на ваш телефон</div><script>$('#btn<?=(int)$_GET[btn];?>').html('<a class="btn disabled btn-block btn-info submit-button">&nbsp;</a>');</script>
    <?}else{?>
        <div class="alert alert-danger">Произошла ошибка при отправке СМС. Попробуйте ещё раз.</div>
<?}

}else{?>
	<div class="alert alert-danger">Аккаунт не найден</div>
<?}

