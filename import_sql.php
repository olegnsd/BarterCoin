<?php

//require('inc/init.php');

ini_set('display_errors', 1);

echo('import_sql');


//$echo1 = mktime(date("H")+1, 0, 0, date("n"),date("j"), date("Y"));
//$echo2 = gmmktime(date("H")+1, 0, 0, date("n"),date("j"), date("Y"));
//$echo3 = date("m.d.Y H" ,mktime(date("H")+1, 0, 0, date("n"),date("j"), date("Y")));
//$echo4 = date("m.d.Y H" ,gmmktime(date("H")+1, 0, 0, date("n"),date("j"), date("Y")));
////$echo = date("m.d.Y H" ,mktime(0, 0, 0,date("d"), date("m"), date("Y"), date("H")));
//echo $echo1 . " Current" . "<br />\n";
//echo $echo2 . " gmCurrent" . "<br />\n";
//echo $echo3 . " Current" . "<br />\n";
//echo $echo4 . " gmCurrent" . "<br />\n";
//die();

//$query = "CREATE TABLE IF NOT EXISTS `tasks_tasks_sms` (
//  `id` int(6) NOT NULL AUTO_INCREMENT,
//  `user` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
//  `sms` mediumtext CHARACTER SET utf8 NOT NULL,
//  `sim` tinyint(4) NOT NULL,
//  `data` mediumtext CHARACTER SET utf8 NOT NULL,
//  `t_all` int(6) NOT NULL,
//  `next` int(6) NOT NULL DEFAULT '0',
//  `status` int(3) NOT NULL DEFAULT '-1' COMMENT '-1-пауза, 0-в процессе, 1-пауза, 2-выполнено',
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=182 ";

//$query = "UPDATE accounts SET phone = '+7 (918) 529-81-83' WHERE number='1000300701615314'";

//$query = "INSERT INTO `accounts` (`number`, `expiremonth`, `expireyear`, `cvc`, `activated`, `black`, `balance`, `lim`, `monthlim`, `withdrawlim`, `withdraw_int`, `amount_ref`, `name1`, `name2`, `name3`, `phone`, `ip_reg`, `yandex`, `qiwi`, `black_wallet`) VALUES
//('1000999999999999', 12, 99, 658, 1, 0, '0', 0, 1000000, 500, 60, 5, 'Карта', 'Теста', 'Бартеркойна', '+7 (918) 529-81-83', NULL, NULL, NULL, NULL)";
//
//$query = "ALTER TABLE accounts ADD phone_utc INT(2) DEFAULT NULL AFTER phone";
//mysqli_query($mysqli, $query);

//$query = "ALTER TABLE accounts ADD info_ip varchar(256) DEFAULT NULL AFTER ip_reg";
//mysqli_query($mysqli, $query);

//$query = "DELETE FROM accounts WHERE id=2542";
//mysqli_query($mysqli, $query);

//$query = "CREATE TABLE IF NOT EXISTS `loans` (
  //`id` int(11) NOT NULL AUTO_INCREMENT,
  //`user_id` int(11) NOT NULL,
  //`sum_loan` bigint(20) NOT NULL,
  //`date_loan` datetime DEFAULT NULL,
  //`decision` int(2) NOT NULL COMMENT '0-на рассмотр, 1-да, 2-отказ, 3-выдан',
  //`issue_date` datetime DEFAULT NULL,
  //`loan_rep` bigint(20) NOT NULL,
  //`date_rep` datetime DEFAULT NULL,
  //PRIMARY KEY (`id`)
//) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;";
//mysqli_query($mysqli, $query);

//$query = "ALTER TABLE accounts ADD loan_accept INT(2) DEFAULT '1' COMMENT '0-запрещено, 1-разрешено' AFTER amount_ref";
//mysqli_query($mysqli, $query);

//$query = "ALTER TABLE loans ADD sum_issuse bigint(20) NOT NULL AFTER sum_loan";
//mysqli_query($mysqli, $query);

//изменить тип поле
//$query = "ALTER TABLE accounts MODIFY COLUMN loan_accept MEDIUMINT DEFAULT '1' COMMENT '0-запрещено, 1-разрешено, 1****//-fisl'";
//mysqli_query($mysqli, $query);

//$query = "DELETE FROM loans WHERE user_id=1969";
//mysqli_query($mysqli, $query);

//изменить тип поле
//$query = "ALTER TABLE accounts ADD data MEDIUMTEXT NOT NULL COMMENT 'title=>text, descr=>text, got=>1-no, 2-yes' AFTER loan_accept";
//mysqli_query($mysqli, $query);

