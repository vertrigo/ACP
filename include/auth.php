<?php

// proverka na AutoBAN
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
$query = 'DELETE FROM `login_failed` WHERE UNIX_TIMESTAMP(`login_time`) < UNIX_TIMESTAMP()-60*' . $AutoBanTime . '';
mysql_query($query);
$query = 'SELECT * FROM `login_failed` WHERE `ip` = "' . $_SERVER['REMOTE_ADDR'] . '"';
$d = '&copy;&nbsp;Kot&nbsp;DaW' . 'IN' . 'chi&nbsp;' . date('Y') . '&nbsp;';
$login_access = mysql_query($query);
$login_count = mysql_num_rows($login_access);
if ($login_count < $AutoBanCount)
    $Block_login = 1;
else
    $Block_login = 0;
//================
// Proverka kcaptchi
$CapchaInput = 1;
if ($KcaptchaEnable == 1)
    {
    if (isset($_SESSION['captcha_keystring']) AND isset($_POST['kapcha_code']) AND
            (strtolower($_SESSION['captcha_keystring']) == strtolower($_POST['kapcha_code'])))
        {
        $CapchaInput = 1;
        }
    else
        $CapchaInput = 0;
    }
if ($KcaptchaEnable == 2)
    {
    if ($login_count == 0)
        {
        $CapchaInput = 1;
        } else
        {
        if (isset($_SESSION['captcha_keystring']) AND isset($_POST['kapcha_code']) AND
                (strtolower($_SESSION['captcha_keystring']) == strtolower($_POST['kapcha_code'])))
            {
            $CapchaInput = 1;
            }
        else
            $CapchaInput = 0;
        }
    }
//================
if ($ServerSystem == 1)
    $online = 'online';
else
    $online = 'active_realm_id';
//================
if (isset($_POST['auth_name']))
    {
    $par = SHA1(strtoupper(addslashes($_POST['auth_name']) . ':' . addslashes($_POST['auth_pass'])));
    $cont = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $cont);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_query('SELECT * FROM `account` WHERE `username`="' . strtoupper(addslashes($_POST['auth_name'])) . '" AND sha_pass_hash ="' . $par . '"');
    if ((mysql_num_rows($res) == 1) AND ($Block_login == 1) AND ($CapchaInput == 1))
        {
        $row = mysql_fetch_assoc($res);
        $_SESSION['user_id'] = (int) $row['id'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['kito'] = strtoupper($_POST['auth_name']);
        $_SESSION['slovo'] = strtoupper($par);
        $_SESSION['modul'] = 'news';
        $_SESSION['acpskin'] = $acpskin;
        $_SESSION['realmd'] = 1;
        unset($_SESSION['captcha_keystring']);
        if ($ServerSystem == 1)
            {
            $rest = mysql_query('SELECT `gmlevel` FROM `account_access` WHERE `id`="' . $_SESSION['user_id'] . '" ORDER BY `gmlevel` DESC LIMIT 1');
            if (mysql_num_rows($rest) == 1)
                {
                $rowt = mysql_fetch_assoc($rest);
                $_SESSION['gnom'] = (int) $rowt['gmlevel'];
                }
            else
                $_SESSION['gnom'] = 0;
            }
        else
            $_SESSION['gnom'] = (int) $row['gmlevel'];
        // Clear login_failed for this IP.
        $query = 'DELETE FROM `login_failed` WHERE `ip` = "' . $_SERVER['REMOTE_ADDR'] . '"';
        mysql_select_db($k_db, $k_connect);
        mysql_query($query);
        }
    else if ($Block_login == 1)
        {
        $query = 'insert `login_failed` (`ip`) VALUES ("' . $_SERVER['REMOTE_ADDR'] . '")';
        mysql_select_db($k_db, $k_connect);
        mysql_query($query);
        }
    header("Location: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit;
    }
if (isset($_GET['action']) AND $_GET['action'] == "logout")
    {
    session_destroy();
    header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
    exit;
    }
?>