<?php

session_start();
if (!isset($_SESSION['realmd']))
    $_SESSION['realmd'] = 1;
if (isset($_GET['realmdselect']))
    $_SESSION['realmd'] = $_GET['realmdselect'];
require "../config/realmlist.php";
require "../config/config.php";
require "stat_txt." . $encoding . ".php";
/////////////////
$old_day = '200';
/////////////////
$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_fetch_array(mysql_query("select count(*) as kol from `account` "));
$res_all = $res['kol'];

$res = mysql_fetch_array(mysql_query("select count(*) as kol from `account` where unix_timestamp(`last_login`) > (unix_timestamp(now())-" 
        . $old_day . "*24*60*60) "));
$res_play = $res['kol'];

$res = mysql_fetch_array(mysql_query("select count(*) as kol from `account` where `last_login` = '0000-00-00 00:00:00' "));
$res_null = $res['kol'];

echo $stxt[1];
echo ($res_play) . ";true\n";
echo $stxt[2];
echo ($res_all - $res_play - $res_null) . "\n";
echo $stxt[3];
echo ($res_null) . "\n";
?>