//изменение settings
//$query = "DELETE FROM `settings` WHERE 1";
//mysqli_query($mysqli, $query);
//$query = <<<'EOT'
//INSERT INTO `settings` (`id`, `title`, `amount`, `amount_max`, `delta_time`, `token`, `exp_token`, `last_time`) VALUES
//(1, 'add_br', 1, 103, 1, '{"token":"72baa209ca57d9a620f7de726eff96d5","ip":"","port":"","usr":"","pass":""}', '2019-05-13', '2018-11-23 16:26:03'),
//(2, 'sms_text', NULL, NULL, NULL, 'Priglashenie na registraciyu v BarterCoin ot $phone: https://bartercoin.holding.bz/create', NULL, NULL),
//(3, 'bankomat', 1, NULL, NULL, '{"title":"Основной","token":"5d842fb54c206521a1274978551df55f","card":"1000506236751958","ip":"192.168.37.25","port":"1080","usr":"hrm","pass":"asdsad23432423edfdsfsdfgrsgtYYYYYY"}', '2018-11-23', NULL),
//(4, 'bankomat', 2, NULL, NULL, '{"title":"Государственные дотации","token":"","card":"1000408733095056","ip":"","port":"","usr":"","pass":""}', '0000-00-00', NULL),
//(5, 'bankomat', 3, NULL, NULL, '{"title":"Арендные активы","token":"","card":"1000537528089757","ip":"","port":"","usr":"","pass":""}', '0000-00-00', NULL),
//(6, 'bankomat', 4, NULL, NULL, '{"title":"Сервисы Холдинга  и отчисления сотрудников","token":"","card":"1000760925001825","ip":"","port":"","usr":"","pass":""}', '0000-00-00', NULL),
//(7, 'bankomat', 5, NULL, NULL, '{"title":"Фиатные вводы BarterCoin","token":"","card":"1000506236751958","ip":"","port":"","usr":"","pass":""}', '0000-00-00', NULL),
//(8, 'bankomat', 6, NULL, NULL, '{"title":"Инвестиции в акции Холдинга","token":"","card":"1000506236751958","ip":"","port":"","usr":"","pass":""}', '0000-00-00', NULL),
//(9, 'bankomat', 7, NULL, NULL, '{"title":"Резервный запас","token":"ba1a1c68b7aac8dcb36c3ef50fbb9ebf","card":"1000506236751958","ip":"","port":"","usr":"","pass":""}', '2019-05-13', NULL)
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//добавление в accounts
//`bankomats` varchar(256) NOT NULL DEFAULT '{"allow":[1]}'

//$query = <<<'EOT'
//ALTER TABLE accounts ADD bankomats  varchar(256) NOT NULL DEFAULT '{"allow":[1]}' AFTER data;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE accounts ADD visa_mastercard  varchar(16) DEFAULT NULL AFTER qiwi;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = "ALTER TABLE transactions ADD bankomat int(2) NOT NULL AFTER iswithdraw";
//mysqli_query($mysqli, $query);

//$query = "UPDATE accounts SET activated=1 WHERE id='999'";
//mysqli_query($mysqli, $query);

//$query = "INSERT INTO `shops` (`id`, `card`, `name`, `key1`, `key2`, `url`) VALUES
//(6, 999, 'Бирживые операции', 'CT0NKVyVaxytwxTI', '6WR5FuIVkERK4UWr', 'https://shares.holding.home/stock_alrt.php');";
//mysqli_query($mysqli, $query);

//$query = "UPDATE `shops` SET `name`='Биржевые операции', `url`='https://shares.holding.bz/stock_alrt.php' WHERE id='6'";
//mysqli_query($mysqli, $query);

//добавление
//$query = "ALTER TABLE accounts ADD webmoney varchar(16) DEFAULT NULL AFTER visa_mastercard";
//mysqli_query($mysqli, $query);



//добавление
//$query = "ALTER TABLE accounts ADD `lim_one` int(10) UNSIGNED NOT NULL DEFAULT '200' COMMENT 'лимит за раз' AFTER withdrawlim";
//mysqli_query($mysqli, $query);

//изменить тип поле
//$query = "ALTER TABLE accounts MODIFY COLUMN last_sms int(10) UNSIGNED NOT NULL DEFAULT '0'";
//$res = mysqli_query($mysqli, $query);

//echo("res: ". json_encode($res));
//echo("err: ". json_encode(mysqli_error($mysqli)));

//$query = "INSERT INTO `shops` (`id`, `card`, `name`, `key1`, `key2`, `url`) VALUES
//(41, 996, 'bills.holding.bz', 'uajqKCKxEnSAFAUv', 'ALvfwe645ebG2Jhs', 'bills.holding.bz/alert_bcr.php');";
//mysqli_query($mysqli, $query);

//$query = "UPDATE `shops` SET `url`='https://bills.holding.bz/alert_bcr.php' WHERE id='41'";
//mysqli_query($mysqli, $query);

