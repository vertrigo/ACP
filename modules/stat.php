<?php
if (isset($_GET['stat_id']))
    $statid = (int) $_GET['stat_id'];
else
    $statid = 0;
$stat_data = array(
    1 => 'stat_acc.php',
    2 => 'stat_race.php',
    3 => 'stat_class.php',
    4 => 'stat_fract.php',
    5 => 'stat_gender.php',
);
echo '<br><table width="560" border="0" cellspacing="0" cellpadding="0">' .
 '<tr><td height="35" align="center" colspan="2" valign="middle"><b>' . $txt[270 + $statid] . '</b></td></tr>';
if ($statid == 0)
    {
    // Онлайн сервера
    $koll = 0;
    $realmid = $_SESSION['realmd'];
    settype($realmid,'integer');
    $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
    mysql_select_db($r_db, $r_connect);
    mysql_query("SET NAMES '$encoding'");
    $fp = @fsockopen($r_ip, "3724", $errno, $errstr, 1);
    if ($fp)
        {
        $res = mysql_fetch_array(mysql_query("select `starttime`,UNIX_TIMESTAMP(now()) as noww from `uptime` where `realmid`='$realmid' order by `starttime` desc limit 1 "));
        $koll = $res['starttime'];
        $noww = $res['noww'];
        $uptime = (int) $noww - (int) $koll;
        $sec = $uptime % 60;
        if ($sec > 0)
            $ds = $sec . $txt[285];
        $uptime = intval($uptime / 60);
        $min = $uptime % 60;
        if ($min > 0)
            $ds = $min . $txt[286] . $ds;
        $uptime = intval($uptime / 60);
        $hours = $uptime % 24;
        if ($hours > 0)
            $ds = $hours . $txt[287] . $ds;
        $uptime = intval($uptime / 24);
        $days = $uptime;
        if ($days > 0)
            $ds = $days . $txt[288] . $ds;
        if ($koll > 0)
            echo '<tr><td height="35" align="left" valign="middle">' . $txt[289] . '</td>'
            . '<td height="35" align="right" valign="middle">' . $ds . ' </td></tr>';
        }
    // MAX Онлайн сервера
    $koll = 0;
    $res = mysql_fetch_array(mysql_query("select `maxplayers` from `uptime` where `realmid`='$realmid' order by `maxplayers` desc limit 1 "));
    $koll = $res[0];
    if ($koll > 0)
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[290] . '</td>'
        . '<td height="35" align="right" valign="middle">' . $koll . ' чел. </td></tr>';

    // Всего аккаунтов
    $koll = 0;
    $res = mysql_fetch_array(mysql_query("select count(*) as kol from `account` "));
    $koll = $res['kol'];
    if ($koll > 0)
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[291] . '</td>'
        . '<td height="35" align="right" valign="middle">' . $koll . ' </td></tr>';

    // Всего персонажей
    $koll = 0;
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_fetch_array(mysql_query("select count(*) as kol from `characters` "));
    $koll = $res['kol'];
    if ($koll > 0)
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[292] . '</td>'
        . '<td height="35" align="right" valign="middle">' . $koll . ' </td></tr>';
    // персы альянса
    $koll = 0;
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_fetch_array(mysql_query("select count(*) from `characters` where `race` in (1,3,4,7,11) "));
    $koll = $res[0];
    echo '<tr><td height="35" align="left" valign="middle">' . $txt[293] . '</td>'
    . '<td height="35" align="right" valign="middle">' . $koll . ' </td></tr>';
    // персы альянса
    $koll = 0;
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_fetch_array(mysql_query("select count(*) from `characters` where `race` in (2,5,6,8,10) "));
    $koll = $res[0];
    echo '<tr><td height="35" align="left" valign="middle">' . $txt[294] . '</td>'
    . '<td height="35" align="right" valign="middle">' . $koll . ' </td></tr>';


    // Ресеты
    $koll = 0;
    setlocale(LC_TIME, 'ru_RU');
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    @$res = mysql_fetch_array(mysql_query("SELECT * FROM `saved_variables`")); // don't show errors for different server systems
    if ($res['NextArenaPointDistributionTime'] >= time())
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[315] . '</td>'
        . '<td height="35" align="right" valign="middle">' . date('j-n-Y, H:i (D)', $res['NextArenaPointDistributionTime']) . ' </td></tr>';
    if ($res['NextDailyQuestResetTime'] >= time())
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[316] . '</td>'
        . '<td height="35" align="right" valign="middle">' . date('j-n-Y, H:i (D)', $res['NextDailyQuestResetTime']) . ' </td></tr>';
    if ($res['NextWeeklyQuestResetTime'] >= time())
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[317] . '</td>'
        . '<td height="35" align="right" valign="middle">' . date('j-n-Y, H:i (D)', $res['NextWeeklyQuestResetTime']) . ' </td></tr>';
    if (isset($res['NextMonthlyQuestResetTime']) && ($res['NextMonthlyQuestResetTime'] >= time()))
        echo '<tr><td height="35" align="left" valign="middle">' . $txt[318] . '</td>'
        . '<td height="35" align="right" valign="middle">' . date('j-n-Y, H:i (D)', $res['NextMonthlyQuestResetTime']) . ' </td></tr>';


    // Если Админ, то версии баз
    //
    if (isset($_SESSION['gnom']) AND ($_SESSION['gnom'] >= $modules[$_SESSION['modul']][3]))
        {
        $m_connect = mysql_connect($m_ip, $m_userdb, $m_pw);
        echo '<tr><td height="35" colspan="2" align="left" valign="middle"> </td></tr>';
        mysql_select_db($m_db, $m_connect);
        mysql_query("SET NAMES '$encoding'");
        if ($ServerSystem == 1)
            $res = mysql_fetch_array(mysql_query("select * from `version` "));
        else
            $res = mysql_fetch_array(mysql_query("select * from `db_version` "));
        if ($ServerSystem == 1)
            {
            echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[295] . $res[1] . '</td></tr>';
            echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[296] . $res[2] . ' </td></tr>';
            echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[297] . $res[3] . ' </td></tr>';
            } else
            {
            echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[295] . $res[0] . '</td></tr>';
            echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[296] . $res[1] . ' </td></tr>';
            if (isset($s_ip))
                {
                $s_connect = mysql_connect($s_ip, $s_userdb, $s_pw);
                mysql_select_db($s_db, $s_connect);
                mysql_query("SET NAMES '$encoding'");
                $res = mysql_fetch_array(mysql_query("select * from `sd2_db_version` "));
                echo '<tr><td height="35" colspan="2" align="left" valign="middle">' . $txt[297] . $res[0] . '</td></tr>';
                }
            }
        }
    // Заголовок диаграммы
    echo '<tr><td height="45" colspan="2" align="center" valign="middle">' . $txt[298] . '</td></tr>';
    }
