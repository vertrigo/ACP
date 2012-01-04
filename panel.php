<?php

if (!isset($r_ip) or ($r_ip == ''))
    return;
echo '<table width="220" border="0" cellspacing="0" cellpadding="3">';
echo '<tr><td align="center">';
echo $txt[30];
echo '</td></tr>';
echo '<tr><td colspan=4 class="PanelTop">&nbsp;</td></tr>';
echo '<tr><td align="center" class="NewsTitlePlayer">';
echo '<a href="index.php">' . $ServerName . '</a>';
echo '</td></tr>';
echo '<tr><td class="PanelBottom">&nbsp;</td></tr>';
echo '</table><br><br>';
if (!isset($_SESSION['user_id']) or ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']))
    {
    require $modules['login'][0];
    echo '<br><br>';
    } else
    {
    $rip = '';
    $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $r_connect);
    mysql_query("SET NAMES '$encoding'");
    $query0 = "SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1";
    $res0 = mysql_query($query0);
    if ($row0 = mysql_fetch_assoc($res0))
        $rip = $row0['ip'];
    $query = "SELECT * FROM `account` WHERE `id`=" . $_SESSION['user_id'] . " LIMIT 1";
    $res = mysql_query($query) or trigger_error(mysql_error() . $query);
    if ($row = mysql_fetch_assoc($res))
        {
        $ra_id = $row['id'];
        $ra_username = $row['username'];
        if($_SESSION['gnom'] < 5)
           $ra_gmlevel = $txt[70 + $_SESSION['gnom']];
        else
        $ra_gmlevel = $txt[74];
        $ra_email = $row['email'];
        $ra_joindate = $row['joindate'];
        $ra_last_ip = $row['last_ip'];
        $ra_locked = $row['locked'];
        $ra_last_login = $row['last_login'];
        $ra_online = $row[$online];
        $ra_expansion = getExpansion($row['expansion']);
        $ra_locale = getlocale($row['locale']);
        }
    if (strtoupper($_SESSION['slovo']) != strtoupper($row['sha_pass_hash']))
        {
        session_destroy();
        echo '<table width="500" border="0" cellspacing="0" cellpadding="0">';
        echo '<tr><td height="25" align="center" valign="middle" class="ErrTitle"><b>';
        echo $txt[20] . '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>';
        echo $txt[120] . '</b></td></tr></table><br><br>';
        ReturnMainForm(40);
        return;
        }
    $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $r_connect);
    mysql_query("SET NAMES '$encoding'");
    $query2 = "SELECT `active` FROM `account_banned` WHERE `id`='" . $ra_id . "' LIMIT 1";
    $res2 = mysql_query($query2) or trigger_error(mysql_error());
    if ($row2 = mysql_fetch_assoc($res2))
        $r_act = $row2['active'];
    else
        $r_act = '0';
    $d = '&copy;&nbsp;Kot&nbsp;DaW' . 'IN' . 'chi&nbsp;' . date('Y') . '&nbsp;' . '<br>version  ' . $acp_ver . '.' . $rev;
    echo '<table width="220" border="0" cellspacing="0" cellpadding="3">';
    echo '<tr><td align="left" valign="top" class="PanelTitle">' . $txt[1] . '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    echo '<a href="index.php?modul=acc">' . $ra_username . '</a></td></tr>';
    if ($ShowIdAcc == 1)
        {
        echo '<tr><td align="left" valign="top" class="PanelTitle">';
        echo $txt[214];
        echo '</td></tr><tr><td align="right" valign="bottom" class="PanelData">';
        echo $ra_id;
        echo '</td></tr>';
        }
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[16];
    echo '</td></tr><tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_expansion;
    echo '</td></tr><tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[31];
    echo '</td></tr><tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_gmlevel;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[32];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    if (!mb_eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$", $ra_email))
        {
        echo $txt[66];
        if ($ra_email <> '')
            {
            mysql_query('update `account` set `email` = "" where `id` = ' . $ra_id . ';');
            $ra_email = '';
            }
        }
    else
        echo $ra_email;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[33];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_locale;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[34];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    if ($ra_online == 1)
        echo $txt[35];
    else
        echo $txt[36];
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[37];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_joindate;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[38];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_last_login;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[39];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    echo $ra_last_ip;
    echo '</td></tr>';
    echo '<tr><td align="left" valign="top" class="PanelTitle">';
    echo $txt[40];
    echo '</td></tr>';
    echo '<tr><td align="right" valign="bottom" class="PanelData">';
    if ($ra_locked == 0)
        echo $txt[42];
    else
        echo $txt[41];
    echo '</td></tr>';
    echo '</table><br><br>';
