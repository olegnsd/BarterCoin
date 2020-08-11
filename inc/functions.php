<?
function _mail($email, $title, $text)
{
    $headers = "From: " . $_SERVER['SERVER_NAME'] . " <robot@" . $_SERVER['SERVER_NAME'] . ">\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    mail($email, "=?utf-8?B?" . base64_encode($title) . "?=", $text, $headers);
}
////check phone in advertizement
function checkPhoneAdv($url,$phone)
{
    $postfields = array("phone" => $phone,'url'=>$url);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://fiat.holding.bz:8000/checkad");
    curl_setopt($curl, CURLOPT_POST, True);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);

    $data = curl_exec($curl);
    curl_close($curl);
    $_ = json_decode($data, true);

//    var_dump($phone);
    return $_['result'];
}


////SMS
function _smsapi_communicate($request, $cookie = NULL)
{
    $request['format'] = "json";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "http://apisys.goip.holding.bz/");
    curl_setopt($curl, CURLOPT_POST, True);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, True);
    if (!is_null($cookie)) {
        curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    }
    $data = curl_exec($curl);
    curl_close($curl);

//$myecho = json_decode($data);
//$myecho = $myecho->response->msg->err_code;
//`echo " _smsapi: "  $myecho >>/home/bartercoin/tmp/qaz`;

    if ($data === False) {
        return NULL;
    }
    $js = json_decode($data, $assoc = True);
    if (!isset($js['response'])) return NULL;
    $rs = &$js['response'];
    if (!isset($rs['msg'])) return NULL;
    $msg = &$rs['msg'];
    if (!isset($msg['err_code'])) return NULL;
    $ec = intval($msg['err_code']);
    if (!isset($rs['data'])) {
        $data = NULL;
    } else {
        $data = $rs['data'];
    }
    return array($ec, $data);
}

function sms($phone, $text)
{
    $email = "bartercoin";
    $password = "223mxzeq";
    $req = array(
        "method" => "push_msg",
        "api_v" => "1.1",
        "email" => $email,
        "password" => $password,
        "phone" => str_replace(array('+', ' ', '(', ')', '-'), '', $phone),
        "text" => $text);
//    if (!is_null($params)) {
//        $req = array_merge($req, $params);
//    }
    $resp = _smsapi_communicate($req);
    if (is_null($resp)) {
// Broken API request
        return NULL;
        return "";
    }
    $ec = $resp[0];
    if ($ec != 0) {
        return array($ec,);
        return "";
    }
    return $resp;
    if (!isset($resp[1]['n_raw_sms'])) {
        return NULL; // No such fields in response while expected
        return "";
    }
    $n_raw_sms = $resp[1]['n_raw_sms'];
    return array(0, $n_raw_sms);
    return "";
}

////SMS END


function pagination_main($table, $func, $template, $num, $url, $getnext, $query = '`id`')
{
    if ($template == '') $template = '%list%%pagination%';
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `" . mysqli_escape_string($mysqli, $table) . "` WHERE ($query) AND " . pagination_query($getnext) . " LIMIT " . (int)($num + 1) . ";");
    if (!$result | !mysqli_num_rows($result)) {
        $template = '<div class="alert alert-warning">Ничего не найдено</div>';
    }
    $k = 0;
    $list = '';
    while ($data = mysqli_fetch_assoc($result)) {
        if ($k < $num) {
            $list .= $func($data);
        }
        $k++;
        if ($k == ($num + 1)) $last = $data['id'];
    }
    $template = str_replace("%list%", $list, $template);
    $off = 1;
    if ($getnext == -1) $off = 2;
    $previd1 = mysqli_query($mysqli, "SELECT id FROM `" . mysqli_escape_string($mysqli, $table) . "` WHERE ($query) AND " . pagination_query($getnext, 1) . " LIMIT " . (int)$off . "," . (int)($num));
    if ($previd1) while ($previd2 = mysqli_fetch_assoc($previd1)) {
        $previd = $previd2;
    }
    $template = str_replace("%pagination%", pagination($url, $previd[id], $last, $getnext), $template);
    echo($template);
}


function pagination($url, $previd, $last, $getnext)
{

    if ($getnext == -1) {
        $showFirst = TRUE;
        $showPrevious = TRUE;
        $temp = $last;
        $last = $first;
        $first = $temp;
    } else {
        if ($previd > 0 & $getnext > 0) {
            $showFirst = TRUE;
            $showPrevious = TRUE;
        }
        if ($last) {
            $showNext = TRUE;
            $showLast = TRUE;
        }
    }
    $return = '<ul class="pager">
%list% 
</ul>';
    if ($showFirst) {
        $return1 = str_replace('%link%', $url, '<li><a href="%link%">Начало</a>');
    }
    if ($showPrevious) {
        $return1 .= str_replace('%link%', $url . $previd, '<li><a href="%link%">&larr; Предыдущая</a><li>&nbsp;&nbsp;&nbsp;');
    }
    if ($showNext) {
        $return1 .= str_replace('%link%', $url . $last, '<li>&nbsp;&nbsp;&nbsp;<li>    <a href="%link%">Следующая &rarr;</a>');
    }
    if ($showLast) {
        $return1 .= str_replace('%link%', $url . '-1', '<li><a href="%link%">Конец</a>');
    }
    return stripcslashes(str_replace('%list%', $return1, $return));
}

