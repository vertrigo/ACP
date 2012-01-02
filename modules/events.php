<?php

// Модуль вывода календаря ивентов
//================================
// Имеет три режима работы
// 1. Показ перечня ежедневных событий продолжительностью которых менее 24 часов
// 2. Показ Календаря ивентов.
// 3. Перечень всех ивентов на сервере
//----Show button--------------
echo '<br><a name="top"></a>'
 . '<table width="560" height="30" border="0" cellspacing="5" cellpadding="0">'
 . '<tr><td align="center" valign="middle">';
//
echo ' <input type="button" value="' . $txt['319']
 . '" onclick="document.location.href=' . "'index.php?modul=events&show=1" . "'" . ';"> ';
echo '&nbsp;';
echo ' <input type="button" value="' . $txt['320']
 . '" onclick="document.location.href=' . "'index.php?modul=events&show=2" . "'" . ';"> ';
echo '&nbsp;';
echo ' <input type="button" value="' . $txt['321']
 . '" onclick="document.location.href=' . "'index.php?modul=events&show=3" . "'" . ';"> ';
//
echo '</td></tr></table><br><hr><br>';
//-----------------------------
$m_connect = mysql_connect($m_ip, $m_userdb, $m_pw);
mysql_select_db($m_db, $m_connect);
mysql_query("SET NAMES '$encoding'");
//mysql_query("SET time_zone = '+05:00'");

if (isset($_GET['show']))
    $EventShow = (int) $_GET['show'];
else
    $EventShow = 1;

if ($EventShow == 2) // Показ перечня всех ивентов
    {
    $equery = "SELECT `game_event`.`entry`,"
            . "unix_timestamp(`start_time`) as start_time,"
            . "unix_timestamp(`end_time`)as end_time,"
            . "`occurence`,`length`,`description`,"
            . "`name_loc8`,`name_loc1`"
            . "FROM `game_event` LEFT JOIN `locales_game_event_holiday` "
            . "ON `locales_game_event_holiday`.`entry` = `game_event`.`holiday` "
            . "ORDER BY `entry`";
    $evres = mysql_query($equery, $m_connect);
    $ev_kol = mysql_num_rows($evres);
    if ($ev_kol > 0)
        {
        echo '<table width="600" border="0" cellspacing="0" cellpadding="3">';
        echo '<tr>';
        echo '<td colspan="5" align="center" valign="bottom">';
        echo '<img src="images/books.jpg">';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="5" align="center" valign="middle" class="TableTitle">';
        echo $txt['320']; // заголовок таблицы
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="30" class="TableOther">';
        echo 'id'; // id
        echo '</td>';
        echo '<td width="230" class="TableOther">';
        echo $txt['322']; // Название
        echo '</td>';
        echo '<td width="180" class="TableOther">';
        echo $txt['329']; // от и до...
        echo '</td>';
        echo '<td width="100" class="TableOther">';
        echo $txt['330']; // длительность и повтор
        echo '</td>';
        echo '<td width="60" class="TableOther">';
        echo $txt['326']; // когда следующее начало.
        echo '</td>';
        echo '</tr>';
        while ($eres = mysql_fetch_array($evres))
            {
            echo '<tr>';
            echo '<td width="30" class="TableLeft" align="center">';
            echo $eres['entry'];
            echo '</td>';
            echo '<td width="230" class="TableCenter">';
            if ($eres['name_loc8'] <> "")
                $tt = $eres['name_loc8'];
            elseif ($eres['name_loc1'] <> "")
                $tt = $eres['name_loc1'];
            else
                $tt = $eres['description'];
            echo '<a href="index.php?modul=events&show=2&view=' . $eres['entry'] . '#view" Title="'
            . $tt . '">' . $tt . '</a>';
            echo '</td>';
            echo '<td width="180" class="TableCenter">';
            echo '<font color="gray">' . $txt['323'] . '</font><br>'
            . date("d-m-Y", $eres['start_time']) . '<br>';
            echo '<font color="gray">' . $txt['324'] . '</font><br>'
            . date("d-m-Y", $eres['end_time']) . '<br>';
            echo '</td>';
            echo '<td width="100" class="TableCenter">';
            echo '<font color="gray">' . $txt['327'] . '</font><br>'
            . sec_to_time($eres['length'] * 60) . '<br>';
            echo '<font color="gray">' . $txt['328'] . '</font><br>'
            . sec_to_time($eres['occurence'] * 60) . '<br>';
            echo '</td>';
            echo '<td width="60" class="TableRight" align="center">';
            if (event_status($eres['start_time'], $eres['occurence'] * 60, $eres['length'] * 60, time()))
                {
                echo '<font color="red"><b>' . $txt['336'] . '</b></font>';
                }
            else
                echo date("d-m-Y H:i:s", event_actual_start($eres['start_time'], $eres['occurence'] * 60, time() + $time_zone_corrector));
            echo '</td>';
            echo '</tr>';
            }
        echo '</table>';
        }
    }
