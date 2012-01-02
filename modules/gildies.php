<?php

$kol = 1;
$c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
mysql_select_db($c_db, $c_connect);
mysql_query("SET NAMES '$encoding'");
$ares = mysql_query("select count(`guildid`) as kol from `guild`") or trigger_error(mysql_error());
$kolzap = mysql_fetch_array($ares);
if ($kolzap['kol'] > $PageOnline)
    {
    $PageLen = $PageOnline;
    if (!isset($_GET['page']) or ($_GET['page'] == ''))
        $StartRec = 0;
    else
        $StartRec = ((int) $_GET['page'] - 1) * $PageOnline;
    }
else
    {
    $PageLen = $kolzap['kol'];
    $StartRec = 0;
    }
$res = mysql_query("select `guildid`,`guild`.`name`,`leaderguid`,`info`,`createdate`,`characters`.`name` as leader,`characters`.`race` as race  from `guild`,`characters` where `characters`.`guid` = `guild`.`leaderguid` order by `guild`.`name` limit " . $StartRec . "," . $PageLen) or trigger_error(mysql_error());
if (mysql_num_rows($res) > 0)
    {
    echo '<table width="560" border="0" cellspacing="0" cellpadding="2"><tr>';
    echo '<td height="25" colspan="5" align="right" valign="bottom">' . $txt[245] . $kolzap['kol'] . '</td></tr>';
    echo '<td height="25" colspan="5" align="center" valign="middle" class="TableTitle"><b>' . $txt[223] . '</b></td></tr>';
    echo '<tr>';
    echo '<td width="40" align="center" valign="middle" class="TableOther">' . $txt[227] . '</td>';
    echo '<td width="250" align="left" valign="middle" class="TableOther">' . $txt[224] . '</td>';
    echo '<td width="160" align="left" valign="middle" class="TableOther">' . $txt[225] . '</td>';
    echo '<td width="180" align ="left" valign="middle" class="TableOther">' . $txt[226] . '</td>';
    echo '<td width="30" align ="center" valign="middle" class="TableOther"> </td>';
    echo '</tr>';
    if (isset($_GET['page']))
        $tp4 = (int) $_GET['page'];
    else
        $tp4 = 1;
    if (isset($_GET['show']))
        $_GET['show'] = (int) $_GET['show'];
    while ($cres = mysql_fetch_array($res))
        {
        echo '<tr>';
        echo '<td width="40"  height="40" align="center" valign="middle" class="TableLeft"  >' . ($kol + $StartRec) . '<a name="G' . $cres['guildid'] . '"></a></td>';
        echo '<td width="250" height="40" align="left"   valign="middle" class="TableCenter">';
        if (isset($_GET['show']) AND ($_GET['show'] == $cres['guildid']))
            echo '<a href="index.php?modul=gilds&page=' . $tp4 . '#G' . $cres['guildid'] . '">' . $cres['name'] . '</a>';
        else
            echo '<a href="index.php?modul=gilds&page=' . $tp4 . '&show=' . $cres['guildid'] . '#G' . $cres['guildid'] . '">' . $cres['name'] . '</a>';
        echo '</td>';
        echo '<td width="160" height="40" align="left"   valign="middle" class="TableCenter">' . date("d-m-Y H:i", $cres['createdate']) . '</td>';
//           echo '<td width="160" height="40" align="left"   valign="middle" class="TableCenter">'.$cres['createdate'].'</td>';
        echo '<td width="180" height="40" align="left"   valign="middle" class="TableCenter" >';
        if ($charview == '')
            echo $cres['leader'];
        else
            echo '<a href="' . $charview . $cres['leaderguid'] . '" target="_blank">' . $cres['leader'] . '<a>';
        echo '</td>';
        echo '<td width="30 " height="40" align="left"   valign="middle" class="TableRight" >';
        if ($gildview == '')
            echo ' ';
        else
            echo '<a href="' . $gildview . $cres['guildid'] . '" target="_blank"><img src="images/question.png" border=0 align="absmiddle" alt="Info"></a>';
        echo '</td></tr>';
        if (isset($_GET['show']) AND ($_GET['show'] == $cres['guildid']))
            {
            if ($ActiveGuildChar > 0)
                $GildLimit = ' limit 0,' . $ActiveGuildChar;
            else
                $GildLimit = '';
            $ares = mysql_query("select `guid` from `guild_member` where `guildid`=" . $cres['guildid']) or trigger_error(mysql_error());
            $gres = mysql_query("select `guid`,`name`,`race`,`class`,`gender`,`level` from characters where guid in (select `guid` from `guild_member` where `guildid`="
                    . $cres['guildid'] . ") order by `level` DESC, `guid`" . $GildLimit) or trigger_error(mysql_error());
            echo '<tr>';
            echo '<td width="40"  height="40" align="center" valign="top" class="TableLeft"  ><br>';
            if (($cres['race'] == 1) or ($cres['race'] == 3) or ($cres['race'] == 4) or ($cres['race'] == 7) or ($cres['race'] == 11))
                echo "<img src='images/alliance.gif' align='absmiddle' alt='Alliance' border='0'>"; //Alliance
            else
                echo "<img src='images/horde.gif' align='absmiddle' alt='Horde' border='0'>"; //Horde
            echo '</td>';
            echo '<td colspan=2   height="40" align="left"   valign="top" class="TableCenter"><br><b>';
            echo $txt[230] . '</b> ' . (mysql_num_rows($ares)) . '<br><br><b>';
            echo $txt[231] . '</b><br>' . $cres['info'] . '<br><br></td>';
            echo '<td colspan=2   height="40" align="left"   valign="top" class="TableRight" ><br>';
            if (($ActiveGuildChar > 0) AND (mysql_num_rows($ares) > $ActiveGuildChar))
                {
                echo $txt[246];
                echo $ActiveGuildChar;
                echo ':<br>';
                }
            while ($ggres = mysql_fetch_array($gres))
                {
                echo "<img src='images/race/" . $ggres['race'] . "-" . $ggres['gender'] . ".gif' align='absmiddle'> ";
                echo "<img src='images/class/" . $ggres['class'] . ".gif' align='absmiddle'> - ";
                if ($charview == '')
                    echo $ggres['name'];
                else
                    echo '<a href="' . $charview . $ggres['guid'] . '" target="_blank">' . $ggres['name'] . '<a>';
                echo ' (' . $ggres['level'] . ')<br>';
                }
            echo '<br></td></tr>';
            }
        $kol++;
        }
    if ($kolzap['kol'] > $PageOnline)
        {
        $PageCounter = ceil($kolzap['kol'] / $PageOnline);
        if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
            $tp3 = 1;
        else
            $tp3 = (int) $_GET['page'];
        echo '<tr><td height="40" colspan="5" align="center" valign="middle" >' . ShowPageNavigator('index.php?modul=gilds&page=', $tp3, $PageCounter) . '</td></tr>';
        }
    echo '</table>';
    }
else
    echo $txt[228];
?>