function pagination_query($getnext, $rev = FALSE)
{
    if (!$rev) {
        if ($getnext == -1) {
            return '`id` ORDER BY `id`';
        } else {
            if ($getnext > 0) return '`id`<=' . (int)$getnext . ' ORDER BY `id` DESC'; else return '`id` ORDER BY `id` DESC';
        }
    } else {
        if ($getnext == -1) {
            return '`id` ORDER BY `id`';
        } else {
            if ($getnext > 0) return '`id`>=' . (int)$getnext . ' ORDER BY `id`'; else return '`id` ORDER BY `id`';
        }
    }
}


function getcard($num, $month = 0, $year = 0, $cvc = 0, $activated = 1, $black = 0)
{
    global $mysqli;
    $card = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM accounts WHERE number='" . mysqli_escape_string($mysqli, str_replace(' ', '', $num)) . "' AND activated='" . (int)$activated . "' AND black='" . (int)$black . "'"));

    if (!$card['id']) return false;
    if ($cvc > 0) {
        if ($cvc != $card['cvc']) return false;
        if ($month != $card['expiremonth']) return false;
        if ($year != $card['expireyear']) return false;
    }
    return $card;
}

function getcardbyid($num)
{
    global $mysqli;
    $card = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM accounts WHERE id='" . (int)$num . "' AND activated='1'"));

    if (!$card['id']) return false;
    return $card;
}

function createsmscode($check, $number = '', $is_trust = 1)
{
    global $mysqli;
    if ($number != '') {
        $card = getcard($number);
    } else {
        $card = getcard($_COOKIE['card1'], $_COOKIE['card2'], $_COOKIE['card3'], $_COOKIE['card4']);
    }
    //проверка ип
    $ip_user = $_SERVER['HTTP_X_REAL_IP'];


    $ip_user = explode('.', $ip_user);
    $ip_user = $ip_user[0] . '.' . $ip_user[1];
    if (!filter_var($ip_user, FILTER_VALIDATE_IP)) $ip_user = $_SERVER["REMOTE_ADDR"];

    $ip_arr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT ip_trusted FROM accounts WHERE number='" . mysqli_escape_string($mysqli, $card['number']) . "'"));
    //создать альтер код
    $check2 = '';
    if ($is_trust) {
        $ip_arr = json_decode($ip_arr['ip_trusted'], true);
        foreach ($ip_arr as $ip) {
            $ip_temp = explode('.', $ip);

            $ip_temp = $ip_temp[0] . '.' . $ip_temp[1];

            if ($ip_temp == $ip_user) {
                $check2 = 'trust';
            } elseif ($ip == $ip_user) {
                $check2 = 'trust';
                break;
            }
            $msg = "$ip_user ; $ip_temp ;  $check2 \n";
            file_put_contents('/home/bartercoin/tmp//qaz.log', $msg, FILE_APPEND);
        }


        //<---проверить на попытку транзакции, пластиковую карту и стаж
        $count_trans = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT count(*) FROM transactions WHERE fromid='" . $card['id'] . "'"));
        $card_n = substr($card['number'], 0, 4);
        if (!$card['is_try_trans'] && ($count_trans['count(*)'] >= 20 || $card_n == '1000')) {
            $check2 = 'trust';
            mysqli_query($mysqli, "UPDATE accounts SET is_try_trans='1' WHERE id='" . $card['id'] . "'");
        }//проверить на попытку транзакции и стаж--->
    }
    if ($is_trust == 2) {
        $check2 = 'trust';
    }
    if ($check2 != 'trust') {
        $check2 = '' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);//my
    }
    $check1 = time() . rand(0, 9) . rand(0, 9) . rand(0, 9);
    mysqli_query($mysqli, "INSERT INTO `sms` (`code1`, `code2`, `date`, `chck`) VALUES ('" . mysqli_escape_string($mysqli, $check1) . "', '" . mysqli_escape_string($mysqli, $check2) . "', CURRENT_TIMESTAMP, '" . mysqli_escape_string($mysqli, $check) . "');");
    return array($check1, $check2);
}

function checksmscode($check1, $check2, $check)
{
    global $mysqli;//return true;
    $card = getcard($_COOKIE['card1'], $_COOKIE['card2'], $_COOKIE['card3'], $_COOKIE['card4']);
    if ($check1 == 0) return false;
    $sms = mysqli_query($mysqli, "SELECT * FROM sms WHERE code1='" . mysqli_escape_string($mysqli, $check1) . "'");
    $sms = mysqli_fetch_assoc($sms);
    mysqli_query($mysqli, "DELETE FROM sms WHERE code1='" . mysqli_escape_string($mysqli, $check1) . "'");
    if ($check2 === 0) return false;
    if ($sms['chck'] != $check) return false;
    if ($sms['code2'] == $check2) {
        //проверка ип
        $ip_user = $_SERVER['HTTP_X_REAL_IP'];
        $ip_arr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT ip_trusted FROM accounts WHERE number='" . mysqli_escape_string($mysqli, $card['number']) . "'"));
        sql_err($mysqli, 'SELECT ip_trusted');
        //обновить список ип
        if (!strpos($ip_arr['ip_trusted'], $ip_user) && $ip_user != null && $ip_user != '') {
            $ip_arr = json_decode($ip_arr['ip_trusted'], true);
            $ip_arr[] = $ip_user;
            $ip_arr = json_encode($ip_arr);
            mysqli_query($mysqli, "UPDATE accounts SET ip_trusted='$ip_arr' WHERE number='" . mysqli_escape_string($mysqli, $card['number']) . "'");
            sql_err($mysqli, 'UPDATE accounts SET ip_trusted');
        }

        return true;
    }
    return false;
}

