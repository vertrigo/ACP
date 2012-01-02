<?php

// проверки:
if (!isset($_GET['id']))
    {
    echo $txt[138]; // нет id
    return;
    }
if (isset($_GET['id']) and (!mb_eregi("^[a-zA-Z0-9]{40}$", $_GET['id'])))
    {
    echo $txt[138]; // id не подходит под шаблон проверки
    return;
    }
$_GET['id'] = substr($_GET['id'], 0, 40); // id ровно 40 символов

echo '<img src="images/mail_logo.jpg"><br>';
echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" colspan="5" align="center" valign="middle" class="TableTitle"><b>' . $txt[108] . '</b></td></tr>';
echo '<tr><td width="10" height="40" class="TableLeft">&nbsp;</td>';
echo '<td width="200" height="40" class="TableCenter" align="center" valign="middle">' . $txt[109] . '<b>' . $_GET['id'] . '</b></td>';
echo '<td width="10" height="40" class="TableRight">&nbsp;</td></tr>';
echo '</table><br>';
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '" . $encoding . "'");
$res = mysql_query("SELECT * FROM `mail` WHERE `random` = '" . $_GET['id'] . "' LIMIT 1");
if (mysql_num_rows($res) == 1)
    {
    $row = mysql_fetch_assoc($res);
    if (isset($_POST['id']) AND ($_POST['id'] == 13))
        {
        if (mb_eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$", $_POST['new_email']))
            {
            $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
            mysql_select_db($r_db, $r_connect);
            mysql_query("SET NAMES '$encoding'");
            mysql_query("UPDATE `account` set `locked` = 0, `email` = '" . $_POST['new_email']
                    . "' WHERE `id` = " . $row['account']);
            echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>'
            . $txt[114] . '</b><br>';
            $log_account = $row['account'];
            $log_character = 0;
            $log_mode = 5;
            $log_email = $_POST['new_email'];
            $log_resultat = '';
            $log_note = '';
            $log_old_data = $row['email'];
            require('include/log.php');
            $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
            mysql_select_db($k_db, $k_connect);
            mysql_query("SET NAMES '" . $encoding . "'");
            mysql_query("DELETE FROM `mail` WHERE `random` = '" . $_GET['id'] . "'");
            } else
            {
            echo '<img src="images/no.png"> ' . $txt[66] . '<br><br>';
            echo '<b><a href="?modul=mail&id=' . $_GET['id'] . '">' . $txt[115] . '</a></b><br>';
            }
        return;
        }
    if ($row['mode'] == 1)
        {
        $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
        mysql_select_db($r_db, $r_connect);
        mysql_query("SET NAMES '$encoding'");
        $rrr = mysql_query("select `username`,`sha_pass_hash` from `account`  WHERE `id` = " . $row['account'] . " limit 1");
        $r3 = mysql_fetch_assoc($rrr);
        $new_pass = strtoupper(generate(10));
        $new_hash = SHA1(strtoupper($r3['username']) . ':' . strtoupper($new_pass));
        mysql_query("UPDATE `account` set `sha_pass_hash` = '" . $new_hash . "', `s` = null, `v` = null, `sessionkey` = null  WHERE `id` = " . $row['account']);
        $mail_event = 'standart';
        $mail_body = $txt[117];
        $mail_body2 = $txt[1] . ': <b>' . $r3['username'] . '</b><br><br>' . $txt[118] . ': <b>' . $new_pass . '</b>';
        $post_mail = $row['email'];
        require("include/mailsend.php");

        echo '<img src="images/yes.png"> ' . $txt[116] . '<br>';
        $log_account = $row['account'];
        $log_character = 0;
        $log_mode = 3;
        $log_email = $row['email'];
        $log_resultat = $new_hash;
        if ($LogSavePass == 1)
            $log_note = $new_pass;
        else
            $log_note = '';
        $log_old_data = $r3['sha_pass_hash'];
        require('include/log.php');
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        mysql_query("DELETE FROM `mail` WHERE `random` = '" . $_GET['id'] . "'");
        echo '<br><br>';
        return;
        }
    if ($row['mode'] == 2)
        {
        echo '<form method="post" action="?modul=mail&id=' . $_GET['id'] . '">
	 <input name="modul" value="mail" type=hidden>
	 <input name="id" value="13" type=hidden>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" colspan="3" align="center" valign="middle" class="TableTitle">' . $txt[7] . '</td>
    </tr>
  <tr>
    <td width="300" align="right" height="60" valign="middle" class="TableLeft">' . $txt[113] . '</td>
    <td width="10" height="60" valign="middle" class="TableCenter">&nbsp;</td>
    <td width="190" height="60" align="left" valign="middle" class="TableRight"><input name="new_email" type="text" /></td>
  </tr>
  <tr>
    <td width="300" align="right" valign="middle">&nbsp;</td>
    <td width="10" height="40" valign="middle">&nbsp;</td>
    <td width="190" height="40" align="left" valign="middle"><input type="submit" value="' . $txt[11] . '"></td>
  </tr>
</table></form>
	 ';
        return;
        }
    if ($row['mode'] == 3)
        {
        $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
        mysql_select_db($r_db, $r_connect);
        mysql_query("SET NAMES '$encoding'");
        mysql_query("UPDATE `account` set `locked` = 0 WHERE `id` = " . $row['account']);
        echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>' . $txt[17] . '</b><br>';
        $log_account = $row['account'];
        $log_character = 0;
        $log_mode = 8;
        $log_email = $row['email'];
        $log_resultat = '';
        $log_note = '';
        $log_old_data = '';
        require('include/log.php');
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        mysql_query("DELETE FROM `mail` WHERE `random` = '" . $_GET['id'] . "'");
        return;
        }
    if ($row['mode'] == 4)
        {
        $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
        mysql_select_db($r_db, $r_connect);
        mysql_query("SET NAMES '$encoding'");
        mysql_query("UPDATE `account` set `locked` = 0, `email` = '" . $row['email'] . "' WHERE `id` = " . $row['account']);
        echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>' . $txt[114] . '</b><br>';
        $log_account = $row['account'];
        $log_character = 0;
        $log_mode = 5;
        $log_email = $row['email'];
        $log_resultat = '0';
        $log_note = '';
        $log_old_data = '';
        require('include/log.php');
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        mysql_query("DELETE FROM `mail` WHERE `random` = '" . $_GET['id'] . "'");
        return;
        }
    }
else
    echo '<br><table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" align="center" valign="middle" class="ErrTitle">
    <b>' . $txt['20'] . '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>' . $txt[110] . '</b></td></tr></table><br>';
?>