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
    $horde = 0;
    $aliane = 0;
    while ($rres = mysql_fetch_array($res))
        {
        if (($rres['race'] == 1) or ($rres['race'] == 3) or
                ($rres['race'] == 4) or ($rres['race'] == 7) or ($rres['race'] == 11))
            $aliane += $rres["kol"]; //Alliance
        if (($rres['race'] == 2) or ($rres['race'] == 5) or
                ($rres['race'] == 6) or ($rres['race'] == 8) or ($rres['race'] == 10))
            $horde += $rres["kol"]; //Horde
        }
    echo $stxt[4] . $aliane . ";true\n";
    echo $stxt[5] . $horde . "\n";
    }
?>