function transaction($card1, $card2, $sum, $comment = '', $iswithdraw = false, $comission = '1.0', $mincomission = '0', $b = 0)
{
    global $mysqli;
    if ($comment == '') $comment = "Перевод на карту " . $card2[number];
    $out = round((float)$sum * $comission, 0);
    $in = round((float)$sum, 2);
    if (($sum * ($comission - 1)) < $mincomission) $out = round($in + $mincomission, 0);


    $balance1 = (float)$card1[balance] - $out;
    $balance2 = (float)$card2[balance] + $in;
    if ($card1['number'] == $card2['number']) {
        $balance1 = (float)$card1['balance'];
        $balance2 = (float)$card2['balance'];
    }

    mysqli_query($mysqli, "UPDATE `accounts` SET `balance`='" . str_replace(',', '.', $balance1) . "' WHERE `accounts`.`id` = " . (int)$card1[id] . ";");
    sql_err($mysqli, 'UPDATE accounts');
    mysqli_query($mysqli, "UPDATE `accounts` SET `balance`='" . str_replace(',', '.', $balance2) . "' WHERE `accounts`.`id` = " . (int)$card2[id] . ";");
    sql_err($mysqli, 'UPDATE accounts');
    mysqli_query($mysqli, "INSERT INTO `transactions` (`id`, `fromid`, `toid`, `sum`, `timestamp`, `comment`,`iswithdraw`, `bankomat`) VALUES (NULL, '" . (int)$card1[id] . "', '" . (int)$card2[id] . "', '" . str_replace(',', '.', (float)$in) . "', CURRENT_TIMESTAMP, '" . mysqli_escape_string($mysqli, $comment) . "', '" . (int)$iswithdraw . "', '" . (int)$b . "');");
    sql_err($mysqli, 'INSERT transactions');

    $card0 = mysqli_query($mysqli, "SELECT * FROM accounts WHERE id=-1");
    $card0 = mysqli_fetch_assoc($card0);
    $balance3 = $card0[balance] + ($out - $in);
    mysqli_query($mysqli, "UPDATE `accounts` SET `balance`='" . str_replace(',', '.', $balance3) . "' WHERE `accounts`.`id` =-1;");
    sql_err($mysqli, 'UPDATE accounts');
    mysqli_query($mysqli, "INSERT INTO `transactions` (`id`, `fromid`, `toid`, `sum`, `timestamp`, `comment`) VALUES (NULL, '" . (int)$card1[id] . "', '" . (int)$card0[id] . "', '" . str_replace(',', '.', (float)($out - $in)) . "', CURRENT_TIMESTAMP, 'Комиссия за перевод на карту " . mysqli_escape_string($mysqli, $card2[number]) . "');");
    sql_err($mysqli, 'INSERT transactions');


    sms($card1[phone], 'Karta *' . substr($card1[number], -4) . '; Spisanie; Uspeshno; Summa: ' . number_format($out, 2, ',', ' ') . ' BCR (RUB); Ostatok ' . number_format($balance1, 2, ',', ' ') . ' BCR (RUB); ' . date('d.m.Y H:i:s') . '; Limit: ' . number_format($card1[lim], 2, ',', ' '));
    sms($card2[phone], 'Karta *' . substr($card2[number], -4) . '; Popolnenie; Uspeshno; Summa: ' . number_format($in, 2, ',', ' ') . ' BCR (RUB); ' . mb_strtoupper(trim($card1[name1] . ' ' . $card1[name2] . ' ' . $card1[name3]), 'utf-8') . '; Ostatok ' . number_format($balance2, 2, ',', ' ') . ' BCR (RUB); ' . date('d.m.Y H:i:s') . '; Limit: ' . number_format($card2[lim], 2, ',', ' '));
    return true;
}

function clear_phone($person_phone)
{
    $phone = preg_replace("/\D{1,}/", "", $person_phone);
    return $phone;
}

function luhn_test($num)
{
    $str = '';
    foreach (array_reverse(str_split($num)) as $i => $c) $str .= ($i % 2 ? $c * 2 : $c);
    return array_sum(str_split($str)) % 10 == 0;
}

function luhn_create($num)
{
    $str = '';
    $str_arr = array_reverse(str_split($num));
    foreach ($str_arr as $i => $c) $str .= ($i % 2 ? $c * 2 : $c);
    $res = array_sum(str_split($str)) * 9;
    $latest = $res % 10;
    $str_tmp = $str_arr[0] + $latest;
    if ($str_tmp >= 10) {
        $str_tmp = $str_arr[0] - (10 - $latest);
    }
    $str_arr[0] = $str_tmp < 0 ? $str_arr[0] : $str_tmp;
    $num = implode(array_reverse($str_arr));
    return $num;
}

