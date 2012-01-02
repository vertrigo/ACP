<?php

if ($lang == 'en')
    require "include/zone_names." . $lang . ".php";
else
    require "include/zone_names." . $lang . "." . $encoding . ".php";
$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
if ($ServerSystem == 1)
    $rres = mysql_query("SELECT `id`, `gmlevel` FROM `account_access` WHERE `gmlevel` > 0") or trigger_error(mysql_error());
else
    $rres = mysql_query("SELECT `id`, `gmlevel` FROM `account` WHERE `gmlevel` > 0") or trigger_error(mysql_error());
$gms = Array(0 => 0);
while ($gmres = mysql_fetch_array($rres))
    {
    $gms[$gmres['id']] = $gmres['gmlevel'];
    }
$lres = mysql_query("SELECT `id`, `name`, `address`, `port` FROM `realmlist`") or trigger_error(mysql_error());
echo '<table width="560" border="0" cellspacing="0" cellpadding="0">';
echo '<tr><td height="25" colspan="3" align="center" valign="middle" class="TableTitle"><b>' . $txt[247] . '</b></td></tr>';
$real = 0;
while ($llres = mysql_fetch_array($lres))
    {
    echo '<tr>';
    echo '<td width="90" align="center" valign="middle" class="TableLeft">';
    $fp = @fsockopen($llres['address'], $llres['port'], $errno, $errstr, 1);
    if ($fp)
        {
        echo '<img src="images/online.png" align="absmiddle" alt="online">&nbsp;<font color=navy><b>Online</b></font>';
        $real++;
        }
    else
        echo '<img src="images/offline.png" align="absmiddle" alt="offline">&nbsp;<font color=red><b>Offline</b></font>';

    echo '</td>';
    echo '<td height="40" align="center" valign="middle" class="TableCenter">' . $llres['name'] . '</td>';
    echo '<td height="40" align ="center" valign="middle" class="TableRight">';
    if (isset($_SESSION['gnom']) AND ($_SESSION['gnom'] > 1))
        echo $llres['address'] . '<b> : </b>' . $llres['port'];
    else
        echo '&nbsp;';
    echo '</td>';
    echo '</tr>';
    }
echo '</table><br><br>';
if ($real == 0)
    return;
$kol = 1;
$c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
mysql_select_db($c_db, $c_connect);
mysql_query("SET NAMES '$encoding'");
$ares = mysql_query("SELECT count(`guid`) as kol FROM `characters` WHERE `online` = 1") or trigger_error(mysql_error());
$kolzap = mysql_fetch_array($ares);
if ($kolzap['kol'] > $PageOnline)
    {
    $PageLen = $PageOnline;
    if (!isset($_GET['page']) or ($_GET['page'] == ''))
        $StartRec = 0;
    else
        $StartRec = ((int) $_GET['page'] - 1) * $PageOnline;
    }
else
    {
    $PageLen = $kolzap['kol'];
    $StartRec = 0;
    }
$res = mysql_query("SELECT `name`, `class`, `guid`, `race`, `online`, `gender`, `level`, `account`, `map`, `zone` FROM `characters` WHERE `online` = 1 order by `name` limit " . $StartRec . "," . $PageLen) or trigger_error(mysql_error());
if (mysql_num_rows($res) > 0)
    {
    echo '<table width="560" border="0" cellspacing="0" cellpadding="0">';
    echo '<tr><td height="30" colspan="7" align="right" valign="bottom"><b>' . $txt[244] . $kolzap['kol'] . '</b></td></tr>';
    echo '<tr><td height="25" colspan="7" align="center" valign="middle" class="TableTitle"><b>' . $txt[221] . '</b></td></tr>';
    echo '<tr><td width="30" align="center" valign="middle" class="TableOther">#</td>';
    echo '<td width="40" align="center" valign="middle" class="TableOther">Fr.</td>';
    echo '<td width="120" align="left" valign="middle" class="TableOther">Name</td>';
    echo '<td width="40" align="center" valign="middle" class="TableOther">Race</td>';
    echo '<td width="40" align="center" valign="middle" class="TableOther">Class</td>';
    echo '<td  width="30" align="center" valign="middle" class="TableOther">level</td>';
    echo '<td width="260" align ="center" valign="middle" class="TableOther">Zone</td></tr>';
    while ($cres = mysql_fetch_array($res))
        {
        echo '<tr>';
        echo '<td width="30" align="center" valign="middle" class="TableLeft">' . ($kol + $StartRec) . '</td>';
        echo '<td height="40" width="40" align="center" valign="middle" class="TableCenter">';
        if (isset($gms[$cres['account']]))
            echo '<img src="images/gm.png" align="absmiddle" alt="GM">'; //GM
        else
            {
            if (($cres['race'] == 1) or ($cres['race'] == 3) or ($cres['race'] == 4) or ($cres['race'] == 7) or ($cres['race'] == 11))
                echo "<img src='images/alliance.gif' align='absmiddle' alt='Alliance'>"; //Alliance
            if (($cres['race'] == 2) or ($cres['race'] == 5) or ($cres['race'] == 6) or ($cres['race'] == 8) or ($cres['race'] == 10))
                echo "<img src='images/horde.gif' align='absmiddle' alt='Horde>'"; //Horde
            }
        echo '</td>';
        echo '<td height="40" width="120" align="left" valign="middle" class="TableCenter">';
        if ($charview == '')
            {
            echo '<b>' . $cres['name'] . '</b></td>';
        } else
            {
            echo '<b><a href="' . $charview . $cres['guid'] . '" target="_blank">' . $cres['name'] . '</a></b></td>';
        }
        echo '<td height="40" width="40" align="center" valign="middle" class="TableCenter"><img src="images/race/' . $cres['race'] . '-' . $cres['gender'] . '.png" align="absmiddle"></td>';
        echo '<td height="40" width="40" align="center" valign="middle" class="TableCenter"><img src="images/class/' . $cres['class'] . '.png" align="absmiddle"></td>';
        echo '<td height="40"  width="30" align="center" valign="middle" class="TableCenter">' . $cres['level'] . '</td>';
        echo '<td height="40" width="260" align ="center" valign="middle" class="TableRight">';
        if (isset($zones[$cres['zone']]))
            echo $zones[$cres['zone']];
        else
            {
            if (isset($zones[('1000' . $cres['map'] . $cres['zone'])]))
                echo $zones[('1000' . $cres['map'] . $cres['zone'])];
            else
                echo 'World (' . $cres['map'] . ',' . $cres['zone'] . ')';
            }
        echo'</td>';
        echo '</tr>';
        $kol++;
        }
    } else
    {
    echo '<table width="560" border="0" cellspacing="0" cellpadding="0"><tr><td height="40" colspan="7" align="center" valign="middle" >';
    if (isset($_GET['page']) and ($_GET['page'] > 1))
        echo '- - -';
    else
        echo $txt[222];
    echo '</td></tr>';
    }
if ($kolzap['kol'] > $PageOnline)
    {
    $PageCounter = ceil($kolzap['kol'] / $PageOnline);
    if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
        $tp3 = 1;
    else
        $tp3 = (int) $_GET['page'];
    echo '<tr><td height="40" colspan="7" align="center" valign="middle" >' . ShowPageNavigator('index.php?modul=online&page=', $tp3, $PageCounter) . '</td></tr>';
    }
echo '</table>';
?>	 
