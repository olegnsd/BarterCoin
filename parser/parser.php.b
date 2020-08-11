<?die();

$mysql_conf['host']   = "localhost";
$mysql_conf['port']   = 3306;
$mysql_conf['user']   = "wizardgrp_barter";
$mysql_conf['pass']   = "fXCeRKrrWE";
$mysql_conf['dbname'] = "wizardgrp_barter";
$mysqli=mysqli_connect($mysql_conf[host],$mysql_conf[user],$mysql_conf[pass],$mysql_conf['dbname']);
mysqli_set_charset($mysqli, "utf8");

$preg='/(.*)	(.*)\/(.*)	(.*)/';
preg_match_all($preg, file_get_contents('data'), $matches);
//print_r($matches);die();
$i=0;
while($matches[2][$i]){
mysqli_query($mysqli,"INSERT INTO `accounts` (`id`, `number`, `expiremonth`, `expireyear`, `cvc`, `activated`, `balance`) VALUES (NULL, '".$matches[1][$i]."', '".$matches[2][$i]."', '".$matches[3][$i]."', '".$matches[4][$i]."', '0', '0');");
$i++;}
/**/

?>
