<?php

$rip = '';
$r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
mysql_select_db($r_db, $r_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_query("SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1");
if (mysql_num_rows($res) > 0)
    {
    $row0 = mysql_fetch_assoc($res);
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

if (($rip == $_SERVER['REMOTE_ADDR']) OR ($rip2 == $ra_last_ip))
    {
    echo $txt['14'];
    return;
    }
if ($r_act == '1')
    {
    echo $txt['15'];
    return;
    }
if (isset($_POST['id']) AND ($_POST['id'] == 51) AND ($ra_email == ''))
    {
    if (!mb_eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$", $_POST['new_email']))
        {
        echo '<table width="500" border="0" cellspacing="0" cellpadding="0">'
        . '<tr><td height="25" align="center" valign="middle" class="ErrTitle"><b>'
        . $txt['20']
        . '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>'
        . $txt['50'] . '</b></td></tr></table><br><br>';
        } else
        {
        $mail_code = generate(40);
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        mysql_query('delete from `mail` where (`account` = ' . $ra_id . ')');
        mysql_query('insert into `mail` (`random`, `account`, `email`, `mode`) values ("'
                . $mail_code . '", ' . $ra_id . ', "' . $_POST['new_email'] . '", 4)');
        $http_mail = 'http://' . $_SERVER['HTTP_HOST']
                . $_SERVER['PHP_SELF'] . '?modul=mail&id=' . $mail_code;
        $mail_event = 'standart';
        if (isset($_POST['id']) AND ($_POST['id'] == 1))
            $mail_body = $txt['61'];
        else
            $mail_body = $txt['112'];
        $mail_body2 = '<a href="' . $http_mail . '">' . $http_mail . '</a>';
        $post_mail = $_POST['new_email'];
        require("include/mailsend.php");

        $log_account = $ra_id;
        $log_character = 0;
        $log_mode = 4;
        $log_email = $_POST['new_email'];
        $log_resultat = '';
        $log_note = $mail_code;
        $log_old_data = '';
        require('include/log.php');

        ReturnMainForm(60);
        return;
        }
    }
if (($ra_email == '') AND (isset($_POST['id'])) AND ($_POST['id'] == 2))
    {
    echo '<form method="post">
	 <input name="modul" value="accedit" type=hidden>
	 <input name="id" value="51" type=hidden>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" colspan="3" align="center" valign="middle" class="TableTitle">'
    . $txt['7'] . '</td>
    </tr>
  <tr>
    <td width="300" align="right" height="60" valign="middle" class="TableLeft">'
    . $txt['113'] . '</td>
    <td width="10" height="60" valign="middle" class="TableCenter">&nbsp;</td>
    <td width="190" height="60" align="left" valign="middle" class="TableRight"><input name="new_email" type="text" /></td>
  </tr>
  <tr>
    <td width="300" align="right" valign="middle">&nbsp;</td>
    <td width="10" height="40" valign="middle">&nbsp;</td>
    <td width="190" height="40" align="left" valign="middle"><input type="submit" value="'
    . $txt['11'] . '"></td>
  </tr>
</table></form>
	 ';
    return;
    }
if (isset($_POST['id']) AND (($_POST['id'] == 1) OR (($_POST['id'] == 2) AND ($AccountEmailChange == 1))) AND ($ra_email != ''))
    {
//if (isset($_POST['id']) AND ($_POST['id'] == 1) AND ($ra_email != '')) {
    $mail_code = generate(40);
    $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
    mysql_select_db($k_db, $k_connect);
    mysql_query("SET NAMES '" . $encoding . "'");
    mysql_query('delete from `mail` where (`account` = ' . $ra_id . ')');
    mysql_query('insert into `mail` (`random`, `account`, `email`, `mode`) values ("'
            . $mail_code . '", ' . $ra_id . ', "' . $ra_email . '", ' . (int) $_POST['id'] . ')');
    $http_mail = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?modul=mail&id=' . $mail_code;

    $mail_event = 'standart';
    if ($_POST['id'] == 1)
        $mail_body = $txt['61'];
    else
        $mail_body = $txt['112'];
    $mail_body2 = '<a href="' . $http_mail . '">' . $http_mail . '</a>';
    $post_mail = $ra_email;
    require("include/mailsend.php");

    $log_account = $ra_id;
    $log_character = 0;
    if ($_POST['id'] == 1)
        $log_mode = 2;
    else
        $log_mode = 4;
    $log_email = $ra_email;
    $log_resultat = '';
    $log_note = $mail_code;
    $log_old_data = '';
    require('include/log.php');

    ReturnMainForm(60);
    return;
    }
if (isset($_POST['id']) AND ($_POST['id'] == 3))
    {//type select
    echo '<b>' . $txt['8'] . '</b><br><br><img src="images/other/box_wow.jpg">&nbsp;'
    . '<img src="images/other/box_tbc.jpg">&nbsp;<img src="images/other/box_wotlk.jpg">'
    . '<br><br><form method="POST"><input name="modul" value="accedit" type=hidden>';
    echo '<select name=type>';
    for ($i = 0; $i <= 2; $i++)
        {
        echo '<option value=' . ($i + 1);
        if ($i == $row['expansion'])
            echo ' selected>';
        else
            echo '>';
        echo getExpansion($i) . '</option>';
        }
    echo '</select>&nbsp;<input type=submit value="' . $txt['11'] . '"></form><br><br><hr>';
    //ReturnMainForm(10);
    return;
    }
if (isset($_POST['type']) AND ($_POST['type'] >= 1))
    { //type accept
    mysql_query("UPDATE `account` set `expansion` = " . ((int) $_POST['type'] - 1)
            . " WHERE `id` = " . $_SESSION['user_id']);
    echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> '
    . $txt['16'] . '<b> - ' . getExpansion((int) $_POST['type'] - 1)
    . '</b><br><br><hr></div>';
    ReturnMainForm(60);
    return;
    }
if (isset($_POST['id']) AND ($_POST['id'] == 5))
    { //unlock
    if (($ra_email == '') OR ($ra_last_ip == $_SESSION['ip']))
        {
        mysql_query("UPDATE `account` set `locked` = 0 WHERE `id` = " . $_SESSION['user_id'] . ";");
        echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>'
        . $txt['17'] . '</b><br><br><hr><div align="center"><A href="index.php">'
        . $txt['12'] . '</a></div>';
        ReturnMainForm(60);
        return;
        } else
        {
        $mail_code = generate(40);
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        mysql_query('delete from `mail` where (`account` = ' . $ra_id . ')');
        mysql_query('insert into `mail` (`random`, `account`, `email`, `mode`) values ("'
                . $mail_code . '", ' . $ra_id . ', "' . $ra_email . '", 3)');
        $http_mail = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']
                . '?modul=mail&id=' . $mail_code;
        $mail_event = 'standart';
        $mail_body = $txt['111'];
        $mail_body2 = '<a href="' . $http_mail . '">' . $http_mail . '</a>';
        $post_mail = $ra_email;
        require("include/mailsend.php");

        ReturnMainForm(60);
        return;
        }
    }
if (isset($_POST['id']) AND ($_POST['id'] == 4))
    { //lock
    mysql_query("UPDATE `account` set `locked` = 1 WHERE `id` = " . $_SESSION['user_id']);
    echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>'
    . $txt['18'] . '!</b><br><br><hr><div align="center"><A href="index.php">' . $txt['12']
    . '</a></div>';
    ReturnMainForm(60);
    return;
    }
echo '<table width="500" border="0" cellspacing="0" cellpadding="0">'
 . '<tr><td height="25" align="center" valign="middle" class="ErrTitle"><b>'
 . $txt['20'] . '</b></td></tr><tr>'
 . '<td height="45" align="center" valign="middle"  class="ErrTab"><b>' . $txt['19']
 . '</b></td></tr></table><br><br>';
?>