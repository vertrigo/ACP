<?php

if (!isset($r_ip) or ($r_ip == ''))
    {
    return;
    }
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_query("SELECT `id`, `menutitle` FROM `static` order by `menutitle`");
if (mysql_num_rows($res) > 0)
    {
    switch ($RulesView):
        case 1:
            echo '<select size="1" name="id" onchange="'
            . "document.location.href='index.php?modul=static&id='+this.value;" . '">';
            echo '<option value="0" selected>' . $txt[235] . '</option>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<option value="' . $nres['id'] . '">' . $nres['menutitle'] . '</option>';
                }
            echo "</select>";
            break;
        default:
            echo '<table border="0" cellspacing="8" cellpadding="0">';
            echo '<tr><td align="top" valign="top"><b>' . $txt[235] . '</b>&nbsp;</td></tr>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<tr><td align="center" valign="middle"><a href="index.php?modul=static&id='
                . $nres['id'] . '">' . $nres['menutitle'] . '</a></td></tr>';
                }
            echo '</table>';
            break;
    endswitch;
    }
?>