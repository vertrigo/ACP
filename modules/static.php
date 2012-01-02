<?php

if (isset($_GET['id']) and ($_GET['id'] > 0))
    {
    $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
    mysql_select_db($k_db, $k_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_query("SELECT * FROM `static` where `id` = " . $_GET['id'] . " limit 1");
    if (mysql_num_rows($res) > 0)
        {
        $nres = mysql_fetch_array($res);
        echo '<table width="90%" border="0" cellspacing="0" cellpadding="5">';
        echo '<tr><td align="left" class="NewsLogo">';
        if ($nres['type'] == 2)
            echo '<img src="images/no.png" align="absmiddle">';
        elseif ($nres['type'] == 1)
            echo '<img src="images/yes.png" align="absmiddle">';
        else
            echo '<img src="images/admin.png" align="absmiddle">';
        echo '</td>';
        echo '<td align="left" class="';
        if ($nres['type'] == 2)
            echo 'NewsTitleGM';
        elseif ($nres['type'] == 1)
            echo 'NewsTitlePlayer';
        else
            echo 'NewsTitleAll';
        echo '">' . $nres['title'] . '&nbsp;</td>';
        echo '<td align="right" class="NewsDate">' . $nres['date'] . '</td>';
        echo '</tr>';
        echo '<tr><td colspan=3 class="NewsContent">' . $nres['text'] . '</td></tr>';
        echo '</table>';
        }
    else
        echo $txt['234'];
    }
else
    {
    echo $txt['234'];
}
?>