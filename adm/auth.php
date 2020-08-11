<?php
//include('../old/config.php');
//if(!$configLoaded)die("direct access forbidden");
//ini_set('session.gc_maxlifetime', 86400);
//session_start();


if(isset($_GET['logout'])){
	$_SESSION['PHP_AUTH_USER']="";
	$_SESSION['PHP_AUTH_PW']="";
}
$auth=TRUE;
if(isset($_POST['phone'])){
	$_SESSION['PHP_AUTH_USER']=phone($_POST['phone']);
	$_SESSION['PHP_AUTH_PW']=$_POST['pin'];
    //рекаптча <!--убрать коммент для рекапчи-->
    if($_POST['check1']=='' & $_POST['check2']==''){
        if($curl = curl_init()){
            $query = array(
                'secret' => '6LcwhzYUAAAAAJ_gz9MaYcjZDWTg8TV7fOhdLuGP',
                'response' => $_POST['g-recaptcha-response'],
            );

            curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $query); 

            $out = curl_exec($curl);

            curl_close($curl);

            $out = json_decode($out, true);
        }

        if(!$out['success']){
            $auth=FALSE;
        }  
    }
    //<!--убрать коммент для рекапчи-->
}
if(isset($_POST['phone'])){
	$_SESSION['PHP_AUTH_USER']=phone($_POST['phone']);
	$_SESSION['PHP_AUTH_PW']=$_POST['pin'];
}
if (!isset($_SESSION['PHP_AUTH_USER'])){
	$auth=FALSE;
}else{
	$account=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM `adminy` WHERE phone='".mysqli_escape_string($mysqli,$_SESSION['PHP_AUTH_USER'])."' LIMIT 1;"));
	if($account['password']==''){
		$auth=FALSE;
        $account=array();
	}
	if(!password_verify($_SESSION['PHP_AUTH_PW'], $account['password'])){
		$auth=FALSE;
	}
}
if($auth){
	if($_SESSION['seen']<(time()-60*30) | isset($_POST['phone'])){
		mysqli_query($mysqli,"UPDATE `adminy` SET `seen`=CURRENT_TIMESTAMP WHERE id='".(int)$account['id']."'");
		$_SESSION['seen']=time();
        $_SESSION['name'] = $account['name'];
	}
}
if(isset($_GET['logout']))session_destroy();
?>
