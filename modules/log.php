<?php

if ($_SESSION['gnom'] > 1)
    {
    if (isset($_GET['erase']) AND ($_GET['erase'] == 'yes'))
        { // стираем старые записи в логе по нажатию кнопки
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '$encoding'");
        mysql_query("DELETE FROM `log` WHERE DATEDIFF(NOW(), `date`) > " . $LogDateLimit);
        }
    if (isset($_GET['tp']) && ((int)$_GET['tp'] > 0) && ((int) $_GET['tp'] < 11))
        { // выясняем, было ли ограничение по тематике. и помещаем в переменную.
        $WHR = ' WHERE `mode` = ' . (int) $_GET['tp'];  // для запроса
        $WHR_TITLE = '( ' . $txt[122 + (int) $_GET['tp']] . ' )'; // заголовок таблицы
        $TP = (int)$_GET['tp']; // в переменную...
        }
    else 
        { // если нет ограничений, то пустышки.
        $WHR = '';
        $WHR_TITLE = '';
        $TP = '_';
        } 
    if (isset($_GET['IP']) && ($_GET['IP'] <> ''))
       {
       $f1=$_GET['IP']; // Фильтр по ИП?
       if ($WHR == '')
         $WHR = ' WHERE `ip` = "'.$f1.'"';
       else
         $WHR = $WHR.' AND `ip` = "'.$f1.'"';
       }
    else $f1 = '';
    if (isset($_GET['mail']) && ($_GET['mail'] <> ''))
       {
       $f2=$_GET['mail']; // фильтр по мылу?
       if ($WHR == '')
         $WHR = ' WHERE `email` = "'.$f2.'"';
       else
         $WHR = $WHR.' AND `email` = "'.$f2.'"';
       }
    else $f2 = '';
    if (isset($_GET['acc']) && ((int)$_GET['acc'] > 0))
       {
       $f3=$_GET['acc']; // фильтр по учетке?
       if ($WHR == '')
         $WHR = ' WHERE `account` = '.$f3;
       else
         $WHR = $WHR.' AND `account` = '.$f3;
       }
    else $f3 = '';
    if (isset($_GET['char']) && ((int)$_GET['char'] > 0))
       {
       $f4=$_GET['char']; // фильтр по персу?
       if ($WHR == '')
         $WHR = ' WHERE `character` = '.$f4;
       else
         $WHR = $WHR.' AND `character` = '.$f4;
       }
    else $f4 = '';
    // Табличка
    echo '<table width="600" border="0" cellspacing="0" cellpadding="0"><tr><td height="30" colspan="4" align="right" valign="top">';
    echo "<select size=\"1\" name=\"my_menu\" onchange=\"document.location.href='index.php?modul=log&tp='+this.value;\">";
    echo '<option value="_"'; // выбор тематики
    if ($TP == '_')
        echo ' selected';
    echo '><b>' . $txt['139'] . '</b></option>';
    for ($i = 1; $i <= 10; $i++)
        {
        echo '<option value="' . $i . '"';
        if ((int)$TP == $i)
            echo ' selected';
        echo '>' . $txt[122 + $i] . '</option>';
        }
    echo "</select>\n";
    // сброс фильтров и тематики
    echo '<br><br><input type="button" value="' . $txt['347'] . '" onclick="document.location.href='
         . "'index.php?modul=log&unfilter=yes'" . ';">';
    // спойлер
    echo '<div align="left" style="margin-bottom:1px;font-size:9px;">';
    echo '<input type="button" value="+" style="width:18px;font-size:9px;margin:0px;padding:0px;"'; 
    echo 'onClick="'."if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '')"
         . " { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';"
         . " this.innerText = ''; this.value = '-'; } else "
         . "{ this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none';"
         . " this.innerText = '';  this.value = '+';".' }"> '
         . $txt['345']
         . '</div>';
    echo '<div class="alt2" style="margin: 0px; padding: 0px; border: 0px inset;"><div style="display: none;">';
    // Hidden text
    echo '<form method="get" action="index.php">';
    echo '<input name="modul" value="log" type=hidden>';
    echo '<input name="tp" value="';
    echo $TP;
    echo '" type=hidden>';
    // ввод ИП
    echo $txt['348'] . ' <input type="text" name="IP" size="15" value="';
    if ($f1 <> '') echo $f1; 
    echo '"><br>';
    // ввод мыла
    echo $txt['349'] . ' <input type="text" name="mail" size="15" value="';
    if ($f2 <> '') echo $f2;
    echo '"><br>';
    // ввод учетки
    echo $txt['350'] . ' <input type="text" name="acc" size="15" value="';
    if ($f3 <> '') echo $f3;
    echo '"><br>';
    // ввод перса
    echo $txt['351'] . ' <input type="text" name="char" size="15" value="';
    if ($f4 <> '') echo $f4;
    echo '"><br><br>';
    echo '<input type="submit" value="' . $txt['346'] . '"> ';
    echo "</form><br>";
    echo "</div></div>\n";
    echo '</td></tr>';
    // Сама табличка (Заголовок)
    echo '<tr><td height="25" colspan="4" ';
    echo 'align="center" valign="middle" class="TableTitle"><b>' . $txt['134'] . '</b> ' . $WHR_TITLE . '</td></tr>';
    $kol = 1;
    $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
    mysql_select_db($k_db, $k_connect);
    mysql_query("SET NAMES '$encoding'");
    $query = "SELECT count(date) as kol FROM `log` " . $WHR;
    $res = mysql_query($query) or trigger_error(mysql_error() . $query);
    $kolzap = mysql_fetch_array($res);
    echo '<tr><td  colspan="4" align="left" valign="middle" class="TableOther">All: ' . $kolzap['kol'] . '</td></tr>';
    if ($kolzap['kol'] > $LogPageSize)
        {
        $PageLen = $LogPageSize;
        if (!isset($_GET['page']) or ($_GET['page'] == ''))
            $StartRec = 0;
        else
            $StartRec = ((int) $_GET['page'] - 1) * $LogPageSize;
        }
    else
        {
        $PageLen = $kolzap['kol'];
        $StartRec = 0;
        }

    $query = "SELECT * FROM `log` " . $WHR . " order by `date` limit " . $StartRec . "," . $PageLen;
    $res = mysql_query($query) or trigger_error(mysql_error() . $query);
    while ($mres = mysql_fetch_array($res))
        {
        echo '<tr><td width="200" align="left" valign="middle" class="TableLeft">';
        echo $mres['date'] . '<br><a href="index.php?modul=log&tp=' . $TP . '&IP='
           . $mres['ip'] . '">' . $mres['ip'] . '</a>';
        if ($mres['email'] <> '') echo '<br><a href="index.php?modul=log&tp=' . $TP 
                                     . '&mail=' . $mres['email'] . '">' . $mres['email'] . '</a>';
        echo '</td><td width="350" align="left" valign="middle" class="TableCenter"><b>';
        echo $txt[122 + $mres['mode']] . '</b><br>';
        if ($mres['resultat'] <> '')
            echo $txt['135'] . ' ' . $mres['resultat'] . '<br>';
        if ($mres['note'] <> '')
            echo $txt['136'] . ' ' . $mres['note'] . '<br>';
        if ($mres['old_data'] <> '')
            echo $txt['137'] . ' ' . $mres['old_data'] . '<br>';

        echo '</td><td width="45" align="right" valign="middle" class="TableCenter">';
        if ($mres['realmd'] > 0)
            echo 'r:' . $mres['realmd'] . '<br>';
        if ($mres['account'] > 0)
            echo '<a href="index.php?modul=log&tp=' . $TP . '&acc=' . $mres['account']
               . '">a:' . $mres['account'] . '</a><br>';
        if ($mres['character'] > 0)
            echo '<a href="index.php?modul=log&tp=' . $TP . '&char=' . $mres['character']
               . '">c:' . $mres['character'] . '</a>';
        echo '</td><td width="5" class="TableRight">&nbsp;&nbsp;</td></tr>';
        $kol++;
        }
    if ($kol == 1)
        {
        echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>' . $txt[141] . '</b></td></tr>';
    }
    if ($kolzap['kol'] > $LogPageSize) // тут рисуем навигатор
        {
        $PageCounter = ceil($kolzap['kol'] / $LogPageSize);
        if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
            $pg = 1;
        else
            $pg = (int) $_GET['page'];
        echo '<tr><td height="30" colspan="3" align="center" valign="middle" >';
        echo ShowPageNavigator('index.php?modul=log&tp=' . $TP . '&page=', $pg, $PageCounter);
        echo '</td></tr>';
        }
    echo '</table><br>'; // табличка офф
    // Кнопка для стирания старых записей.
    echo '<div align="center"><form method="get">';
    echo '<input action="index.php" name="modul" value="log" type=hidden>';
    echo '<input action="index.php" name="page" value="1" type=hidden>';
    echo '<input action="index.php" name="tp" value="';
    echo $TP;
    echo '" type=hidden>';
    echo '<input action="index.php" name="erase" value="yes" type=hidden>';
    echo '<input type="submit" value="' . $txt['142'] . '">';
    echo '</form></div>';
    }
else
    echo $txt['138']; // запрет
?>