function add_card($target, $system, $card1, $cod_vs_mc = '')
{
    global $mysqli;
    $target = mysqli_escape_string($mysqli, $target);
    //$target = clear_phone($target);
    $system = mysqli_escape_string($mysqli, $system);
    $card1 = mysqli_escape_string($mysqli, $card1);

    if ($system == 'qiwi') $system_base = 'qiwi';
    if ($system == 'ya') $system_base = 'yandex';
    if ($system == 'visa_mastercard') $system_base = 'visa_mastercard';
    if ($system == 'webmoney') $system_base = 'webmoney';
    if ($system == 'payeer') $system_base = 'payeer';


    $cod_vs_mc_b = '';
    if ($cod_vs_mc != '') $cod_vs_mc_b = ", cod_vs_mc='$cod_vs_mc'";

    mysqli_query($mysqli, "UPDATE accounts SET " . $system_base . " = " . $target . " $cod_vs_mc_b WHERE id = " . (int)$card1);

    //mysqli_query($mysqli,"UPDATE accounts SET ". $system_base ." = " .$target. " WHERE id = ".(int)$card1);
}

function recipient($target, $system, $card1, $card_number)
{
    global $mysqli;
    $target = mysqli_escape_string($mysqli, $target);
    //$target = clear_phone($target);
    $system = mysqli_escape_string($mysqli, $system);
    $card1 = mysqli_escape_string($mysqli, $card1);
    $card_number = mysqli_escape_string($mysqli, $card_number);

    if ($system == 'qiwi') {
        $system_base = 'qiwi';

    }
    if ($system == 'ya') $system_base = 'yandex';
    if ($system == 'visa_mastercard') $system_base = 'visa_mastercard';
    if ($system == 'webmoney') $system_base = 'webmoney';

    $string = "SELECT id FROM accounts WHERE " . $system_base . " = '$target'";

    if (substr($card_number, 0, 4) == '1000') {
        return true;
    }

    $tmp_card = "^1100.*";
    $id_donor = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT id FROM accounts WHERE " . $system_base . " = '" . $target . "' AND number REGEXP '$tmp_card' limit 1"));

    if ($id_donor['id'] == $card1) {
        return true;
    } elseif (!$id_donor['id']) {
        return true;
    } else {
        mysqli_query($mysqli, "UPDATE accounts SET black = 1, black_wallet='$target' WHERE id = '$card1'");
        return false;
    }
}

function recipient_oldest($target, $system, $card1)
{
    global $mysqli;
    $target = mysqli_escape_string($mysqli, $target);
    //$target = clear_phone($target);
    $system = mysqli_escape_string($mysqli, $system);
    $card1 = $card1;

    if ($system == 'qiwi') {
        $system_base = 'qiwi';
    }
    if ($system == 'ya') $system_base = 'yandex';
    if ($system == 'visa_mastercard') $system_base = 'visa_mastercard';
    if ($system == 'webmoney') $system_base = 'webmoney';

    $string = "SELECT " . $system_base . " FROM accounts WHERE " . $system_base . " = '" . $target . "' limit 1";

    $id_donor = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT " . $system_base . " FROM accounts WHERE " . $system_base . " = '" . $target . "' limit 1"));

    if ($id_donor["$system_base"] == $card1["$system_base"]) {
        return true;
    } else {
        return false;
    }
}

function phone_utc($user_phone)
{
    global $mysqli;
    $phone = $user_phone;
    $phone = preg_replace("/^[8]/", '+7', $phone);
    $phone = preg_replace("/[^0-9]/", '', $phone);
    $phone = substr($phone, 0, 11);//echo($phone.'<hr>');

    $ph_cod = substr($phone, 1, 3);
    $ph_numb = substr($phone, 4, 7);

    $sql = "SELECT `zone` FROM `time_zone` WHERE `phone_cod`='$ph_cod' AND `phone_from`<'$ph_numb' AND `phone_to`>'$ph_numb' LIMIT 1";
    $zone = mysqli_query($mysqli, $sql);
    $zone = mysqli_fetch_array($zone);
    $zone = $zone['zone'];

    return $zone;
}

function info_ip($ip_reg)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://ru.sxgeo.city/json/' . $ip_reg);//32b748942f69e9e841dc812be6b1e578
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $out = curl_exec($curl);

    $myecho = json_encode($ip_reg);
    `echo " ip_reg: "  $myecho >>/home/bartercoin/tmp/qaz`;
    $myecho = json_encode($out);
    `echo " info_ip: "  $myecho >>/home/bartercoin/tmp/qaz`;
    $myecho = json_encode(curl_error($curl));
    `echo " info_ip_err: "  $myecho >>/home/bartercoin/tmp/qaz`;

    $out = json_decode($out, true);

    $out_fix = array('city' => $out['city']['name_ru'],
        'region' => array('name_ru' => $out['region']['name_ru'], 'timezone' => $out['region']['timezone'], 'utc' => $out['region']['utc']),
        'country' => array('name_ru' => $out['country']['name_ru'], 'timezone' => $out['country']['timezone'], 'utc' => $out['country']['utc'])
    );
    $info_ip = json_encode($out_fix, JSON_UNESCAPED_UNICODE);

    curl_close($curl);

    return $info_ip;
}