elseif ($EventShow == 3) // Ежедневные события
    {
    $equery = "SELECT `game_event`.`entry`,"
            . "unix_timestamp(`start_time`) as start_time,"
            . "unix_timestamp(`end_time`)as end_time,"
            . "`occurence`,`length`,`description`,"
            . "`name_loc8`,`name_loc1`"
            . "FROM `game_event` LEFT JOIN `locales_game_event_holiday` "
            . "ON `locales_game_event_holiday`.`entry` = `game_event`.`holiday` "
            . "WHERE (`start_time` < now()) AND (`end_time`  > now()) AND "
            . "(`occurence` < 1441) ORDER BY `entry`";
    $evres = mysql_query($equery, $m_connect);
    $ev_kol = mysql_num_rows($evres);
    if ($ev_kol > 0)
        {
        echo '<table width="600" border="0" cellspacing="0" cellpadding="3">';
        echo '<tr>';
        echo '<td colspan="3" align="left" valign="bottom">';
        echo '<img src="images/watch.png">';
        echo '</td>';
        echo '<td colspan="2" align="right" valign="bottom">';
        echo date("d-m-Y  -  H:i:s", time() + $time_zone_corrector); // Время
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="5" align="center" valign="middle" class="TableTitle">';
        echo $txt['321']; // заголовок
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td width="30" class="TableOther">';
        echo 'id'; // id
        echo '</td>';
        echo '<td width="230" class="TableOther">';
        echo $txt['322']; // Название
        echo '</td>';
        echo '<td width="180" class="TableOther">';
        echo $txt['329']; // от и до...
        echo '</td>';
        echo '<td width="100" class="TableOther">';
        echo $txt['330']; // длительность и повтор
        echo '</td>';
        echo '<td width="60" class="TableOther">';
        echo $txt['326']; // когда следующее начало
        echo '</td>';
        echo '</tr>';
        while ($eres = mysql_fetch_array($evres))
            {
            echo '<tr>';
            echo '<td width="30" class="TableLeft" align="center">';
            echo $eres['entry'];
            echo '</td>';
            echo '<td width="230" class="TableCenter">';
            if ($eres['name_loc8'] <> "")
                $tt = $eres['name_loc8'];
            elseif ($eres['name_loc1'] <> "")
                $tt = $eres['name_loc1'];
            else
                $tt = $eres['description'];
            echo '<a href="index.php?modul=events&show=3&view=' . $eres['entry'] . '#view" Title="'
            . $tt . '">' . $tt . '</a>';
            echo '</td>';
            echo '<td width="180" class="TableCenter">';
            echo '<font color="gray">' . $txt['323'] . '</font><br>'
            . date("d-m-Y", $eres['start_time']) . '<br>';
            echo '<font color="gray">' . $txt['324'] . '</font><br>'
            . date("d-m-Y", $eres['end_time']) . '<br>';
            echo '</td>';
            echo '<td width="100" class="TableCenter">';
            echo '<font color="gray">' . $txt['327'] . '</font><br>'
            . sec_to_time($eres['length'] * 60) . '<br>';
            echo '<font color="gray">' . $txt['328'] . '</font><br>'
            . sec_to_time($eres['occurence'] * 60) . '<br>';
            echo '</td>';
            echo '<td width="60" class="TableRight" align="center">';
            if (event_status($eres['start_time'], $eres['occurence'] * 60, $eres['length'] * 60, time()))
                {
                echo '<font color="red"><b>' . $txt['336'] . '</b></font>';
                }
            else
                echo date("d-m-Y H:i:s", event_actual_start($eres['start_time'], $eres['occurence'] * 60, time() + $time_zone_corrector));
            echo '</td>';
            echo '</tr>';
            }
        echo '</table>';
        }
    }
