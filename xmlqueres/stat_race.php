<?php

session_start();
if (!isset($_SESSION['realmd']))
    $_SESSION['realmd'] = 1;
if (isset($_GET['realmdselect']))
    $_SESSION['realmd'] = $_GET['realmdselect'];
require "../config/realmlist.php";
require "../config/config.php";
require "stat_txt." . $encoding . ".php";
$c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
mysql_select_db($c_db, $c_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_query("SELECT COUNT(*) AS kol,`race` FROM `characters` GROUP BY `race` ORDER BY `kol` DESC ");
if (mysql_num_rows($res) > 0)
    {
    $kol = 0;
    while ($rres = mysql_fetch_array($res))
        {
        echo $stat_race[$rres["race"]] . ";" . $rres["kol"];
        if ($kol == 0)
            echo ';true';
        $kol++;
        echo "\n";
        }
    }
?>