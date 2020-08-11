<?php

if(isset($_GET['logout'])){
	$_SESSION['FRONT_AUTH_USER']="";
	$_SESSION['FRONT_AUTH_PW']="";
}
if(isset($_POST['pin'])){
	$_SESSION['FRONT_AUTH_PW']=$_POST['pin'];
}
$auth_front=TRUE;
    $res_per_room = mysqli_query($mysqli,"SELECT p.*, a.phone FROM per_room AS p, accounts AS a  WHERE p.acc_id='".$card['id']."' AND p.acc_id=a.id LIMIT 1");
    sql_err($mysqli, 'per_room');
	$account=mysqli_fetch_assoc($res_per_room);
	if($account['password']==''){
		$auth_front=FALSE;
        $account=array();
	}
	if(!password_verify($_SESSION['FRONT_AUTH_PW'], $account['password'])){
		$auth_front=FALSE;
	}else{
//        $_SESSION['FRONT_AUTH_USER'] = $phone_user;
    }

if(isset($_GET['logout'])){
    session_destroy();
    header('Location: '. $baseHref );
    exit;
}
?>