else // календарик.
    {
    // здесь помещаем выбор текущей даты.
    if (isset($_GET['date']) && (int) $_GET['date'] > 0)
        $current_date = (int) $_GET['date'];
    else
        $current_date = time();
    // подсчитываем сегодняшний день на 00:00 часов.
    $today = mktime(0, 0, 0, date('m', time()), date('d', time()), date('Y', time()));
    // Вычисляем число дней в текущем месяце
    $dayofmonth = date('t', $current_date);
    // Счётчик для дней месяца
    $day_count = 1;
    // вычислим юникс-дату на 00:00 первого числа этого месяца
    $unixtime = mktime(0, 0, 0, date('m', $current_date), 1, date('Y', $current_date));
    // запрос о событиях для календаря.
    $equery = "SELECT `entry`,unix_timestamp(`start_time`) as start_time,"
            . "unix_timestamp(`end_time`) as end_time,`occurence`,`length`,"
            . "`holiday`,`description` FROM `game_event` WHERE "
            . '(unix_timestamp(`start_time`) < ' . $unixtime . ') AND '
            . '(unix_timestamp(`end_time`)  > ' . ($unixtime + 60 * 60 * 24 * $dayofmonth)
            . ') AND ' . "(`occurence` > 1441) AND (`length` < 40300) order by `entry`";
    $evres = mysql_query($equery, $m_connect);
//     $eventcount = mysql_num_rows($evres); // количество выбранных событий
    $eventlist = array(); // массив для хранения событий
    $j = 0;
    while ($eres = mysql_fetch_array($evres))
        {
        $eventlist[$j] = $eres; // выбираем список событий в массив
        $j++;
        }
    echo '<a name="cal"></a>'; // ссылка на календарик
// Начинаем рисовать календарик
    echo '<table border="0" cellspacing="0" cellpadding="3" width="602">';
    echo '<tr>';
    echo '<td colspan="2" align="center" valign="bottom">';
    echo '<img src="images/calendar.jpg">';
    echo '</td>';
    echo '<td colspan="5" align="right" valign="top">';
    echo '<div align="justify" style="width:100%;">';
    echo $txt['338'];
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td width="86" class="TableTitle" align="left">';
    echo '<input type="button" value="<<<" onclick="document.location.href=' . "'index.php?modul=events&show=1&date="
    . ($unixtime - 60 * 60 * 24 * 25) . "#cal'" . ';"> ';
    echo '</td>';
    echo '<td colspan="5" class="TableTitle" align="center">' . $txt['319'] . ' (' . date("m/Y", $current_date) . ')</td>';
    echo '<td width="86" class="TableTitle" align="right">';
    echo '<input type="button" value=">>>" onclick="document.location.href=' . "'index.php?modul=events&show=1&date="
    . ($unixtime + 60 * 60 * 24 * 32) . "#cal'" . ';"> ';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][0] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][1] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][2] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][3] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][4] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][5] . '</td>';
    echo '<td  width="86" class="TableOther" align="center">' . $txt['337'][6] . '</td>';
    echo '</tr>';

    while ($day_count < $dayofmonth) // Цикл на весь месяц.
        {
        echo '<tr>'; // формируем неделю (строку)
        for ($i = 1; $i < 8; $i++)
            {
            echo '<td width="86" align="center" valign="top" class="TableCell">'; // Клеточка дня
            if ($day_count == 1 && $i < date('w', $unixtime))
                {
                echo '<img src="images/left.gif">'; // Если это день предыдущего месяца, то ничего не вставлять.
                } elseif ($day_count > $dayofmonth)
                {
                echo '<img src="images/right.gif">'; // Если это день последующего месяца, то ничего не вставлять.
                } else
                {
                if ($i > 5)
                    echo '<font color="red">'; //выделение выходных
                if ($unixtime == $today)
                    echo '<b>[<u>'; //выделение сегодняшней даты
                echo date('d', $unixtime); // Печатаем число
                if ($unixtime == $today)
                    echo '</u>]</b>'; //выделение сегодняшней даты
                if ($i > 5)
                    echo '</font>'; //выделение выходных
// ==============================
                // Место для заполнения ячейки своими данными.
                echo '<br>';
                foreach ($eventlist as $nom => $eventdata)
                    {
                    if (event_go($eventdata['start_time'], $eventdata['end_time'], $eventdata['occurence'] * 60, $eventdata['length'] * 60, $unixtime + $time_zone_corrector, $dayofmonth) == true)
                        {
                        echo '<br>';
                        if ((int) $eventdata['holiday'] > 0)
                            {
                            echo '<img src="images/la.png" align="top">';
                            }
                        echo '<a href="index.php?modul=events&show=1&date=' . $unixtime . '&view='
                        . $eventdata['entry'] . '#view" Title="' . $eventdata['description']
                        . '">(' . $eventdata['entry'] . ')</a>';
                        if ((int) $eventdata['holiday'] > 0)
                            {
                            echo '<img src="images/ra.png" align="top">';
                            }
                        }
                    }
                // ==============================
                $unixtime = $unixtime + 60 * 60 * 24; // +1 день
                $day_count++;                     // +1 день
                }
            echo '</td>'; // закрыли ячейку
            }
        echo '</tr>'; // закрыли неделю (строку)
        }
    echo '<tr><td colspan="7" height="30" align="center" valign="middle">';
    echo '<img src="images/la.png" align="top">(...)<img src="images/ra.png" align="top">' . $txt['339'];
    echo '</td></tr>';
    echo '</table>'; // Закончили печать календарика
    }

