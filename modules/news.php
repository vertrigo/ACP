<?php

$kol = 1;
$Mwhr = ' WHERE `status` = 0 ';
if (isset($_SESSION['gnom']))
    $Mwhr = ' WHERE `status` < 2 ';
if ((isset($_SESSION['gnom'])) AND ($_SESSION['gnom'] > 1))
    $Mwhr = '';
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '$encoding'");
$cres = mysql_query("SELECT count(`date`) as kol FROM `news` " . $Mwhr) or trigger_error(mysql_error());
$kolzap = mysql_fetch_array($cres);
if ($kolzap['kol'] > $PageNews)
    {
    $PageLen = $PageNews;
    if (!isset($_GET['page']) or ($_GET['page'] == ''))
        $StartRec = 0;
    else
        $StartRec = ((int) $_GET['page'] - 1) * $PageNews;
    }
else
    {
    $PageLen = $kolzap['kol'];
    $StartRec = 0;
    }
$kres = mysql_query("SELECT `date`,`title`,`text`,`status` FROM `news` " . $Mwhr . " ORDER BY `date` DESC limit " . $StartRec . "," . $PageLen) or trigger_error(mysql_error());
if (mysql_num_rows($kres) > 0)
    {
    echo '<table width="90%" border="0" cellspacing="0" cellpadding="5">';
    while ($nres = mysql_fetch_array($kres))
        {
        echo '<tr><td align="left" class="NewsLogo">';
        if ($nres['status'] == 2)
            echo '<img src="images/no.png" align="absmiddle">';
        elseif ($nres['status'] == 1)
            echo '<img src="images/yes.png" align="absmiddle">';
        else
            echo '<img src="images/admin.png" align="absmiddle">';
        echo '</td>';
        echo '<td align="left" class="';
        if ($nres['status'] == 2)
            echo 'NewsTitleGM';
        elseif ($nres['status'] == 1)
            echo 'NewsTitlePlayer';
        else
            echo 'NewsTitleAll';
        echo '">' . $nres['title'] . '&nbsp;</td>';
        echo '<td align="right" class="NewsDate">' . $nres['date'] . '</td>';
        echo '</tr>';
        echo '<tr><td colspan=3 class="NewsContent">' . $nres['text'] . '</td></tr>';
        echo '<tr><td align="left" valign="top" height=30 colspan=3 class="NewsDate">(' . $txt[173 + $nres['status']] . ')</td></tr>';
        $kol++;
        }

    if ($kolzap['kol'] > $PageNews)
        {
        $PageCounter = ceil($kolzap['kol'] / $PageNews);
        if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
            $tp3 = 1;
        else
            $tp3 = (int) $_GET['page'];
        echo '<tr><td height="30" colspan="3" align="center" valign="middle" >' . ShowPageNavigator('index.php?modul=news&page=', $tp3, $PageCounter) . '</td></tr>';
        }
    echo '</table>';
    }
?>