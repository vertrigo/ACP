<?php
$rip = '';
$rip2 = '';
$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
$res0 = mysql_query("SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1");
if (mysql_num_rows($res0) > 0)
    {
    $row0 = mysql_fetch_assoc($res0);
    $rip = $row0['ip'];
    }
$res = mysql_query("SELECT * FROM `account` WHERE `id`=" . $_SESSION['user_id'] . " LIMIT 1");
if (mysql_num_rows($res) > 0)
    {
    $row = mysql_fetch_assoc($res);
    $ra_id = $row['id'];
    $ra_email = $row['email'];
    $ra_last_ip = $row['last_ip'];
    }
$res = mysql_query("SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $ra_last_ip . "' LIMIT 1");
if (mysql_num_rows($res) > 0)
    {
    $row0 = mysql_fetch_assoc($res);
    $rip2 = $row0['ip'];
    } else
    {
    $rip2 = 'no';
    }

$res = mysql_query("SELECT `active` FROM `account_banned` WHERE `id`='" . $ra_id . "' LIMIT 1");
if (mysql_num_rows($res) > 0)
    {
    $row2 = mysql_fetch_assoc($res);
    $r_act = $row2['active'];
    } else
    {
    $r_act = '0';
    }
?>
<form method="POST">
    <input name="modul" value="accedit" type=hidden>
    <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="25" colspan="3" align="center" valign="middle" class="TableTitle">
                <b><?php echo $txt['1']; ?></b>
            </td>
        </tr>
        <tr>
            <td width="50" height="40" align="center" valign="middle">
                <?php
                if ($ra_email == '')
                    echo "<img src='images/no.png' align='absmiddle'>";
                else
                    echo "<input name=id type=radio value='1' />";
                ?>
            </td>
            <td width="400" height="40" valign="middle">
                <?php echo $txt['6']; ?>
            </td>
            <td width="50" height="40" align="center" valign="middle">
                <?php
                if ($ra_email == '')
                    echo "<img src='images/no.png' align='absmiddle'>";
                else if ($ra_last_ip == $_SESSION['ip'])
                    echo "<img src='images/yes.png' align='absmiddle'>";
                else
                    echo "<img src='images/letter.png' align='absmiddle'>";
                ?>
            </td>
        </tr>
        <tr>
            <td height="40" align="center" valign="middle">
                <?php
                if (($ra_email == '') or ($AccountEmailChange == 1))
                    echo "<input name=id type=radio value='2' >";
                else
                    echo "<img src='images/no.png' align='absmiddle'>";
                ?>
            </td>
            <td height="40" valign="middle"><?php echo $txt['7']; ?></td>
            <td height="40" align="center" valign="middle">
                <?php
                if (($ra_email == '') OR (($ra_last_ip == $_SESSION['ip']) and ($AccountEmailChange == 1)))
                    {
                    echo "<img src='images/yes.png' align='absmiddle'>";
                    }
//	   if ($ra_email == '')  {echo "<img src='images/yes.png' align='absmiddle'>";}
                else
                    {
                    echo "<img src='images/letter.png' align='absmiddle'>";
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td height="40" align="center" valign="middle"><input name=id type=radio value='3' /></td>
            <td height="40" valign="middle"><?php echo $txt['8']; ?></td>
            <td height="40" align="center" valign="middle"><img src='images/yes.png' align='absmiddle'></td>
        </tr>
        <tr>
            <td height="40" align="center" valign="middle"><input name=id type=radio value='4' /></td>
            <td height="40" valign="middle"><?php echo $txt['9']; ?></td>
            <td height="40" align="center" valign="middle"><img src='images/yes.png' align='absmiddle'></td>
        </tr>
        <tr>
            <td height="40" align="center" valign="middle"><input name=id type=radio value='5' /></td>
            <td height="40" valign="middle"><?php echo $txt['10']; ?></td>
            <td height="40" align="center" valign="middle"><?php
                if (($ra_email == '') OR ($ra_last_ip == $_SESSION['ip']))
                    {
                    echo "<img src='images/yes.png' align='absmiddle'>";
                    } else
                    {
                    echo "<img src='images/letter.png' align='absmiddle'>";
                    }
                ?></td>
        </tr>
    </table>
    <br>
    <?php
    if (($rip2 == 'no') and ($r_act == '0'))
        {
        echo '<div align="center"><input type="submit" value="' . $txt['11'] . '"></div>';
        } else
        {
        echo '<div align="center"><font color=red><b>' . $txt['76'] . '</b></font></div>';
        }
    ?></form><br />