// показ таблички о текущем событии
if (isset($_GET['view']) && ((int) $_GET['view'] > 0 ))
    {
    echo '<br><br><a name="view"></a>'; // ссылка на просмотр события
    $equery = "SELECT `entry`,unix_timestamp(`start_time`) as start_time,"
            . "unix_timestamp(`end_time`) as end_time,`occurence`,`length`,"
            . "`holiday`,`description` FROM `game_event` WHERE "
            . "`entry` = " . (int) $_GET['view'] . " LIMIT 1";
    $evres = mysql_query($equery, $m_connect);
    $eres = mysql_fetch_array($evres);
    if ((int) $eres['holiday'] > 0)
        {
        $equery = "SELECT * FROM `locales_game_event_holiday` WHERE `entry` = "
                . (int) $eres['holiday'] . ' LIMIT 1';
        $evres = mysql_query($equery, $m_connect);
        if (mysql_num_rows($evres) == 1)
            {
            $hres = mysql_fetch_array($evres);
            } else
            {
            $hres = array();
            }
        }
    echo '<table border="0" cellspacing="0" cellpadding="3" width="602">';
    echo '<tr>';
    echo '<td colspan="4" class="TableTitle" align="center">' . $txt['340'] . ' (#'
    . $eres['entry'] . ')</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="center" valign="top">';
    if (((int) $eres['holiday'] > 0) && file_exists('images/holiday/icons/' . $eres['holiday'] . '.jpg'))
        {
        echo '<img src="images/holiday/icons/' . $eres['holiday'] . '.jpg">';
        } elseif (file_exists('images/events/icons/' . $eres['entry'] . '.jpg'))
        {
        echo '<img src="images/events/icons/' . $eres['entry'] . '.jpg">';
        }
    else
        echo '<img src="images/holiday/icons/all.gif">';
    echo '&nbsp;</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top">';
    echo '<h2>';
    if (((int) $eres['holiday'] > 0) && ($hres['name_loc8'] <> ''))
        {
        echo $hres['name_loc8'];
        } else
        {
        echo $eres['description'];
        }
    echo '</h2></td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';
    // описание события.
    if (((int) $eres['holiday'] > 0) && ($hres['description_loc8'] <> ''))
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter"align="left" valign="top" colspan="2">';
        echo nl2br($hres['description_loc8']) . '</td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        }
    // Характеристики
    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="right" valign="top">' . $txt['323'] . '</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top"> - <b>'
    . date("d-m-Y", $eres['start_time']) . '</b></td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="right" valign="top">' . $txt['324'] . '</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top"> - <b>'
    . date("d-m-Y", $eres['end_time']) . '</b></td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="right" valign="top">' . $txt['327'] . '</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top"> - <b>'
    . sec_to_time($eres['length'] * 60) . '</b></td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="right" valign="top">' . $txt['328'] . '</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top"> - <b>'
    . sec_to_time($eres['occurence'] * 60) . '</b></td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td class="TableLeft" width="11">&nbsp;</td>';
    echo '<td class="TableCenter" width="180" align="right" valign="top">' . $txt['326'] . '</td>';
    echo '<td class="TableCenter" width="400" align="left" valign="top">';
    if (event_status($eres['start_time'], $eres['occurence'] * 60, $eres['length'] * 60, time()))
        {
        echo ' - <font color="red"><b>' . $txt['336'] . '</b></font>';
        }
    else
        echo ' - <b>'
        . date("d-m-Y H:i:s", event_actual_start($eres['start_time'], $eres['occurence'] * 60, time() + $time_zone_corrector))
        . '</b>';
    echo '</td>';
    echo '<td class="TableRight" width="11">&nbsp;</td>';
    echo '</tr>';

    if (((int) $eres['holiday'] > 0) && file_exists('images/holiday/' . $eres['holiday'] . '.jpg'))
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter" width="180" align="center" valign="top" colspan="2">';
        echo '<br><img src="images/holiday/' . $eres['holiday'] . '.jpg"><br><br>';
        echo '</td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        } elseif (file_exists('images/events/' . $eres['entry'] . '.jpg'))
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter" width="180" align="center" valign="top" colspan="2">';
        echo '<br><img src="images/events/' . $eres['entry'] . '.jpg"><br><br>';
        echo '</td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        }
    // Показываем сколько и каких объектов добавляется в мир
    $equery = "SELECT count(`event`) FROM `game_event_gameobject` WHERE `event` = "
            . (int) $eres['entry'];
    $evres = mysql_query($equery, $m_connect);
    $ores = mysql_fetch_array($evres);
    if ($ores[0] > 0)
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter" colspan="2" align="center" valign="top">';
        echo '<img src="images/obj.gif"> ';
        echo $txt['342'] . '<b>' . $ores[0] . '</b></td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        }
    // Показываем сколько и каких NPC добавляется в мир
    $equery = "SELECT count(`event`) FROM `game_event_creature` WHERE `event` = " . (int) $eres['entry'];
    $evres = mysql_query($equery, $m_connect);
    $ores = mysql_fetch_array($evres);
    if ($ores[0] > 0)
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter" colspan="2" align="center" valign="top">';
        echo '<img src="images/npc.gif"> ';
        echo $txt['343'] . '<b>' . $ores[0] . '</b>';

        echo '</td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        }
    // Показываем сколько и каких КВЕСТОВ добавляется в мир
    $equery = "SELECT count(`event`) FROM `game_event_quest` WHERE `event` = " . (int) $eres['entry'];
    $evres = mysql_query($equery, $m_connect);
    $ores = mysql_fetch_array($evres);
    if ($ores[0] > 0)
        {
        echo '<tr>';
        echo '<td class="TableLeft" width="11">&nbsp;</td>';
        echo '<td class="TableCenter" colspan="2" align="center" valign="top">';
        echo '<img src="images/quest.gif"> ';
        echo $txt['344'] . '<b>' . $ores[0] . '</b></td>';
        echo '<td class="TableRight" width="11">&nbsp;</td>';
        echo '</tr>';
        }
    /*
      echo '<tr>';
      echo '<td class="TableLeft" width="11">&nbsp;</td>';
      echo '<td class="TableCenter" width="180" align="right" valign="top">&nbsp;</td>';
      echo '<td class="TableCenter" width="400" align="left" valign="top">&nbsp;</td>';
      echo '<td class="TableRight" width="11">&nbsp;</td>';
      echo '</tr>';
     */
    echo '</table>'; // Закончили рисовать табличку о событии
    }
// Админская форма для редактирования доп. Информации о событии.
// пока ее нет. :(    

echo '<br><hr><input type="button" value="' . $txt['341'] . '" onclick="document.location.href='
 . "'#top'" . ';"> ';
?>