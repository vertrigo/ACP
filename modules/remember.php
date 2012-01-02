<?php

// начало
if (($PassRemember == 1) and ($mail_method != 'test'))
    { // если не тест, то работаем
    $phase = 0; //фаза 0
    // проверка на бан
    $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $r_connect);
    mysql_query("SET NAMES '$encoding'");
    $rip = 'no';
    $query = "SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $_SERVER['REMOTE_ADDR'] . "' LIMIT 1";
    $res = mysql_query($query);
    if (mysql_num_rows($res) == 1)
        {
        $row = mysql_fetch_assoc($res);
        $rip = $row['ip'];
        }
    if ($rip == $_SERVER['REMOTE_ADDR'])
        {
        echo $txt[14]; // если ИП в БАНе, то гудбай.
        return;
        }
    if (isset($_POST['email']) AND ($_POST['email'] != '') and (!isset($_POST['id']) OR ($_POST['id'] == '')))
        {
        $phase = 1; // фаза 1
        $_POST['email'] = mysql_real_escape_string($_POST['email']);
        if (!mb_eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$", $_POST['email']))
            {
            echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" align="center" valign="middle" class="ErrTitle">';
            echo '<b>' . $txt[20] . '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>' . $txt[50] . '</b></td></tr></table>';
            } //email not valid !!!!
        else
            {
            $query = "SELECT * FROM `account` WHERE `email` like '" . $_POST['email'] . "';";
            $res = mysql_query($query);
            $kol = 1;
            echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" colspan="5" align="center" valign="middle" class="TableTitle"><b>' . $txt[57] . '</b></td></tr>';
            echo '<form action="index.php?modul=remember" method="post">';
            while ($row = mysql_fetch_array($res))
                {
                $ra_id = $row['id'];
                $ra_username = $row['username'];
                $ra_last_ip = $row['last_ip'];
                $ra_locked = $row['locked'];
                $ra_online = $row[$online];
                echo '<tr><td width="50" height="40" class="TableLeft">&nbsp;</td>';
                echo '<td width="40" height="40" class="TableCenter" align="center">';
                $query2 = "SELECT `active` FROM `account_banned` WHERE `id`='" . $ra_id . "' LIMIT 1";
                $res2 = mysql_query($query2) or trigger_error(mysql_error() . $query2);
                if (mysql_num_rows($res2) == 1)
                    {
                    $row2 = mysql_fetch_assoc($res2);
                    $r_act = $row2['active'];
                    }
                else
                    $r_act = 0;
                if ($r_act == 1)
                    echo "<img src='images/no.png' align='absmiddle'> ";
                elseif ($ra_online > 0)
                    echo "<img src='images/yes.png' align='absmiddle'> ";
//                elseif (($_SERVER['REMOTE_ADDR'] != $ra_last_ip) AND ($ra_locked == '1')) echo  "<img src='images/no.png' align='absmiddle'> ";
                else
                    {
                    echo "<input name=id type=radio value='";
                    echo $ra_id;
                    echo "'>";
                    $kol++;
                    }
                echo '</td>';
                echo '<td width="200" height="40" class="TableCenter" align="left">' . $ra_username . '</td>';
                echo '<td width="160" height="40" class="TableCenter" align="right">' . $ra_last_ip . '</td>';
                echo '<td width="50" height="40" class="TableRight">&nbsp;</td></tr>';
                }
            if ($kol == 1)
                {
                echo '<tr><td width="50" height="50" class="TableLeft">&nbsp;</td>';
                echo '<td width="400" height="40" height="25" colspan="3" align="center" class="TableCenter">' . $txt[56];
                echo '</td><td width="50" height="40" class="TableRight">&nbsp;</td></tr></table>';
                } else
                {
                $phase = 2;
                echo '</table><br><div align="center"><input action="index.php" name="email" value="' . $_POST['email'] . '" type=hidden><input type="submit" value="' . $txt[11] . '"></div>';
                }
            echo '</form>';
            }
        }
    if (isset($_POST['id']) AND ($_POST['id'] > 0))
        {
        if (isset($_POST['email']) AND ($_POST['email'] != ''))
            $_POST['email'] = mysql_real_escape_string($_POST['email']);
        $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
        mysql_select_db($r_db, $r_connect);
        mysql_query("SET NAMES '" . $encoding . "'");
        $resM = mysql_query("SELECT `id`,`email` FROM `account` WHERE (`id`=" . (int) $_POST['id'] . ") and (`email` LIKE '" . $_POST['email'] . "') and (`active_realm_id` = 0) LIMIT 1;");
        $rowm = mysql_fetch_array($resM);
        if (mysql_num_rows($resM) == 1)
            {
            $realID = $rowm['id'];
            $realEmail = $rowm['email'];
            $mail_code = generate(40);
            $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
            mysql_select_db($k_db, $k_connect);
            mysql_query("SET NAMES '" . $encoding . "'");
            //  mysql_query('delete from `mail` where (`account` = '.$realID.') AND (`email` = "'.$_POST['email'].'")');
            mysql_query('delete from `mail` where (`account` = ' . $realID . ')');
            mysql_query('insert into `mail` (`random`, `account`, `email`, `mode`) values ("' . $mail_code . '", ' . $realID . ', "' . $realEmail . '", 1)');
            $http_mail = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?modul=mail&id=' . $mail_code;
            $mail_event = 'standart';
            $mail_body = $txt[61];
            $mail_body2 = '<a href="' . $http_mail . '">' . $http_mail . '</a>';
            $post_mail = $realEmail;
            require("include/mailsend.php");
            $log_account = $realID;
            $log_character = 0;
            $log_mode = 2;
            $log_email = $realEmail;
            $log_resultat = '';
            $log_note = '';
            $log_old_data = $_POST['email'];
            require('include/log.php');
            $phase = 3;
            } else
            {
            $phase = 4;
            echo $txt[138] . '<br>';
            }
        }
    if ($phase == 0)
        {
        echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td height="25" colspan="3" align="center" valign="middle" class="TableTitle"><b>' . $txt[58];
        echo '</b></td></tr><tr><td width="50" height="40" class="TableLeft">&nbsp;</td>';
        echo '<td width="400" height="40" class="TableCenter"><div align="justify">' . $txt[59];
        echo '<br></div></td><td width="50" height="40" class="TableRight">&nbsp;</td></tr></table>';
        }
    if ($phase < 2)
        {
        echo '<br><form action="index.php?modul=remember" method="post"><table width="500" border="0" cellspacing="0" cellpadding="0">';
        echo '<tr><td width="50" align="center" valign="middle">&nbsp;</td><td height="30" align="center" valign="middle"><img src="images/letter.png" align="absmiddle">&nbsp;&nbsp;';
        echo '<input name="email" type="text">&nbsp;&nbsp;<input type="submit" value="' . $txt[60];
        echo '"></td><td width="50" align="center" valign="middle">&nbsp;</td></tr></table></form>';
        }
    }
else
    echo $txt[138] . '<br>';
?>