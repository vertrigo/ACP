<?php

$er = 0;
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
    echo $txt['14'];
    return;
    }
if ($AccIpLimit > 0)
    {
    $query = "SELECT COUNT(`id`) AS kol FROM `account` WHERE `last_ip`='" . $_SERVER['REMOTE_ADDR'] . "'";
    $resk = mysql_query($query);
    $rowk = mysql_fetch_assoc($resk);
    $ripk = $rowk['kol'];
    if ($ripk >= $AccIpLimit)
        {
        echo $txt['267'];
        return;
        }
    }
if (isset($_POST['reg']) AND isset($_POST['new_acc']) AND ($_POST['reg'] == '1'))
    {
    $er = 0;
    $er_txt = '';
    if (!mb_eregi("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$", $_POST['email']))
        {
        $er = 1;
        $er_txt = $txt['50'];
        }
    if (($_POST['pass1'] == $_POST['new_acc']) OR ($_POST['pass1'] != $_POST['pass2']))
        {
        $er = 1;
        $er_txt = $txt['51'];
        }
    if (($_POST['pass1'] == '') OR ($_POST['pass2'] == '') OR ($_POST['new_acc'] == '') OR ($_POST['email'] == ''))
        {
        $er = 1;
        $er_txt = $txt['52'];
        }
    if ($KcaptchaEnable > 0)
        {
        if (!isset($_SESSION['captcha_keystring']) OR !isset($_POST['kapcha_code_reg']) OR
                (strtolower($_SESSION['captcha_keystring']) <> strtolower($_POST['kapcha_code_reg'])))
            {
            $er = 1;
            $er_txt = $txt['52'];
            }
        }

    if ($er == 0)
        {
        $query1 = 'select count(`username`) as kol from `account` where `username` = "' . strtoupper($_POST['new_acc']) . '"';
        $res1 = mysql_query($query1);
        $row1 = mysql_fetch_assoc($res1);
        if ($row1['kol'] > 0)
            {
            $er = 1;
            $er_txt = $txt['53'];
            }
        }
    if ($er == 0)
        {
        mysql_query("INSERT INTO `account` (`username`,`sha_pass_hash`,`email`,`last_ip`,`locked`,`expansion`) VALUES (UPPER('"
                . $_POST['new_acc'] . "'),SHA1(UPPER(CONCAT('" . $_POST['new_acc'] . "',':','" . $_POST['pass1'] . "'))),'"
                . $_POST['email'] . "','" . $_SERVER['REMOTE_ADDR'] . "','0','" . $def_exp_acc . "')");
        echo '<img src="images/yes.png"> <b>' . $txt['55'] . '</b><br><br><hr><div align="center"><A href="index.php">' . $txt[12] . '</a></div>';
        $query2 = "SELECT * FROM `account` WHERE `username`='" . strtoupper($_POST['new_acc'])
                . "' AND sha_pass_hash ='"
                . SHA1(strtoupper($_POST['new_acc'] . ':' . $_POST['pass1'])) . "'";
        $res2 = mysql_query($query2);
        if (mysql_num_rows($res2) == 1)
            {
            $row2 = mysql_fetch_assoc($res2);
            $_SESSION['user_id'] = $row2['id'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['kito'] = strtoupper($_POST['new_acc']);
            $_SESSION['slovo'] = strtoupper(SHA1(strtoupper($_POST['new_acc']) . ':' . strtoupper($_POST['pass1'])));
            $_SESSION['gnom'] = 0;
            $_SESSION['modul'] = 'news';
            $_SESSION['acpskin'] = $acpskin;
            unset($_SESSION['captcha_keystring']);
            $log_account = $_SESSION['user_id'];
            $log_character = 0;
            $log_mode = 1;
            $log_email = $_POST['email'];
            $log_resultat = '';
            $log_note = $_SESSION['kito'];
            $log_old_data = '';
            require('include/log.php');
            }
        ReturnMainForm(40);
        return;
        }
    if ($er == 1)
        {
        echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td height="25" align="center" valign="middle" class="ErrTitle"><b>' . $txt[20];
        echo '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>' . $er_txt . '</b></td></tr></table>';
        }
    }
if ($er == 0)
    {
    echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr>';
    echo '<td height="25" colspan="3" align="center" valign="middle" class="TableTitle"><b>' . $txt[4] . '</b></td></tr>';
    echo '<tr><td width="50" height="40" class="TableLeft">&nbsp;</td>';
    echo '<td width="400" height="40" class="TableCenter"><div align="justify">' . $txt[54] . '<br /></div></td>';
    echo '<td width="50" height="40" class="TableRight">&nbsp;</td></tr></table>';
    }
// form begin
echo '<br>';
echo '<form method="post" action="index.php?modul=reg"><input name="reg" value="1" type=hidden>';
echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">';
// account name
echo '<tr><td width="130" height="30" align="right" valign="middle">' . $txt[1] . '</td><td width="10" height="30">&nbsp;</td>';
echo '<td width="150" height="30" align="left" valign="middle"><span class="LoginInput"><input type="text" name="new_acc" ';
if (isset($_POST['new_acc']) AND ($_POST['new_acc'] != ''))
    echo ' value="' . $_POST['new_acc'] . '"';
echo '></span></td></tr>';
// password 1 
echo '<tr><td width="130" height="30" align="right" valign="middle">' . $txt[2] . '</td>';
echo '<td width="10" height="30">&nbsp;</td><td width="150" height="30" align="left" valign="middle"><span class="LoginInput">';
echo '<input type="password" name="pass1"></span></td></tr>';
// password 2
echo '<tr><td width="130" height="30" align="right" valign="middle">';
echo $txt[48] . '</td><td height="30">&nbsp;</td><td width="150" height="30" align="left" valign="middle"><span class="LoginInput">';
echo '<input type="password" name="pass2"></span></td></tr>';
// email
echo '<tr><td width="130" height="30" align="right" valign="middle">' . $txt[32] . '</td><td width="10" height="30">&nbsp;</td>';
echo '<td width="150" height="30" align="left" valign="middle"><span class="LoginInput"><input type="text" name="email" ';
if (isset($_POST['email']) AND ($_POST['email'] != ''))
    echo ' value="' . $_POST['email'] . '"';
echo '/></span></td></tr>';
// kapcha
if ($KcaptchaEnable > 0)
    {
    echo '<tr><td width="130" height="30" align="right" valign="middle">'
    . '<iframe src="./kcaptcha.php" marginheight="0" marginwidth="0" width="100" height="40" frameborder="0" scrolling="no" allowtransparency="true"></iframe>'
    . '</td>';
    echo '<td width="10" height="30">&nbsp;</td><td width="150" height="30" align="left" valign="middle"><span class="LoginInput">';
    echo '<input type="text" name="kapcha_code_reg">'
    . '</span></td></tr>';
    }
// submit key
echo '<tr><td width="130" height="40" align="left" valign="bottom">&nbsp;</td>';
echo '<td width="10" height="40" valign="bottom">&nbsp;</td><td width="150" height="40" align="left" valign="bottom"><span class="LoginButton">';
echo '<input type="submit" value="' . $txt[49] . '" ></span></td></tr>';
// end form
echo '</table></form>';
?>