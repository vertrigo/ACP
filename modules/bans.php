<?php

$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
mysql_query("UPDATE `account_banned` SET `active` = 0 WHERE (`bandate` < `unbandate`) and (`unbandate` < UNIX_TIMESTAMP())");
mysql_query("DELETE FROM `ip_banned` WHERE (`bandate` < `unbandate`) and (`unbandate` < UNIX_TIMESTAMP())");
if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] >= $UnBanLevel))
    {
    if (isset($_GET['ui']) and mb_ereg("^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$", $_GET['ui']))
        {
        mysql_query("DELETE FROM `ip_banned` WHERE `ip` = '" . $_GET['ui'] . "'");
        $log_account = $_SESSION['user_id'];
        $log_character = 0;
        $log_mode = 10;
        $log_email = '';
        $log_resultat = 'unban ip';
        $log_note = $_GET['ui'];
        $log_old_data = '';
        require('include/log.php');
        }
    if (isset($_GET['ua']) and ((int) ($_GET['ua']) > 0))
        {
        mysql_select_db($r_db, $r_connect);
        mysql_query("SET NAMES '$encoding'");
        mysql_query("UPDATE `account_banned` SET `active` = 0 WHERE `id` = " . (int) $_GET['ua']);
        $log_account = $_SESSION['user_id'];
        $log_character = 0;
        $log_mode = 10;
        $log_email = '';
        $log_resultat = 'unban account';
        $log_note = $_GET['ua'];
        $log_old_data = '';
        require('include/log.php');
        }
    }
if (!isset($UnBanLevel))
    {
    $UnBanLevel = 2;
    }
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_query("SELECT bandate, unbandate, banreason, account_banned.id as idd, username FROM account_banned, account WHERE (account_banned.id = account.id) and (account_banned.active = 1) ORDER BY bandate DESC") or trigger_error(mysql_error());
echo '<br><table width="95%" border="0" cellspacing="0" cellpadding="0"><tr><td height="40" valign="middle" align="center" class="NewsTitleGM">';
echo $txt[180];
echo '</td></tr>';
echo '<tr><td align="center">
<table width="550" border="0" cellspacing="0" cellpadding="0">
<tr><td height="25" colspan="6" align="center" valign="middle" class="TableTitle"><b>' . $txt[80] . '</b></td></tr>
<tr><td width="10" class="TableOther">&nbsp;</td>
<td width="160" align="left" valign="middle" class="TableOther">' . $txt[1] . '</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[83] . '</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[84] . '</td>
<td width="150" align="left" valign="middle" class="TableOther">' . $txt[251] . '</td>
<td width="10" class="TableOther">&nbsp;</td></tr>';
$kol = 1;
while ($mres = mysql_fetch_array($res))
    {
    echo '<tr><td width="10" align="center" valign="middle" class="TableLeft">&nbsp;</td>';
    echo '<td width="160" align="left" valign="middle" class="TableCenter"><b>';
    if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] >= $UnBanLevel))
        {
        echo '<a href="index.php?modul=banlist&ua=' . $mres['idd'] . '" target="_blank">';
        echo '<img src="images/delete.png" align="absmiddle" border=0></a>&nbsp;&nbsp;&nbsp;';
        }
    if (isset($_SESSION['user_id']) AND ($_SESSION['user_id'] == $mres['idd']))
        echo '<font color=red>' . $mres['username'] . '</font>';
    else
        echo $mres['username'];
    echo '</b></td>';
    if ($mres['bandate'] == $mres['unbandate'])
        {
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['bandate']) . '</td>';
        echo '<td width="110" align="left"  valign="middle" class="TableCenter"><font color=red><b>' . $txt[250] . '</b></font></td>';
        } else
        {
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['bandate']) . '</td>';
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['unbandate']) . '</td>';
        }
    echo '<td width="150" align="left"  valign="middle" class="TableCenter">' . $mres['banreason'] . '</td>';
    echo '<td width="10" class="TableRight">&nbsp;</td></tr>';
    $kol++;
    }
if ($kol == 1)
    {
    echo '<tr><td colspan="5" align="center" valign="middle" ><b>' . $txt[81] . '</b></td></tr>';
    }
echo '</table>';

