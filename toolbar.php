<?php

if (!isset($r_ip) or ($r_ip == ''))
    {
    return;
    }
echo '<table width="99%" border="0" cellpadding="10" cellspacing="0">'
 . '<tr><td align="left" valign="middle" class="LogoutText">';

if (isset($_SESSION['modul']))
    {
    getSkinList($SkinChange);
    }
echo ' <img src="images/tree.gif" border=0  align="absmiddle" alt="IP"> ';
echo 'IP: ';
echo $_SERVER['REMOTE_ADDR'];
echo '</td>';
echo '<td align="right" valign="middle" class="LogoutText">';
if ($OtherLink <> '')
    echo $OtherLink;
$toolbarString = '';
if (isset($_SESSION['modul']) AND ($_SESSION['modul'] != 'news'))
    $toolbarString = '<a href="index.php">' . $txt['12'] . '</a>';
if (!isset($_SESSION['modul']) AND isset($_GET['modul']) AND ($_GET['modul'] != 'news'))
    {
    if ($toolbarString != '')
        $toolbarString .= ' | ';
    $toolbarString .= '<a href="index.php">' . $txt['12'] . '</a>';
    }
echo $toolbarString;
if (isset($_SESSION['modul']))
    {
    if ($toolbarString != '')
        echo ' | ';
    echo '<a href="logout.php">' . $txt['13'] . '</a>';
    }
echo '</td></tr></table>';
?>