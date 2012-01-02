<?php

if ($_SESSION['gnom'] > 1)
    {
    echo '<br><table width="500" border="0" cellspacing="0" cellpadding="0">'
    . '<tr><td height="25" colspan="4" align="center" valign="middle" class="TableTitle">'
    . $txt['179'] . '</td></tr>';
    $kol = 1;
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $query = "SELECT `character_ticket`.*, `characters`.`name`, `characters`.`level` "
            . "FROM `character_ticket`, `characters` WHERE `character_ticket`.`guid` = `characters`.`guid` "
            . "ORDER BY `ticket_lastchange` DESC";
    $res = mysql_query($query) or trigger_error(mysql_error());
    while ($tres = mysql_fetch_array($res))
        {
        echo '<tr><td width="40" align="center" valign="middle" class="TableLeft">'
        . '<img src="images/yes.png" align="absmiddle"></td>';
        echo '<td width="320"  align="justify" valign="middle" class="TableCenter"><br>';
        echo $tres['ticket_text'] . '<br><br></td>';
        echo '<td width="135" align="right"  valign="middle" class="TableCenter"><b>'
        . $tres['name'] . '</b> (' . $tres['level'] . 'lvl)<br><b>' . $tres['ticket_lastchange']
        . '</b></td>
	 <td width="5" class="TableRight">&nbsp;</td></tr>';
        $kol++;
        }
    if ($kol == 1)
        {
        echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>'
        . $txt['141'] . '</b></td></tr>';
        }
    echo '</table>';
    } else
    {
    echo $txt['138'];
    }
?>