//$query = <<<'EOT'
//CREATE TABLE `pay_phone` (
  //`id` int(11) NOT NULL,
  //`answer` varchar(2048) DEFAULT NULL,
  //`date` datetime NOT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `pay_phone`
  //ADD PRIMARY KEY (`id`);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `pay_phone`
  //MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));


//$query = <<<'EOT'
//CREATE TABLE `comissions` (
  //`id` int(11) NOT NULL,
  //`sum` bigint(11) NOT NULL,
  //`comission` smallint(11) NOT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//INSERT INTO `comissions` (`id`, `sum`, `comission`) VALUES
//(3, 100000, 5),
//(1, 1000000, 15),
//(2, 500000, 10);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `comissions`
  //ADD PRIMARY KEY (`id`);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `comissions`
  //MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));


//$query = <<<'EOT'
//CREATE TABLE `balance` (
  //`id` int(11) NOT NULL,
  //`sum` bigint(20) NOT NULL,
  //`add_sum` smallint(6) NOT NULL,
  //`max` smallint(6) NOT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//INSERT INTO `balance` (`id`, `sum`, `add_sum`, `max`) VALUES
//(1, 100, 1, 2),
//(2, 500, 1, 5),
//(3, 10000, 1, 500),
//(4, 100000, 10, 700);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `balance`
  //ADD PRIMARY KEY (`id`);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `balance`
  //MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));


//$query = <<<'EOT'

//INSERT INTO `settings` (`id`, `title`, `amount`, `amount_max`, `delta_time`, `token`, `exp_token`, `last_time`) VALUES
//(10, 'add_5_7', 7, NULL, 1, '{\"time_add\":\"00:16\"}', NULL, '2019-05-06 17:05:25');
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//CREATE TABLE `balance12` (
  //`id` int(11) NOT NULL,
  //`sum` bigint(20) NOT NULL,
  //`add_sum` smallint(6) NOT NULL,
  //`max` smallint(6) NOT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=latin1;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//INSERT INTO `balance12` (`id`, `sum`, `add_sum`, `max`) VALUES
//(1, 10000, 500, 1000);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `balance12`
  //ADD PRIMARY KEY (`id`);
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `balance12`
  //MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
//EOT;
//mysqli_query($mysqli, $query);
//echo(mysqli_error($mysqli));

//echo('import_sql');

//$query = <<<'EOT'
//CREATE TABLE `adminy` (
  //`id` int(11) NOT NULL,
  //`name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  //`email` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  //`phone` varchar(15) NOT NULL DEFAULT '',
  //`password` varchar(70) NOT NULL DEFAULT '',
  //`is_admin` int(2) NOT NULL DEFAULT '0',
  //`util` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'жкх',
  //`comment` mediumtext NOT NULL,
  //`seen` timestamp NULL DEFAULT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=cp1251;
//EOT;
//echo(mysqli_query($mysqli, $query));
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//INSERT INTO `adminy` (`id`, `name`, `email`, `phone`, `password`, `is_admin`, `util`, `comment`, `seen`) VALUES
//(1, ' Толстых Олег Всеволодович ', 'olegnsd@gmail.com', '79260001026', '$2y$10$gPWe51iuLbKpZsRYuH3QluFLTtATPPs0Fb31FHgt5NVZhHhlECTKC', 1, 1, 'учредитель', '2019-02-11 16:23:04'),
//(2, 'Выскубов Сергей Нилолаевич', 'vyskuboff@ya.ru', '79505852858', '$2y$10$2iHwNdDRYg1tXQEWRVk2p.LJ/pqjH3LWcXYxk0YisPeKeJAE4av7S', 0, 0, 'исполниельный диретктор', '2019-02-11 17:25:51'),
//(3, 'Лобанов Иван Борисович', 'jondoll@yandex.ru', '79895187845', '019207', 0, 0, 'сисадмин Холдинга', '2018-11-30 18:38:49'),
//(4, 'Кириенко Максим Александрович', 'qwertyfamiliya@gmail.com', '79185298183', '$2y$10$/LwtADCD2j1Iirl8vpeZTOQdWovo9GsjHrQ/FHFq1a7wn18yX/Z/y', 1, 1, 'разраб действующий', '2019-05-19 16:10:27'),
//(5, 'Констурткор Империй / Милитари Холдинг', 'info2@holding.bz', '79295893561', '184016', 0, 0, '', '2018-09-10 09:48:13');
//EOT;
//echo(mysqli_query($mysqli, $query));
//echo(mysqli_error($mysqli));

//$query = <<<'EOT'
//ALTER TABLE `adminy`
  //ADD PRIMARY KEY (`id`);
//EOT;
//echo(mysqli_query($mysqli, $query));
//echo(mysqli_error($mysqli));

//query = <<<'EOT'
//ALTER TABLE `adminy`
  //MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
//EOT;
//echo(mysqli_query($mysqli, $query));
//echo(mysqli_error($mysqli));

