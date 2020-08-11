<?php

echo("<title>");
echo("</title>");
echo("<body>");
if($_GET['token']=='5664del'){
	unlink("/home/api.goip/tmp/qaz_telegram");
	echo('telegram unlink');
	exit;
}

if($_GET['token']!='9287')exit;

echo('telegram');

$last_time_lt = file_get_contents("/home/api.goip/tmp/qaz_telegram");


echo("<pre>");
print_r($last_time_lt);
echo("</pre>");
echo("</body>");
