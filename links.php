<?php

if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] > 0))
    $LinkRang = $_SESSION['gnom'];
else
    $LinkRang = 0;
if (!isset($r_ip) or ($r_ip == ''))
    {
    return;
    }
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '$encoding'");
$res = mysql_query("SELECT * FROM `links` WHERE `gmlevel` <= " . $LinkRang . " ORDER BY `linkname`");
if (mysql_num_rows($res) > 0)
    {
    switch ($LinkView):
        case 1000: // не работает пока. :(
            echo "<br><br><select size=\"1\" name=\"id\" onchange=\"document.location.href='"
            . htmlspecialchars($nres['linkstr'], ENT_QUOTES) . "';\">";
            echo '<option value="0" selected>' . $txt['253'] . '</option>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<option value="' . (int) $nres['id'] . '">'
                . htmlspecialchars($nres['linkname'], ENT_QUOTES) . '</option>';
                }
            echo "</select>";
            break;
        case 1:
            echo '<table width="100%" border="0" cellspacing="8" cellpadding="0">';
            echo '<tr><td align="center" valign="top"><b>' . $txt['253'] . '</b>&nbsp;</td></tr>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<tr><td align="center" valign="middle"><a href="'
                . htmlspecialchars($nres['linkstr'], ENT_QUOTES) . '" target=_blank>';
                echo '<img src="' . $nres['image'] . '" border=0>';
                if (isset($LinkImageCaption) and ($LinkImageCaption == 1))
                    {
                    echo '<br>' . $nres['linkname'];
                    }
                echo '</a></td></tr>';
                }
            echo '</table>';
            break;
        case 2:
            echo '<table width="100%" border="0" cellspacing="8" cellpadding="0">';
            echo '<tr>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<td align="center" valign="middle"><a href="'
                . htmlspecialchars($nres['linkstr'], ENT_QUOTES) . '" target=_blank>';
                echo '<img src="' . $nres['image'] . '" border=0>';
                if (isset($LinkImageCaption) and ($LinkImageCaption == 1))
                    {
                    echo '<br>' . $nres['linkname'];
                    }
                echo '</a></td>';
                }
            echo '</tr></table>';
            break;
        case 3:
            echo '<table border="0" cellspacing="3" cellpadding="0"><tr>';
            echo '<td align="center" valign="top"><b>' . $txt['253'] . ':</b>&nbsp;</td>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<td align="center" valign="middle">&nbsp;|&nbsp;&nbsp;<a href="'
                . htmlspecialchars($nres['linkstr'], ENT_QUOTES) . '" target=_blank>'
                . htmlspecialchars($nres['linkname'], ENT_QUOTES) . '</a>&nbsp;</td>';
                }
            echo '</tr></table>';

            break;
        default:
            echo '<table width="100%" border="0" cellspacing="3" cellpadding="0">';
            echo '<tr><td align="center" valign="top"><b>' . $txt['253'] . '</b>&nbsp;</td></tr>';
            while ($nres = mysql_fetch_array($res))
                {
                echo '<tr><td align="center" valign="middle"><a href="'
                . htmlspecialchars($nres['linkstr'], ENT_QUOTES) . '" target=_blank>'
                . htmlspecialchars($nres['linkname'], ENT_QUOTES) . '</a></td></tr>';
                }
            echo '</table>';
            break;
    endswitch;
    }
?>