function upload_add($files, $card, $docs_add)
{
    global $mysqli;

    $myecho = json_encode($_FILES["add_0"]["tmp_name"]);
    `echo " files[add_0][tmp_name]: "  $myecho >>/tmp/qaz`;

    // Если upload файла
    $succ = false;
    foreach ($docs_add['got'] as $key => $got) {
        if (isset($files["add_" . $key]) && $files["add_" . $key]["name"] != "" && $got == 1) {
            $myfile = $files["add_" . $key]["tmp_name"];
            $myfile_name = $files["add_" . $key]["name"];
            $myfile_size = $files["add_" . $key]["size"];
            $myfile_type = $files["add_" . $key]["type"];
            $error_flag = $files["add_" . $key]["error"];

            $myecho = json_encode($myfile_name);
            `echo " myfile_name: "  $myecho >>/tmp/qaz`;
            $myecho = json_encode($myfile);
            `echo " tmp_name: "  $myecho >>/tmp/qaz`;

            // Если ошибок не было 
            if ($error_flag == 0) {
                // если размер файла больше 512 Кб
                if ($myfile_size > 6144 * 1024) {
                    return "<div class='alert alert-danger'>Размер файла больше 6 мб! Уменьшите файл и повторите попытку</div>";
                }

                $im = imagecreatefromstring(file_get_contents($myfile));

                $path_save = 'add' . $card['id'] . '_' . $key;//'/home/bartercoin/tmp/passport/add'. $card['id'] . '_'. $key . '.jpeg';
                //$im_cr = imagejpeg($im, $path_save, 20);

                ob_start();
                imagejpeg($im, $path_save3, 20);
                $imgData = ob_get_clean();
                imagedestroy($im);

                //сохранить картинку в бд
                $im_cr = store_img(base64_encode($imgData), $path_save);

                $myecho = $path_save;
                `echo " (path_save): "  $myecho >>/tmp/qaz`;
                $myecho = json_encode(file_exists($path_save));
                `echo " file_exists(path_save): "  $myecho >>/tmp/qaz`;

                if (!$im_cr) {
                    return "<div class='alert alert-danger'>Ошибка загрузки. Возможные причины: Не правильный тип файла</div>";
                }
                $succ = true;
                $docs_add['got'][$key] = 2;

            } else {
                return "<div class='alert alert-danger'>Ошибка загрузки. Возможные причины: Сбой</div>";
            }
        }
    }
    if ($succ) {
        $user_id = $card['id'];
        $data = json_encode($docs_add, JSON_UNESCAPED_UNICODE);

        mysqli_query($mysqli, "UPDATE accounts SET data='$data' WHERE id = '$user_id'");

        return "<div class='alert alert-success'>Ваши данные приняты к рассмотрению</div>";
    }
    return "<div class='alert alert-danger'>Ошибка загрузки. Возможные причины: Файлы не загружены</div>";
}

function store_img($imgData, $path_save)
{
    global $mysqli;

    $sql = sprintf("INSERT INTO image
        (image, image_name)
        VALUES
        ('%s', '%s')",

        $imgData,
        $path_save
    );
    $res = mysqli_query($mysqli, $sql);

    if ($res) {
        return true;
    } else {
        return false;
    }

}


function get_in_translate_to_en($string, $gost = false)
{
    if ($gost) {
        $replace = array("А" => "A", "а" => "a", "Б" => "B", "б" => "b", "В" => "V", "в" => "v", "Г" => "G", "г" => "g", "Д" => "D", "д" => "d",
            "Е" => "E", "е" => "e", "Ё" => "E", "ё" => "e", "Ж" => "Zh", "ж" => "zh", "З" => "Z", "з" => "z", "И" => "I", "и" => "i",
            "Й" => "I", "й" => "i", "К" => "K", "к" => "k", "Л" => "L", "л" => "l", "М" => "M", "м" => "m", "Н" => "N", "н" => "n", "О" => "O", "о" => "o",
            "П" => "P", "п" => "p", "Р" => "R", "р" => "r", "С" => "S", "с" => "s", "Т" => "T", "т" => "t", "У" => "U", "у" => "u", "Ф" => "F", "ф" => "f",
            "Х" => "Kh", "х" => "kh", "Ц" => "Tc", "ц" => "tc", "Ч" => "Ch", "ч" => "ch", "Ш" => "Sh", "ш" => "sh", "Щ" => "Shch", "щ" => "shch",
            "Ы" => "Y", "ы" => "y", "Э" => "E", "э" => "e", "Ю" => "Iu", "ю" => "iu", "Я" => "Ia", "я" => "ia", "ъ" => "", "ь" => "");
    } else {
        $arStrES = array("ае", "уе", "ое", "ые", "ие", "эе", "яе", "юе", "ёе", "ее", "ье", "ъе", "ый", "ий");
        $arStrOS = array("аё", "уё", "оё", "ыё", "иё", "эё", "яё", "юё", "ёё", "её", "ьё", "ъё", "ый", "ий");
        $arStrRS = array("а$", "у$", "о$", "ы$", "и$", "э$", "я$", "ю$", "ё$", "е$", "ь$", "ъ$", "@", "@");

        $replace = array("А" => "A", "а" => "a", "Б" => "B", "б" => "b", "В" => "V", "в" => "v", "Г" => "G", "г" => "g", "Д" => "D", "д" => "d",
            "Е" => "Ye", "е" => "e", "Ё" => "Ye", "ё" => "e", "Ж" => "Zh", "ж" => "zh", "З" => "Z", "з" => "z", "И" => "I", "и" => "i",
            "Й" => "Y", "й" => "y", "К" => "K", "к" => "k", "Л" => "L", "л" => "l", "М" => "M", "м" => "m", "Н" => "N", "н" => "n",
            "О" => "O", "о" => "o", "П" => "P", "п" => "p", "Р" => "R", "р" => "r", "С" => "S", "с" => "s", "Т" => "T", "т" => "t",
            "У" => "U", "у" => "u", "Ф" => "F", "ф" => "f", "Х" => "Kh", "х" => "kh", "Ц" => "Ts", "ц" => "ts", "Ч" => "Ch", "ч" => "ch",
            "Ш" => "Sh", "ш" => "sh", "Щ" => "Shch", "щ" => "shch", "Ъ" => "", "ъ" => "", "Ы" => "Y", "ы" => "y", "Ь" => "", "ь" => "",
            "Э" => "E", "э" => "e", "Ю" => "Yu", "ю" => "yu", "Я" => "Ya", "я" => "ya", "@" => "y", "$" => "ye");

        $string = str_replace($arStrES, $arStrRS, $string);
        $string = str_replace($arStrOS, $arStrRS, $string);
    }

    return iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
}