$res = mysql_query("SELECT ip, bandate, unbandate, banreason FROM ip_banned");
echo '<br><table width="550" border="0" cellspacing="0" cellpadding="0">
<tr><td height="25" colspan="6" align="center" valign="middle" class="TableTitle"><b>' . $txt[82] . '</b></td></tr>
<tr><td width="10" class="TableOther">&nbsp;</td>
<td width="160" align="left" valign="middle" class="TableOther">IP</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[83] . '</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[84] . '</td>
<td width="150" align="left" valign="middle" class="TableOther">' . $txt[251] . '</td>
<td width="10" class="TableOther">&nbsp;</td></tr>';
$kol = 1;
while ($mres = mysql_fetch_array($res))
    {
    echo '<tr><td width="10" align="center" valign="middle" class="TableLeft">&nbsp;</td>';
    echo '<td width="160" align="left" valign="middle" class="TableCenter"><b>';
    if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] >= $UnBanLevel))
        {
        echo '<a href="index.php?modul=banlist&ui=' . $mres['ip'] . '" target="_blank">';
        echo '<img src="images/delete.png" align="absmiddle" border=0></a>&nbsp;&nbsp;&nbsp;';
        }
    if ($mres['ip'] == $_SERVER['REMOTE_ADDR'])
        echo '<font color=red>' . $mres['ip'] . '</font>';
    else
        echo $mres['ip'];
    echo '</b></td>';
    if ($mres['bandate'] == $mres['unbandate'])
        {
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['bandate']) . '</td>';
        echo '<td width="110" align="left"  valign="middle" class="TableCenter"><font color=red><b>' . $txt[250] . '</b></font></td>';
        } else
        {
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['bandate']) . '</td>';
        echo '<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $mres['unbandate']) . '</td>';
        }
    echo '<td width="150" align="left"  valign="middle" class="TableCenter">' . $mres['banreason'] . '</td>';
    echo '<td width="10" class="TableRight">&nbsp;</td></tr>';
    $kol++;
    }
if ($kol == 1)
    {
    echo '<tr><td colspan="5" align="center" valign="middle" ><b>' . $txt[81] . '</b></td></tr>';
    }
echo '</table>';

if ($JailShow == 1)
    {
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_query("SELECT `guid`, `char`, `release`, `duration`, `reason` FROM `jail` WHERE `release` <> '0' ORDER BY `release` DESC") or trigger_error(mysql_error());

    echo '<br><table width="550" border="0" cellspacing="0" cellpadding="0">
<tr><td height="25" colspan="6" align="center" valign="middle" class="TableTitle"><b>' . $txt[192] . '</b></td></tr>
<tr><td width="10" class="TableOther">&nbsp;</td>
<td width="160" align="left" valign="middle" class="TableOther">' . $txt[23] . '</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[83] . '</td>
<td width="110" align="left" valign="middle" class="TableOther">' . $txt[84] . '</td>
<td width="150" align="left" valign="middle" class="TableOther">' . $txt[251] . '</td>
<td width="10" class="TableOther">&nbsp;</td></tr>';
    $kol = 1;
    while ($jres = mysql_fetch_array($res))
        {
        echo '<tr><td width="10" align="center" valign="middle" class="TableLeft">&nbsp;</td>';
        echo '<td width="160" align="left" valign="middle" class="TableCenter">';
        if ($charview == '')
            echo '<b>' . $jres['char'] . '</b>';
        else
            echo '<b><a href="' . $charview . $jres['guid'] . '" target="_blank">' . $jres['char'] . '</a></b>';
        echo '</td><td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $jres['release'] - $jres['duration'] * 3600) . '</td>
<td width="110" align="left"  valign="middle" class="TableCenter">' . date("d-m-Y H:i", $jres['release']) . '</td>
<td width="150" align="left"  valign="middle" class="TableCenter">' . $jres['reason'] . '</td>
 <td width="10" class="TableRight">&nbsp;</td></tr>';
        $kol++;
        }
    if ($kol == 1)
        {
        echo '<tr><td colspan="5" align="center" valign="middle" ><b>' . $txt[81] . '</b></td></tr>';
        }
    echo '</table>';
    }
echo '</td></tr></table>';
//if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] >= $UnBanLevel))
echo "<br><button onclick=\"document.location.href='index.php?modul=banlist';\">" . $txt[252] . "</button>";
?>