<?php

if (isset($Block_login) and ($Block_login == 1))
    {
    echo '<form method="POST">
  <table border="0" cellpadding="0" cellspacing="0" width="200">
  <tr><td height="30" align="left" valign="middle" class="LoginText">';
    echo $txt['1'];
    echo ':&nbsp;</td><td height="30" align="right" valign="middle" class="LoginInput">'
    . '<input type="text" name="auth_name" size=10></td></tr>'
    . '<tr><td height="30" align="left" valign="middle" class="LoginText">';
    echo $txt['2'];
    echo ':&nbsp;</td><td height="30" align="right" valign="middle" class="LoginInput">'
    . '<input type="password" name="auth_pass" size=10></td></tr>';
    if ($KcaptchaEnable == 1)
        {
        echo '<tr><td height="30" align="left" valign="middle" class="LoginText">';
        echo '<iframe src="./kcaptcha.php" marginheight="0" marginwidth="0" width="100" height="40" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
        echo '</td><td height="30" align="right" valign="middle" class="LoginInput">'
        . '<input type="text" name="kapcha_code" size=10></td></tr>';
        } elseif (($KcaptchaEnable == 2) AND ($login_count > 0))
        {
        echo '<tr><td height="30" align="left" valign="middle" class="LoginText">';
        echo '<iframe src="./kcaptcha.php" marginheight="0" marginwidth="0" width="100" height="40" frameborder="0" scrolling="no" allowtransparency="true"></iframe>';
        echo '</td><td height="30" align="right" valign="middle" class="LoginInput">'
        . '<input type="text" name="kapcha_code" size=10></td></tr>';
        }
    echo '<tr><td height="30" colspan="2" align="right" valign="middle" class="LoginButton">'
    . '<input type="submit" value="';
    echo $txt['3'];
    echo '"></td></tr>';
    $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $r_connect);
    mysql_query("SET NAMES '$encoding'");
    $rip = 'no';
    $res = mysql_query("SELECT `ip` FROM `ip_banned` WHERE `ip`='" . $_SERVER['REMOTE_ADDR']
            . "' LIMIT 1");
    if (mysql_num_rows($res) == 1)
        {
        $row = mysql_fetch_assoc($res);
        $rip = $row['ip'];
        }
    if ($rip != $_SERVER['REMOTE_ADDR'])
        {
        echo '<tr><td height="30" colspan="2" align="left" valign="middle">
           <img src="images/admin.png" align="absmiddle"/>&nbsp;&nbsp;&nbsp;<a href="index.php?modul=reg">'
        . $txt['4'] . '</a></td></tr>';
        if (($PassRemember == 1) AND ($mail_method != 'test'))
            {
            echo '<tr><td height="30" colspan="2" align="left" valign="middle">
           <img src="images/letter.png" align="absmiddle"/>&nbsp;&nbsp;&nbsp;<a href="index.php?modul=remember">'
            . $txt['5'] . '</a></td></tr>';
            }
        }
    echo '</table></form>';
    }
else
    echo $txt['14'];
?>