function pagination_payment($mysqli, $query1, $num, $card, $account, $table)
{

    // Определяем общее число сообщений в базе данных
    $posts = mysqli_fetch_array(mysqli_query($mysqli, "SELECT MAX(id) FROM util_log"));
    // Находим общее число страниц
    $total = intval(($posts['MAX(id)'] - 1) / $num) + 1;
    // Извлекаем из URL текущую страницу
    $page = $_GET['pg'];
    $page = intval($page);
    // Если значение $page меньше единицы или отрицательно
    // переходим на первую страницу
    // А если слишком большое, то переходим на последнюю
    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;
    // Вычисляем начиная к какого номера
    // следует выводить сообщения
    $start = $page * $num - $num;
    // Выбираем $num сообщений начиная с номера $start
    $room_id = (int)$account['id'];
    $card_rel = (int)$account['acc_id'];

    $result = mysqli_query($mysqli, "SELECT c.* FROM $table AS c WHERE c.room_id=" . $room_id . " AND c.card_rel=" . $card_rel . " $query1 LIMIT $start, $num;");
    sql_err($mysqli, 'card_for_pay');
    // В цикле переносим результаты запроса в массив $postrow
    while ($res = mysqli_fetch_array($result)) {
        if ($res) {
            $postrow[] = $res;
        }
    };
    $navbeg = '<nav aria-label="Page navigation"><ul class="pagination">';
    $navend = '</ul></nav>';

    // Проверяем нужны ли стрелки назад
    if ($page > 3) $pervpage =
        '<li>
		  <a href=payment?pg=1 aria-label="Previous">
			<span aria-hidden="true">1</span>
		  </a>
		</li>
		<li>
		  <a href=payment?pg=' . ($page - 1) . ' aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
		  </a>
		</li>';

    // Проверяем нужны ли стрелки вперед
    if ($page < $total - 2) $nextpage =
        '<li>
		  <a href=payment?pg=' . ($page + 1) . ' aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
		  </a>
		</li>
		<li>
		  <a href=payment?pg=' . $total . ' aria-label="Next">
			<span aria-hidden="true">' . $total . '</span>
		  </a>
		</li>';

    // Находим две ближайшие станицы с обоих краев, если они есть
    if ($page - 2 > 0) $page2left = '<li><a href= payment?pg=' . ($page - 2) . '>' . ($page - 2) . '</a></li>';
    if ($page - 1 > 0) $page1left = '<li><a href= payment?pg=' . ($page - 1) . '>' . ($page - 1) . '</a></li>';
    if ($page + 2 <= $total) $page2right = '<li><a href= payment?pg=' . ($page + 2) . '>' . ($page + 2) . '</a></li>';
    if ($page + 1 <= $total) $page1right = '<li><a href= payment?pg=' . ($page + 1) . '>' . ($page + 1) . '</a></li>';
    $curpage = '<li class="active"><a href="#">' . $page . '<span class="sr-only">(current)</span></a></li>';

    // Вывод
    return json_encode(array($postrow, $navbeg . $pervpage . $page2left . $page1left . $curpage . $page1right . $page2right . $nextpage . $navend, $posts['MAX(id)']));
}

