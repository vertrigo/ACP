<?php

if ($WriteBagreport <> 1)
    {
    echo '<br><img src="images/other/ok.png"><br><br><img src="images/no.png"> <b>' . $txt[212] . '</b><br><hr><br>';
    ReturnMainForm(60);
    return;
    }
// connect DB
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '$encoding'");

// add !!!!
if (isset($_POST['cmd']) AND ($_POST['cmd'] == 'add'))
    {
    if ($_POST['kategor'] > 0)
        $nk = $_POST['kategor'];
    else
        $nk = 10;
    if ($_POST['tema'] <> '')
        $nt = $_POST['tema'];
    else
        $nt = '[' . $txt[150 + $nk] . ']' . $txt[210] . $_POST['charname'];
    $addQuery = 'insert into `bagreports` (`charid`,`charname`,`type`, `theme`,`report`,`status`,`thanks`)'
            . 'values (' . $_POST['charid'] . ', "' . $_POST['charname'] . '", ' . $nk . ', "' . $nt . '", "' . text_optimazer($_POST['report']) . '", 0, 0)';
    mysql_query($addQuery) or trigger_error(mysql_error());
    echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>' . $txt[211] . '</b><br><hr><br>';
    }
// edit
if (isset($_POST['cmd']) AND ($_POST['cmd'] == 'edit'))
    {
    if ($_POST['kategor'] > 0)
        $nk = $_POST['kategor'];
    else
        $nk = 10;
    if ($_POST['tema'] <> '')
        $nt = $_POST['tema'];
    else
        $nt = '[' . $txt[150 + $nk] . ']';
    $addQuery = 'update `bagreports` set ';
    $addQuery .= ' `type` = ' . $nk . ', `theme` = "' . $nt . '", `report` = "' . text_optimazer($_POST['report']) . '",`status` = ' . ($_POST['status'] - 1) . ', ';
    if (isset($_POST['thx']) AND ($_POST['thx'] == 1))
        $addQuery .= '`thanks` = 1, ';
    $addQuery .= '`adminnote` = "' . text_optimazer($_POST['adminnote']) . '" where `id` = ' . $_POST['id'];
    mysql_query($addQuery) or trigger_error(mysql_error());
    // save thanks for bagreport
    if (isset($_POST['thx']) AND ($_POST['thx'] == 1) AND isset($_POST['charid']))
        {
        $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
        mysql_select_db($c_db, $c_connect);
        mysql_query("SET NAMES '$encoding'");
        mysql_query("update `characters` set `money` = `money` + " . $ThanksBagReport . " where `guid` = " . (int) $_POST['charid']) or trigger_error(mysql_error());
        // re connect from DB
        $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
        mysql_select_db($k_db, $k_connect);
        mysql_query("SET NAMES '$encoding'");
        }
    echo '<br><img src="images/other/ok.png"><br><br><img src="images/yes.png"> <b>' . $txt[211] . '</b><br><hr><br>';
    }

// show table
echo '<br><br><div style="margin-top:2px"><table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td>
<div class="smallfont" style="margin-bottom:1px" align="left"><input type="button" value="+" style="width:15px;font-size:9px;margin:0px;padding:0px;"
		onClick="';
echo " if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '')
	        { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';
        	 this.innerText = ''; this.value = '-'; }
	       else
		{ this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none';
                               this.innerText = ''; this.value = '+'; }";
echo '" > ' . $txt[140] . '</div>
<div class="alt2" style="margin: 0px; padding: 1px; border: 0px inset;">
<div style="display: none;">';

echo '<form method="get"><table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td width="350" align="left">';
echo '<input action="index.php" name="modul" value="bagtrack" type=hidden>';
echo '<input action="index.php" name="tp" value="_" type=radio checked>' . $txt[213] . '<br>';
for ($i = 0; $i <= 9; $i++)
    {
    echo '<input action="index.php" name="tp" value="' . $i . '" type=radio>' . $txt[151 + $i] . '<br>';
}
echo '</td><td width="150" align="right" valign="bottom">';
echo '<input type="submit" value="' . $txt[11] . '">';
echo '</td></tr></table><br>';
echo '</form>';
echo '</div></div></td></tr></table></div>';
if (!isset($_GET['tp']) OR ($_GET['tp'] == '') OR ($_GET['tp'] == '_'))
    {
    $WHR = '';
    $WHR_TITLE = '';
    } else if (($_GET['tp'] >= 0) AND ($_GET['tp'] < 10))
    {
    $WHR = ' where `type` = ' . ((int) $_GET['tp'] + 1);
    $WHR_TITLE = '( ' . $txt[151 + (int) $_GET['tp']] . ' )';
    }
echo '<form method="post"><table width="610" border="0" cellspacing="0" cellpadding="5">
  <tr><td height="25" colspan="3" align="center" valign="middle" class="TableTitle"><b>' . $txt[143] . '</b> ' . $WHR_TITLE . '</td></tr>';
