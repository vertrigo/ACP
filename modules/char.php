<?php

if (isset($_GET['char_view_cmd']))
    $cv_cmd = addslashes($_GET['char_view_cmd']);
else
    $cv_cmd = '#';

if (isset($_GET['mail_view_page']))
    $mail_page = (int) $_GET['mail_view_page'];
else
    $mail_page = 1;

if (isset($_GET['mail_show_id']))
    $mail_show = (int) $_GET['mail_show_id'];
else
    $mail_show = 0;

$mpg = 1;
if (isset($SESSION['mail_page']) AND ((int) $SESSION['mail_page'] > 0))
    $mpg = (int) $SESSION['mail_page'];

if (isset($_GET['id']) AND ($_GET['id'] > 0) and ($_SESSION['user_id'] > 0))
    {
    echo '<table width="560" border="0" cellspacing="5" cellpadding="0"><tr><td height="25" colspan="4" align="center" valign="middle" class="TableTitle"><b>' . $txt[23] . '</b></td></tr>';
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_query("SELECT `name`, `class`, `guid`, `race`, `online`, `gender`, `level`, `money` FROM `characters` WHERE (`guid` = "
            . (int) $_GET['id'] . ") and (`account` = " . (int) $_SESSION['user_id'] . ") AND (`online` = 0) LIMIT 1");
    if (mysql_num_rows($res) != 1)
        {
        echo '<tr><td height="25" colspan="4" align="center" valign="middle" ><b>'
        . $txt[24] . '</b></td></tr></table>';
        return;
        } else
        {
        $cres = mysql_fetch_array($res);
        echo '<tr><td width="40" align="center" valign="middle"><img src="images/yes.png" align="absmiddle"></td>';
        echo '<td width="240" align="left" valign="middle"><img src="images/race/' . $cres['race'] . '-' . $cres['gender'] . '.png" align="absmiddle">';
        echo '<img src="images/class/' . $cres['class'] . '.png" align="absmiddle"> ';
        $tekname = $cres['name'];
        $TekCharClass = $cres['class'];
        if ($charview == '')
            echo $cres['name'] . '</td>';
        else
            echo '<a href="' . $charview . $cres['guid'] . '" target="_blank">' . $cres['name'] . '</a></td>';
        echo '<td  width="80" align="center" valign="middle">' . $cres['level'] . ' lvl</td><td width="200" align ="right" valign="middle">'
        . getGold($cres['money']);
        $money = $cres['money'];
        echo '</td></tr></table><br><hr><form method="POST"><input name="modul" value="charedit" type=hidden>';
        echo '<input name="character" value="' . (int) $_GET['id'] . '" type=hidden><table width="500" border="0" cellspacing="0" cellpadding="0"><tr>';
        echo '<td width="50" height="30" align="center" valign="middle"><input name=id type=radio value="1" checked ></td><td width="300" height="30" align="left" valign="middle">'
        . $txt[26] . '</td>';
        echo '<td width="150" height="30" align="right" valign="middle">' . $txt[25] . '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Rename_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='2'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[27] 
        . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Rename_price);
        echo '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Relocate_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='3'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[28] 
        . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Relocate_price);
        echo '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Teleport_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='4'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[29] . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Teleport_price);

        echo '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Gender_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='5'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[233] . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Gender_price);

        echo '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Custom_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='6'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[259] . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Custom_price);

        echo '</td></tr><tr><td width="50" height="30" align="center" valign="middle">';
        if (($money >= $Talant_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
            echo "<input name=id type=radio value='7'>";
        else
            echo "<img src='images/no.png' align='absmiddle'> ";
        echo '</td><td width="300" height="30" align="left" valign="middle">' . $txt[261] . '</td><td width="150" height="30" align="right" valign="middle">';
        if ($_SESSION['gnom'] >= $gm_free_pay)
            echo $txt[25];
        else
            echo getGold($Talant_price);

        echo '</td></tr></table>';
        echo '<br><div align="center"><input type="submit" value="' . $txt[11] . '"></div></form>';
        //-----------------------------
        echo '<hr><br><table width="560" height="30" border="0" cellspacing="5" cellpadding="0"><tr><td align="center" valign="middle">';

        if ($WriteBagreport == 1)
            echo ' <input type="button" value="' . $txt[149] .
            '" onclick="document.location.href=' . "'index.php?modul=char&char_view_cmd=bagreport&id="
            . (int) $_GET['id'] . "'" . ';"> ';
        $resml = mysql_query("SELECT * FROM `mail` WHERE (`sender` = " . (int) $_GET['id'] . ") OR (`receiver` = "
                . (int) $_GET['id'] . ") AND (`deliver_time` <= UNIX_TIMESTAMP()) ORDER BY `deliver_time` DESC");
        if (mysql_num_rows($resml) > 0)
            echo ' <input type="button" value="' . $txt[299] .
            '" onclick="document.location.href=' . "'index.php?modul=char&char_view_cmd=mail&id="
            . (int) $_GET['id'] . "'" . ';"> ';

        $restkt = mysql_query("SELECT * FROM `character_ticket` WHERE (`guid` = " . (int) $_GET['id'] . ")");
        if (mysql_num_rows($restkt) > 0)
            echo ' <input type="button" value="' . $txt[300] .
            '" onclick="document.location.href=' . "'index.php?modul=char&char_view_cmd=ticket&id="
            . (int) $_GET['id'] . "'" . ';"> ';


        echo '</td></tr></table>';
        //-----------------------------
        if (($WriteBagreport == 1) AND ($cv_cmd == 'bagreport'))
            {
            require("include/edit.php");
            echo $edit_script;
            echo '<form method="post"><br><hr><table width="560" border="0" cellspacing="0" cellpadding="10"><tr><td align="center"><h1>'
            . $txt[149] . '</h1></td></tr>';
            echo '<tr><td align="center" class="NewsContent">' . $txt[171] . '<br></td></tr><tr><td align="center" class="NewsContent"><div align="center"><br>';
            echo '<table width="490" border="0" cellspacing="0" cellpadding="0"><tr>';
            echo '<td width="80" height="30" align="right" valign="middle">' . $txt[145] . '</td>';
            echo '<td width="10" height="30" >&nbsp;</td>';
            echo '<td width="400" height="30" align="left" valign="middle">';
            echo '<input name="modul" value="bagtrack" type=hidden>';
            echo '<input name="cmd" value="add" type=hidden><input name="charid" value="' . (int) $_GET['id'] . '" type=hidden>';
            echo '<input name="charname" value="' . $tekname . '" type=hidden><input type="text" name="tema" size="60"></td></tr><tr>';
            echo '<td width="80" height="30" align="right" valign="middle">' . $txt[146] . '</td><td width="10" height="30" >&nbsp;</td>';
            echo '<td width="400" height="30" align="left" valign="middle"><select name=kategor><option value=0> </option>';
            for ($i = 1; $i <= 10; $i++)
                {
                echo '<option value=' . $i;
                if (isset($_GET['kategor']) AND ($_GET['kategor'] == $i))
                    echo ' selected>';
                else
                    echo '>';
                echo $txt[$i + 150] . '</option>';
                }
            echo '</select></td></tr></table><textarea name="report" style="width:480"></textarea><br>';
            echo '<input type="submit" value="' . $txt[150] . '"></form><br></div></td></tr></table>';
            }
        if (($cv_cmd == 'mail') AND (mysql_num_rows($resml) > 0))
            {
            // ===
            echo '<br><table width="500" border="0" cellspacing="0" cellpadding="8"><tr><td height="25" colspan="2" align="center" valign="middle" class="TableTitle">'
            . '<img src="images/mail1.png" align="absmiddle" border="0"></td><td height="25" colspan="2" align="center" valign="middle" class="TableTitle">'
            . $txt[302] . '</td></tr>';
            while ($rmail = mysql_fetch_array($resml))
                {
                echo '<tr><td width="35" align="center" valign="middle" class="TableLeft">';
                echo '<a name="m' . $rmail['id'] . '" href="index.php?modul=char&char_view_cmd=mail&id='
                . (int) $_GET['id'] . '&show=' . $rmail['id'] . '&mpg=' . $mpg . '#m' . $rmail['id'] . '" target = "_self" title="';
                if (($rmail['receiver'] == (int) $_GET['id']) AND ($rmail['stationery'] == 61))
                    {
                    echo $txt[305] . '">';
                    echo '<img src="images/gm.png" align="absmiddle">';
                    } elseif ($rmail['receiver'] == (int) $_GET['id'])
                    {
                    echo $txt[303] . '">';
                    echo '<img src="images/mail_receive.png" align="absmiddle">';
                    } else
                    {
                    echo $txt[304] . '">';
                    echo '<img src="images/mail_send.png" align="absmiddle">';
                    }
                echo '</a></td>';

                echo '<td width="115"  align="center" valign="middle" class="TableCenter">';
                if ($rmail['checked'] == 0)
                    echo '<b>';
                echo date("d-m-Y H:i", $rmail['deliver_time']) . '</td>';
                if ($rmail['checked'] == 0)
                    echo '</b>';

                echo '<td width="300"  align="justify" valign="middle" class="TableCenter">';
                echo '<a name="m' . $rmail['id'] . '" href="index.php?modul=char&char_view_cmd=mail&id='
                . (int) $_GET['id'] . '&show=' . $rmail['id'] . '&mpg=' . $mpg . '#m' . $rmail['id'] . '" target = "_self">';
                echo $rmail['subject'] . '</a></td>';

                echo '<td width="50" class="TableRight">';
                if (($rmail['stationery'] == 1) OR ($rmail['cod'] > 0))
                    {
                    echo $txt[307];
                    }
                if ($rmail['stationery'] == 62)
                    {
                    if (($rmail['stationery'] == 1) OR ($rmail['cod'] > 0))
                        echo '<br>';
                    echo $txt[308];
                    }
                if ($rmail['stationery'] == 61)
                    {
                    if (($rmail['stationery'] == 1) OR ($rmail['cod'] > 0))
                        echo '<br>';
                    echo $txt[305];
                    }

                echo '&nbsp;</td>';

                echo '</tr>';

                if (isset($_GET['show']) AND ((int) $_GET['show'] == $rmail['id']))
                    {
                    echo '<tr><td align="left" valign="top" colspan="2" class="TableLeft">';
                    if ($rmail['messageType'] == 0)
                        {
                        if ($rmail['sender'] == (int) $_GET['id'])
                            {
                            $res3 = mysql_query("SELECT `name`, `class`, `guid`, `race`,`gender`, `level` FROM `characters` WHERE `guid` = "
                                    . $rmail['receiver'] . "  LIMIT 1");
                            if (mysql_num_rows($res3) == 1)
                                {
                                $resm2 = mysql_fetch_array($res3);
                                echo $txt[310] . '<br><b>';
                                if ($charview == '')
                                    echo $resm2['name'];
                                else
                                    echo '<a href="' . $charview . $resm2['guid'] . '" target="_blank">' . $resm2['name'] . '</a>';
                                echo '</b>&nbsp;(' . (int) $resm2['level'] . 'lvl.)<br>';
                                echo '<img src="images/race/' . $resm2['race'] . '-' . $resm2['gender'] . '.png" align="absmiddle">'
                                . '<img src="images/class/' . $resm2['class'] . '.png" align="absmiddle"> ';
                                }
                            } else
                            {
                            $res3 = mysql_query("SELECT `name`, `class`, `guid`, `race`,`gender`, `level` "
                                    ."FROM `characters` WHERE `guid` = ". $rmail['sender'] . "  LIMIT 1");
                            if (mysql_num_rows($res3) == 1)
                                {
                                $resm2 = mysql_fetch_array($res3);
                                echo $txt[309] . '<br><b>';
                                if ($charview == '')
                                    echo $resm2['name'];
                                else
                                    echo '<a href="' . $charview . $resm2['guid'] . '" target="_blank">' . $resm2['name'] . '</a>';
                                echo '</b>&nbsp;(' . (int) $resm2['level'] . 'lvl.)<br>';
                                echo '<img src="images/race/' . $resm2['race'] . '-' . $resm2['gender'] . '.png" align="absmiddle">'
                                . '<img src="images/class/' . $resm2['class'] . '.png" align="absmiddle"> ';
                                }
                            }
                        }
                    if ($rmail['messageType'] == 3)
                        {
                        $m_connect = mysql_connect($m_ip, $m_userdb, $m_pw);
                        mysql_select_db($m_db, $m_connect);
                        mysql_query("SET NAMES '$encoding'");
                        $res3 = mysql_query("SELECT `creature_template`.`entry`,"
                                ."`creature_template`.`name`,`creature_template`.`subname`,`locales_creature`.`name_loc8`,"
                                ."`locales_creature`.`subname_loc8` FROM `creature_template` LEFT JOIN `locales_creature` "
                                ."ON `creature_template`.`entry`= `locales_creature`.`entry` "
                                ."WHERE `creature_template`.`entry` ="
                                . $rmail['sender'] . "  LIMIT 1");
                        if (mysql_num_rows($res3) == 1)
                            {
                            $resm2 = mysql_fetch_array($res3);
                            if ($resm2['name_loc8'] <> '')
                                $MobName = $resm2['name_loc8'];
                            else
                                $MobName = $resm2['name'];
                            if ($resm2['subname_loc8'] <> '')
                                $MobSubName = $resm2['subname_loc8'];
                            else
                                $MobSubName = $resm2['subname'];
                            echo $txt[311] . '<br><b>';
                                if ($npcview == '')
                                    echo $MobName;
                                else
                                    echo '<a href="' . $npcview . $resm2['entry'] . '" target="_blank">' . $MobName . '</a>';
                            echo '</b><br>';
                            if ($MobSubName <> '')
                                echo '(' . $MobSubName . ')';
                            }
                        mysql_select_db($c_db, $c_connect);
                        mysql_query("SET NAMES '$encoding'");
                        }

                    echo '</td>';
                    echo '<td align="justify" valign="top" colspan="2" class="TableRight">';
                    echo nl2br($rmail['body']);
                    if ($rmail['money'] > 0)
                        {
                        echo '<hr>' . $txt[313];
                        echo getGold($rmail['money']);
                        }
                    if (($rmail['stationery'] == 1) OR ($rmail['cod'] > 0))
                        {
                        echo '<hr>' . $txt[312];
                        echo getGold($rmail['cod']);
                        }
                    if ($rmail['has_items'] == 1)
                        {
                        echo '<hr>' . $txt[314];
                        $res4 = mysql_query("SELECT `item_template` FROM `mail_items` WHERE `mail_id`="
                                . $rmail['id']
                                . " ORDER BY `item_template`");
                        if (mysql_num_rows($res4) > 0)
                            {
                            $in_str = '(';
                            while ($res5 = mysql_fetch_array($res4))
                                {
                                if ($in_str != '(')
                                    $in_str = $in_str . ',';
                                $in_str = $in_str . $res5['item_template'];
                                }
                            $in_str = $in_str . ')';
                            $m_connect = mysql_connect($m_ip, $m_userdb, $m_pw);
                            mysql_select_db($m_db, $m_connect);
                            mysql_query("SET NAMES '$encoding'");
                            $res6 = mysql_query("SELECT `item_template`.`name`,`locales_item`.`name_loc8` "
                                    ."FROM `item_template` "
                                    . "LEFT JOIN `locales_item` "
                                    ."ON `item_template`.`entry` =`locales_item`.`entry` "
                                    . "WHERE `item_template`.`entry` IN " . $in_str);
                            if (mysql_num_rows($res6) > 0)
                                {
                                while ($res7 = mysql_fetch_array($res6))
                                    {
                                    echo '<br>';
                                    if ($res7['name_loc8'] <> '')
                                        echo $res7['name_loc8'];
                                    else
                                        echo $res7['name'];
                                    }
                                }
                            mysql_select_db($c_db, $c_connect);
                            mysql_query("SET NAMES '$encoding'");
                            }
                        }
                    echo '</td>';
                    echo '</tr>';
                    }
                }
            echo '</table>';
            }
        if (($cv_cmd == 'ticket') AND (mysql_num_rows($restkt) > 0))
            {
            // ===
            echo '<br><table width="500" border="0" cellspacing="0" cellpadding="8">';
            echo '<tr><td height="25" colspan="4" align="center" valign="middle" class="TableTitle">'
            . $txt[179] . '</td></tr>';
            while ($restk2 = mysql_fetch_array($restkt))
                {
                echo '<tr><td width="30" align="center" valign="middle" class="TableLeft">';
                echo '<img src="images/letter.png" align="absmiddle"></td>';
                echo '<td width="135" align="left"  valign="middle" class="TableRight"><b>'
                . $restk2['ticket_lastchange'] . '</b></td>';
                echo '<td width="320"  align="justify" valign="middle" class="TableCenter">';
                echo $restk2['ticket_text'] . '</td>'
                . '<td width="5" class="TableRight">&nbsp;</td>'
                . '</tr>';
                if ($restk2['response_text'] <> '')
                    {
                    echo '<tr><td width="30" align="center" valign="middle" class="TableLeft">';
                    echo '<img src="images/admin.png" align="absmiddle"></td>';
                    echo '<td width="135" align="left"  valign="middle" class="TableRight">' 
                    . $txt[301] . '</td>';
                    echo '<td width="320"  align="justify" valign="middle" class="TableCenter">';
                    echo $restk2['response_text'] . '</td>'
                    . '<td width="5" class="TableRight">&nbsp;</td>'
                    . '</tr>';
                    }
                }
            echo '</table>';
            }
        }
    }
else
    echo $txt[138];
?>