function add_payment($account, $card, $table, $check_card = 1)
{
    global $mysqli;

    $room_id = (int)$account['id'];
    $card_rel = (int)$account['acc_id'];
    $name = mysqli_escape_string($mysqli, htmlspecialchars($_POST['name']));
    $number = str_replace(' ', '', $_POST['number']);
    $number = mysqli_escape_string($mysqli, htmlspecialchars($number));
    $number = clear_phone($number);
    $month = (int)$_POST['month'];
    $year = (int)$_POST['year'];
    $cvc = (int)$_POST['cvc'];
    $amount = abs((int)$_POST['amount']);

    if (!getcard($number, $month, $year, $cvc, 0, 0) && strlen($number) >= 16) {
        return "false_card";
    }
    if (strlen($number) < 11) {
        return "false_phone";
    }
    if (strlen($number) == 11) {
        $phone = str_split($number);
        $phone = implode("{1,1}.*", $phone);
        $phone = "^.*" . $phone . "{1,1}.*$";//SELECT * FROM `accounts` WHERE `phone` REGEXP "^.*7{1,1}.*9{1,1}.*1{1,1}.*8{1,1}.*5{1,1}.*2{1,1}.*9{1,1}.*8{1,1}.*1{1,1}.*8{1,1}.*3{1,1}.*$" 918 529-81-83
        $card2 = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT a.* FROM accounts AS a WHERE a.phone REGEXP '$phone' LIMIT 1"));
        sql_err($mysqli, 'SELECT a.* FROM accounts AS a');
        if ($card2['id']) {
            return "false_exists_phone";
        }
    }
    $res = mysqli_fetch_array(mysqli_query($mysqli, "SELECT c.id FROM $table AS c WHERE c.number='$number'"));
    if ($res['id'] && strlen($number) >= 16) {
        return "exists";
    }
    if ($amount == 0) {
        return "err_data";
    }

    $sql = "INSERT INTO $table (room_id, card_rel, name, number, amount, date_act) values ('$room_id', '$card_rel', '$name', '$number', '$amount', CURRENT_TIMESTAMP)";
    $res = mysqli_query($mysqli, $sql);
    sql_err($mysqli, 'INSERT INTO card_for_pay ');

    //отправить смс
    if ($_POST['sms']) {
        $text_sms = "BarterCoin онлайн.  " . mb_strtoupper($card['name2']) . " " . mb_strtoupper($card['name3']) . " " . mb_strtoupper(mb_substr($card['name1'], 0, 1)) . ". перевел(а) Вам " . $amount . " BCR. https://bartercoin.holding.bz";
        sms($number, $text_sms);
    }

    return "true_card";
}

function upd_payment($account, $card, $table)
{
    global $mysqli;

    $room_id = (int)$account['id'];
    $card_rel = (int)$account['acc_id'];
    $name = mysqli_escape_string($mysqli, htmlspecialchars($_POST['name']));
    $amount = abs((int)$_POST['amount']);
    $id = (int)$_POST['card_n'];

    if ($amount == 0) {
        return "err_data";
    }

    $sql = "UPDATE $table SET name='$name', amount='$amount', date_act=CURRENT_TIMESTAMP WHERE id='$id' AND room_id='$room_id' AND card_rel='$card_rel' AND status_id<>1";
    $res = mysqli_query($mysqli, $sql);
    sql_err($mysqli, 'UPDATE card_for_pay');

    return true;
}

function del_payment($account, $card, $table)
{
    global $mysqli;

    $room_id = (int)$account['id'];
    $card_rel = (int)$account['acc_id'];
    $id = (int)$_GET['del'];

    `echo "    del_payment     "  >>/home/bartercoin/tmp/qaz`;
    $myecho = json_encode($_POST);
    `echo " _POST: "  $myecho >>/home/bartercoin/tmp/qaz`;
    $myecho = json_encode($_GET);
    `echo " _GET: "  $myecho >>/home/bartercoin/tmp/qaz`;
    $myecho = json_encode($account);
    `echo " account: "  $myecho >>/home/bartercoin/tmp/qaz`;

    $sql = "DELETE FROM $table WHERE id='$id' AND room_id=" . $room_id . " AND card_rel=" . $card_rel . "";
    $res = mysqli_query($mysqli, $sql);
    sql_err($mysqli, "DELETE FROM $table ");

    return true;
}