$kol = 1;
$query = "SELECT count(id) as kol FROM `bagreports`" . $WHR;
$res = mysql_query($query) or trigger_error(mysql_error());
$kolzap = mysql_fetch_array($res);
echo '<tr><td colspan="3" align="left" valign="middle" class="TableOther">All: ' . $kolzap['kol'] . '</td></tr>';
if ($kolzap['kol'] > $PageBagReport)
    {
    $PageLen = $PageBagReport;
    if (!isset($_GET['page']) or ($_GET['page'] == ''))
        $StartRec = 0;
    else
        $StartRec = ((int) $_GET['page'] - 1) * $PageBagReport;
    }
else
    {
    $PageLen = $kolzap['kol'];
    $StartRec = 0;
    }
$query = "select *  from `bagreports` " . $WHR . " order by `datewrite` DESC limit " . $StartRec . "," . $PageLen;
$res = mysql_query($query) or trigger_error(mysql_error());
while ($tres = mysql_fetch_array($res))
    {
    echo '<tr><td colspan="3" width="20" align="left" valign="middle" class="NewsTitlePlayer">';
    if ($_SESSION['gnom'] > 1)
        echo '<input name=id type=radio value=' . $tres['id'] . '>';
    else
        echo "<img src='images/question.png' align='absmiddle'>";
    echo '&nbsp;&nbsp;' . $tres['theme'] . '</td></tr>';
    echo '<tr>';
    echo '<td width="210" align="left" valign="middle" class="NewsDate"><b>' . $txt[146] . '</b> - ' . $txt[$tres['type'] + 150] . '</td>';
    echo '<td width="200" align="center" valign="middle" class="NewsDate">' . $txt[144];
    if ($charview == '')
        echo '<b>' . $tres['charname'] . '</b>';
    else
        echo '<b><a href="' . $charview . $tres['charid'] . '" target="_blank">' . $tres['charname'] . '</a></b>';
    echo '</td>';
    echo '<td width="200" align="right" valign="middle" class="NewsDate"><b>' . $tres['datewrite'] . '</b></td>';
    echo '</tr>';

    echo '<tr><td colspan=3 align="center" valign="middle" class="NewsContent">';
    echo '<br><b>' . $txt[197] . '</b><br>';
    echo $tres['report'];

    if ($tres['adminnote'] != '')
        {
        echo '<hr>';
        echo '<b><font color=red>' . $txt[147] . '</font><br>';
        echo $tres['adminnote'] . '<br>';
        }
    echo '</td></tr>';
    echo '<tr><td width="210" align="left" valign="middle" class="NewsDate"><b>' . $txt[148] . '</b> ' . $txt[$tres['status'] + 163] . '</td>';
    echo '<td colspan=2 align="right" valign="top" class="NewsDate">';
    if ($tres['thanks'] > 0)
        echo '<b><font color=navy>' . $txt[216] . '</font></b>';
    else
        echo '&nbsp;';
    echo '</td></tr>';
    echo '<tr><td colspan=3 height="10" align="center" valign="middle">&nbsp;</td></tr>';
    $kol++;
    }
if ($kol == 1)
    {
    echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>' . $txt[196] . '</b></td></tr>';
}
if ($kolzap['kol'] > $PageBagReport)
    {
    $PagesSelector = '-';
    $PageCounter = ceil($kolzap['kol'] / $PageBagReport);
    if (!isset($_GET['tp']) or ($_GET['tp'] == ''))
        $tp2 = '_';
    else
        $tp2 = (int) $_GET['tp'];
    if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
        $tp3 = 1;
    else
        $tp3 = (int) $_GET['page'];
    for ($i = 1; $i <= $PageCounter; $i++)
        {
        if ($tp3 == $i)
            $PagesSelector .= ' ' . $i . ' -';
        else
            $PagesSelector .= ' <A href="index.php?modul=bagtrack&tp=' . $tp2 . '&page=' . $i . '">' . $i . '</a> -';
        }
    echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>' . $PagesSelector . '</b></td></tr>';
    }
echo '</table>';
if (($_SESSION['gnom'] > 1) and ($kol > 1))
    {
    if ($kol > 1)
        echo '<font color="red">' . $txt[215] . '</font><br>';
    echo '<br><table width="500" height="30" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><b>';
    echo $txt[186] . ' </b><select name=cmd>';
    for ($i = 1; $i <= 11; $i++)
        {
        echo '<option value=';
        echo $i;
        if ($i == 1)
            echo ' selected';
        echo '>';
        echo $txt[197 + $i] . '</option>';
        }
    echo '</select></td><td align="center"><input action="index.php" name="modul" value="bagedit" type=hidden>
           <input type="submit" value="' . $txt[11] . '"></td></tr></table>';
    }
echo '</form>';
?>