<?
//ini_set('session.gc_maxlifetime', 86400);
//session_start();
require('session.php');//session_start();
if(isset($_GET['logout'])){
$_SESSION['PHP_AUTH_USER']="";
$_SESSION['PHP_AUTH_PW']="";
}
if(isset($_POST['email'])){
$_SESSION['PHP_AUTH_USER']=strtolower($_POST['email']);
$_SESSION['PHP_AUTH_PW']=$_POST['password'];
}$auth=TRUE;
if (!isset($_SESSION['PHP_AUTH_USER'])){
$auth=FALSE;
}else{
$account=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM users WHERE email='".mysqli_escape_string($mysqli,$_SESSION['PHP_AUTH_USER'])."' LIMIT 1;"));
if($account['password']==''){$auth=FALSE;$account=array();}
if(md5($account['email'].sha1($account['email'].md5($_SESSION['PHP_AUTH_PW']))) !== $account['password']){$auth=FALSE;$account=array();}


if(isset($_GET['changerole']) & $auth){
$account['role']=(int)$_GET['changerole'];
mysqli_query($mysqli,"UPDATE `users` SET `role` = '".(int)$_GET['changerole']."' WHERE `users`.`id` = ".(int)$account['id'].";");
header('Location: '.$baseHref);die();
}
if(!in_array($account['role'],array(0,1)))$account['role']=0;


}
#if($_GET['logout']=='land'){session_destroy();header('Location: '.$baseHrefLand);die();}
if(isset($_GET['logout'])){session_destroy();header('Location: '.$baseHref);die();}
?>