//отложенный платеж по номеру телефона
function phone_for_pay($mysqli, $card1)
{
    $phone = clear_phone($card1['phone']);
    $cards_pay = mysqli_query($mysqli, "SELECT c.* FROM phone_for_pay AS c WHERE c.number=" . $phone . " AND status_id<>1");
    foreach ($cards_pay as $card_pay) {//перевести BCR с карты хозяина
        //проверка карты хозяина
        $card_owner = getcardbyid($card_pay['card_rel']);
        if ($card_owner['black'] == 1 || $card_owner['activated'] == 0) $err[] = 'Ваша карта неактивна заблокирована';
        //определение комиссии
        $start_send = $card_pay['amount'];//сумма перевода с карты хозяина
        $comiss_base = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT comission FROM comissions WHERE `sum`<='" . (int)$card_owner['balance'] . "' ORDER BY `sum` DESC LIMIT 1"));
        if ($comiss_base) {
            $comission_act = 1 + $comiss_base['comission'] / 100;
        }
        $out = round((float)$start_send * $comission_act, 0);
        if ($card_owner['id']) {
            if (($start_send * ($comission_act - 1)) < $mincomission_act) $out = (float)$start_send + $mincomission_act;
            if (($card_owner['balance'] + $card_owner['lim']) < $out) $err[] = "Недостаточно средств на вашей карте";
            if ((float)$start_send <= 0) $err[] = "Сумма перевода должна быть больше 0";
            $sum = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sum) FROM transactions WHERE `fromid`=" . (int)$card_owner['id'] . " AND timestamp > '" . date("Y-m-d H:i:s", time() - (30 * 24 * 60 * 60)) . "'"));
            if (($sum['SUM(sum)'] + $out) > $card_owner['monthlim']) $err[] = "Превышен месячный лимит";
        }
        //перевести
        if (!$err[0]) {
            transaction($card_owner, $card1, $start_send, "Занесение " . $start_send . " БР при активации карты " . $card1['number'], 0, $comission_act, $mincomission_act);
            $card1 = getcardbyid($card1['id']);
            //обновить статус карты из списка  телефонов для перевода при активации
            $sql = "UPDATE phone_for_pay SET status_id=1, status='Активирована, $start_send BCR переведены, карта:" . $card1['number'] . "', date_act=CURRENT_TIMESTAMP WHERE id=" . $card_pay['id'] . "";
            $res = mysqli_query($mysqli, $sql);
            sql_err($mysqli, 'UPDATE card_for_pay true');
        } else {
            //записать ошибку в базу
            $errs = implode(', ', $err);
            $sql = "UPDATE card_for_pay SET status_id=2, status='$errs', date_act=CURRENT_TIMESTAMP WHERE id=" . $card_pay['id'] . "";
            $res = mysqli_query($mysqli, $sql);
            sql_err($mysqli, 'UPDATE card_for_pay error');
        }
    }
    return;
}

//банкоматы
function get_bank($mysqli, $num)
{
    $sql = "SELECT amount_max FROM settings WHERE `title`='bankomat' AND `amount`='" . (int)$num . "'";
    $res = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
    sql_err($mysqli, 'SELECT amount_max FROM settings bankomat');
    $sum = $res['amount_max'];
    return $sum;
}

function get_bank_time($mysqli, $num)
{
    $sql = "SELECT last_time FROM settings WHERE `title`='bankomat' AND `amount`='" . (int)$num . "'";
    $res = mysqli_fetch_assoc(mysqli_query($mysqli, $sql));
    sql_err($mysqli, 'SELECT last_time FROM settings bankomat');
    $last_time = $res['last_time'];
    return $last_time;
}

function put_bank($mysqli, $num, $sum)
{
    $sql = "UPDATE settings SET amount_max='" . (float)$sum . "', last_time=CURRENT_TIMESTAMP WHERE title='bankomat' AND amount='" . (int)$num . "'";
    $res = mysqli_query($mysqli, $sql);
    sql_err($mysqli, 'UPDATE settings SET amount_max bankomat');

    if ($res) {
        return true;
    } else {
        return false;
    }
}

//проверка типа платежной системы visa, mastercard
function check_vs_mc($target, $system, $card1)
{
    global $mysqli;
    $target = str_replace(' ', '', $target);
    //проверка изменилася ли номер карты
    if (recipient_oldest($target, $system, $card1) && $card1['cod_vs_mc']) {//$target, $system, $card1
        $code_value = '0';
        $cod_vs_mc = $card1['cod_vs_mc'];
    } else {
        $query = array(
            'cardNumber' => $target
        );
        if (!$curl = curl_init()) {
            die();
        }
        curl_setopt($curl, CURLOPT_URL, 'https://qiwi.com/card/detect.action');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array()
        );
        $out = curl_exec($curl);
        $out_err = curl_error($curl);
        $out = json_decode($out, true);

        $code_value = $out['code']['value'];
        $cod_vs_mc = $out['message'];
    }
    $card = '';
    $min = 2000;
    if ($code_value == '0') {
        $err = 1;
        $err_card = 'Ошибок нет';
        if ($cod_vs_mc == 1963) {
            $card = "Visa Россия";
            $min = 1000;
        } elseif ($cod_vs_mc == 21013) {
            $card = "Mastercard Россия";
            $min = 1000;
        } elseif ($cod_vs_mc == 31652 || $cod_vs_mc == 31873) {
            $card = "МИР Россия";
            $min = 1000;
        } elseif ($cod_vs_mc == 1960) {
            $card = "Visa СНГ";
            $min = 2000;
        } elseif ($cod_vs_mc == 21012) {
            $card = "Mastercard СНГ";
            $min = 2000;
        } elseif ($cod_vs_mc == 27292) {
            $card = "Карта Казахстана";
            $min = 2000;
        } elseif ($cod_vs_mc == 29795) {
            $card = "Карта Дальнее зарубежье";
            $min = 2000;
        }
    } elseif ($code_value == '2') {
        $err = 2;
        $err_card = 'Неправильный номер карты';
    } else {
        $err = 2;
        $err_card = 'Карта не определилась';
    }
    return array('err' => $err, 'err_card' => $err_card, 'card' => $card, 'min' => $min, 'cod_vs_mc' => $cod_vs_mc);
}


//вывод ошибок sql
function sql_err($mysqli, $fun)
{
    $myecho = json_encode(mysqli_error($mysqli), JSON_UNESCAPED_UNICODE);
    if (strlen($myecho) > 5) `echo " $fun : "  $myecho >>/home/bartercoin/tmp/qaz_sql_err`;
    return;
}

?>