echo '<tr><td colspan="2" >';
?>

<!-- ampie script-->
<script type="text/javascript" src="xmlqueres/ampie/swfobject.js"></script>
<div id="flashcontent">
    <strong>You need to upgrade your Flash Player</strong>
</div>

<script type="text/javascript">
    // <![CDATA[
    var so = new SWFObject("xmlqueres/ampie/ampie.swf", "stat", "560", "375", "8", "#FFFFFF");
    so.addVariable("path", "xmlqueres/ampie/");
    so.addVariable("settings_file", escape("xmlqueres/ampie_settings.xml"));
    so.addVariable("data_file", escape("xmlqueres/<?php echo $stat_data[$statid + 1]; ?>"));
    so.addVariable("preloader_color", "#999999");
    so.write("flashcontent");
    // ]]>
</script>
<!-- end of ampie script -->

<?php
echo '</td></tr>';
echo '<tr><td colspan="2" height="35" align="right" valign="middle">';

echo "<select size=\"1\" name=\"my_menu\" onchange=\"document.location.href='index.php?modul=stat&stat_id='+this.value;\">";
for ($i = 0; $i <= 4; $i++)
    {
    echo '<option value="' . $i . '"';
    if ($statid == $i)
        echo ' selected';
    echo '>' . $txt[270 + $i] . '</option>';
    }
echo "</select>";

echo '</td></tr>';
echo '</table>';
?>
