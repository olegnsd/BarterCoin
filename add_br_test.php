<?php

echo("<title>");
echo("</title>");
echo("<body>");
if($_GET['token']=='5664del'){
	unlink("/home/bartercoin/tmp/qaz_add_br");
	echo('add_br_test unlink');
	exit;
}

if($_GET['token']!='9287')exit;

echo('add_br_test');

$last_time_lt = file_get_contents("/home/bartercoin/tmp/qaz_add_br");


echo("<pre>");
print_r($last_time_lt);
echo("</pre>");
echo("</body>");



