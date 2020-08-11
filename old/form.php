<?
if($_POST[name]&$_POST[phone]){
if(mail('leadsholding@yandex.ru', "=?utf-8?B?".base64_encode('Заказ карты с сайта '.$_SERVER['SERVER_NAME'])."?=", "Имя: ".htmlspecialchars($_POST[name])."
Телефон: ".htmlspecialchars($_POST[phone])."
E-mail: ".htmlspecialchars($_POST[email])."


Информация об отправителе: ".htmlspecialchars(getenv("REMOTE_ADDR")).", ".htmlspecialchars(getenv("HTTP_USER_AGENT"))."", $headers))echo('<p style="color: #333;text-shadow: none;text-align: left;">Ваша заявка отправлена. Спасибо!</p>'); else echo('<p style="color: #333;text-shadow: none;text-align: left;">Произошла ошибка при отправке</p>');

$api_url = 'https://hrm.holding.bz/services/deals_import/';
$api_auth_key = 'BI26NdjtBx9aF1UefrCg6dJnlbd0NFyGDvGzA58';
$api_login = 'api';
$table_id=371;
$get_name=$_POST['name'];
$get_email=$_POST['email'];
$get_phone=$_POST[phone];
$get_user_id=1;

//$str=strpos($get_phone, "+");
//$get_phone = substr($get_phone, $str);

function send_command_server($server_url, $server_command)
{
    $data_string = http_build_query($server_command);

    $ch = curl_init($server_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $json = curl_exec($ch);
    $result = json_decode($json, true);

    curl_close($ch);

    if (count($result)) {
        return $result;
    } else {
        return $json;
    }
}

function auth($auth_key, $login) {
    global $api_url;
    $command_auth_request = array(
        "v" => "1.0",
        "login" => $login
    );
    $result_auth_request = send_command_server($api_url . 'auth_request.php', $command_auth_request);

    $command_auth_auth = array(
        "v" => "1.0",
        "login" => $login,
        "hash" => md5($result_auth_request["salt"] . $auth_key)
    );
    $result_auth_auth = send_command_server($api_url . 'auth_auth.php', $command_auth_auth);

    $access_id = $result_auth_auth["access_id"];
    $_SESSION['access_id'] = $access_id;

    return $access_id;
}

$access_id = auth($api_auth_key, $api_login);

//$get_phone = '+1111111111';
$get_name = 'BarterCoin-site';
//$get_email = 'ssfs@sdsd.ru';

$command_add =  array(
    "access_id" => $access_id,
    "table_id" => $table_id,
    "cals" => true,
    "data" => array("line" => array(
        "product" => "чат-бот",
        "ref" => "С лендинга (заказ карты)",
        "phone" =>$get_phone,
        "name" => $get_name,
        "email" =>$get_email,
        'user_id' => $get_user_id)
    )
);
$command_add= send_command_server($api_url . 'deal_create.php', $command_add);

}else{?><p color=red style="color:red;text-shadow: none;">Не заполнены обязательные поля</p><div class="form-group">
                                            <label for="inputText1">Имя*</label>
                                            <input type="text" class="form-control" name="name" id="inputText1" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail1">Номер телефона*</label>
                                            <input type="text" class="form-control" name="phone" id="inputEmail1" placeholder="" required>
                                        </div>
<div class="form-group">
                                            <label for="inputEmail1">E-mail</label>
                                            <input type="text" class="form-control" name="email" id="inputEmail1" placeholder="">
                                        </div>
                                       
                                        
                                        <button type="submit" class="btn btn-lg btn-dark  btn-success">Отправить</button><?}
?>