// =======char show ===============
    echo '<table width="220" border="0" cellspacing="0" cellpadding="4">';
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $c_query = "SELECT `name`, `class`, `guid`, `race`, `online`, `gender`, `level`, `money` FROM `characters` WHERE `account` = $ra_id order by `guid`;";
    $res = mysql_query($c_query);
    $kol = 1;
    echo '<tr><td colspan=4 align="left" valign="bottom">' . $txt[248] . '</td></tr>';
    echo '<tr><td colspan=4 class="PanelTop">&nbsp;';
    echo '</td></tr>';
    if (mysql_num_rows($res) > 0)
        while ($cres = mysql_fetch_array($res))
            {
            $money = $cres['money'];
            echo '<tr>';
            echo '<td>';
            echo "<img src='images/race/" . $cres['race'] . "-" . $cres['gender'] . ".gif' align='absmiddle'> ";
            echo "<img src='images/class/" . $cres['class'] . ".gif' align='absmiddle'> ";
            echo '</td>';
            echo '<td>';
            if ($cres['online'] == 1)
                echo '<font color=red><b>' . $cres['name'] . '</b></font></td>';
            else
                echo '<b><a href="index.php?modul=char&id=' . $cres['guid'] . '" target="_self">' . $cres['name'] . '</a></b></td>';
            echo '<td>';
            echo $cres['level'] . '</td>';
            echo '<td>';
            if ($charview == '')
                echo '&nbsp;';
            else
                echo '<a href="' . $charview . $cres['guid'] . '" target="_blank"><img src="images/question.png" alt="Detals" BORDER=0 align="absmiddle"><a>';
            echo '</td>';
            echo '</tr>';
            $kol++;
            }
    echo '<tr><td colspan=4 class="PanelBottom">&nbsp;</td></tr>';
    echo '</table><br>';
    }
// ======= realmd select ==========
$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
$query = "SELECT * FROM `realmlist` order by `id`";
$realml = mysql_query($query);
if (mysql_num_rows($realml) > 1)
    {
    echo "\n" . '<table width="220" border="0" cellspacing="0" cellpadding="4">';
    echo '<tr><td colspan=2 align="left" valign="bottom">' . $txt[247] . '</td></tr>';
    echo '<tr><td colspan=2 class="PanelTop">&nbsp;';
    echo '</td></tr>';
    while ($rlist = mysql_fetch_array($realml))
        {
        if ($rlist['id'] == $_SESSION['realmd'])
            {
            echo '<tr>';
            echo '<td align="left" valign="middle">';
            echo '<img src="images/yes.png" alt="Select" BORDER=0 align="absmiddle">';
            echo '</td>';
            echo '<td align="left" valign="middle"><b>' . $rlist['name'] . '</b></td>';
            echo '</tr>';
            } else
            {
            echo '<tr>';
            echo '<td>';
            echo '</td>';
            echo '<td align="left" valign="middle"><a href="index.php?modul=' . $ChangeRealmModule . '&realmdselect=' . $rlist['id'] . '" target="_self">' . $rlist['name'] . '</a></td>';
            echo '</tr>';
            }
        }
    echo '<tr><td colspan=2 class="PanelBottom">&nbsp;</td></tr>';
    echo '</table><br><br>';
    }
echo $d;
?>