<?php
include('../old/config.php');
require('../old/functions.php');
require('../inc/session.php');//session_start();
require('auth.php');

$acc_id = $_GET['id'];

if($_GET['photo']=='photo'){
    $path = "foto". $acc_id;//"../temp/passport/foto". $acc_id .".jpeg";
}elseif($_GET['photo']=='register'){
    $path = "register". $acc_id;//"../temp/passport/register". $acc_id .".jpeg";
}elseif($_GET['photo']=='add'){
    $path = "add". $acc_id;//"../temp/passport/add". $acc_id .".jpeg";//htmlspecialchars($_GET['id'])
}

$image = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT image FROM image WHERE image_name = '$path' limit 1"));

header('Content-type: image/jpeg');
echo(base64_decode($image['image'])); 
exit;

//$acc_id = $_GET['id'];

//if($_GET['photo']=='photo'){
    //$path = "/home/bartercoin/tmp/passport/foto". $acc_id .".jpeg";
    //$photo = imagecreatefromjpeg($path);
//}elseif($_GET['photo']=='register'){
    //$path = "/home/bartercoin/tmp/passport/register". $acc_id .".jpeg";
    //$photo = imagecreatefromjpeg($path);
//}elseif($_GET['photo']=='add'){
    //$path = "/home/bartercoin/tmp/passport/add". $acc_id .".jpeg";//htmlspecialchars($_GET['id'])
    //$photo = imagecreatefromjpeg($path);
//}

//header('Content-type: image/jpeg');
//imagejpeg($photo); 
//imagedestroy($photo);
