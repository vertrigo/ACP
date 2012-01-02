<?php

if (!isset($_SESSION['gnom']) or ($_SESSION['gnom'] < 2))
    {
    echo $txt[138];
    rerurn;
    }
// ======== table =========
echo '<div align="center"><h1>' . $txt[178] . '</h1></div><hr>';
$kol = 1;
$k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
mysql_select_db($k_db, $k_connect);
mysql_query("SET NAMES '$encoding'");
$cres = mysql_query("SELECT count(`date`) as kol FROM `news` ") or trigger_error(mysql_error());
$kolzap = mysql_fetch_array($cres);
if ($kolzap['kol'] > $PageNewsEdit)
    {
    $PageLen = $PageNewsEdit;
    if (!isset($_GET['page']) or ($_GET['page'] == ''))
        {
        $StartRec = 0;
        }
    else
        $StartRec = ((int) $_GET['page'] - 1) * $PageNewsEdit;
    }
else
    {
    $PageLen = $PageNewsEdit;
    $StartRec = 0;
    }
$kres = mysql_query("SELECT `id`,`date`,`title`,`text`,`status` FROM `news` ORDER BY `date` DESC limit "
        . $StartRec . "," . $PageLen) or trigger_error(mysql_error());
echo '<form method="post"><table width="90%" border="0" cellspacing="0" cellpadding="5">';
if (mysql_num_rows($kres) > 0)
    {
    while ($nres = mysql_fetch_array($kres))
        {
        echo '<tr><td align="left" class="NewsLogo">';
        echo '<input name=id type=radio value=' . $nres['id'] . '>
		  </td>';
        echo '<td align="left" class="';
        if ($nres['status'] == 2)
            echo 'NewsTitleGM';
        elseif ($nres['status'] == 1)
            echo 'NewsTitlePlayer';
        else
            echo 'NewsTitleAll';
        echo '">' . $nres['title'] . '&nbsp;</td>';
        echo '<td align="right" class="NewsDate">' . $nres['date'] . '</td>';
        echo '</tr>';
        $kol++;
        }
    if ($kolzap['kol'] > $PageNewsEdit)
        {
        $PagesSelector = '-';
        $PageCounter = ceil($kolzap['kol'] / $PageNewsEdit);
        if (!isset($_GET['page']) OR ($_GET['page'] == '') OR ($_GET['page'] == '_'))
            $tp3 = 1;
        else
            $tp3 = (int) $_GET['page'];
        for ($i = 1; $i <= $PageCounter; $i++)
            {
            if ($tp3 == $i)
                $PagesSelector .= ' ' . $i . ' -';
            else
                $PagesSelector .= ' <A href="index.php?modul=newsedit&page=' . $i . '">' . $i . '</a> -';
            }
        echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>' . $PagesSelector
        . '</b></td></tr>';
        }
    }
echo '</table>';
if ($kol > 1)
    echo '<font color="red">' . $txt[185] . '</font><br>';
echo '<br><table width="500" height="30" border="0" cellpadding="0" cellspacing="0"><tr><td align="center"><b>' . $txt[186];
echo '</b>&nbsp;&nbsp;<select name=cmd>';
if ($kol > 1)
    {
    echo '<option value=1 selected>' . $txt[182] . '</option>';
    echo '<option value=2>' . $txt[183] . '</option>';
    }
else
    echo '<option value=2 selected>' . $txt[183] . '</option>';
echo '<option value=3>' . $txt[184] . '</option></select></td><td align="center">';
echo '<input action="index.php" name="modul" value="newsedit" type=hidden><input type="submit" value="' . $txt[11] . '"></td></tr></table>';
echo '<hr></form>';
// ========== edit ===========
if (isset($_POST['cmd']))
    {
    // forma
    require("include/edit.php");
    echo $edit_script;
    // edit
    if (isset($_POST['id']) AND ($_POST['cmd'] == 1) AND ($_POST['id'] > 0))
        {
        $nres = mysql_query("select * from `news` where `id` = " . $_POST['id'] . ' limit 1') or trigger_error(mysql_error());
        $nr = mysql_fetch_assoc($nres);
        echo '<br><form method="post"><div align="center"><b>' . $txt[190] . '</b></div><br>';
        echo '<table width="620" border="0" cellspacing="0" cellpadding="0">
             <tr><td width="100" height="30" align="right" valign="middle">' . $txt[145] . '</td><td width="10" height="30" >&nbsp;</td>
             <td width="510" height="30" align="left" valign="middle"><input name="modul" value="newsedit" type=hidden>
			 <input type="text" name="tema" size="60" value="' . $nr['title'] . '"></td></tr>
             <tr><td width="100" height="30" align="right" valign="middle">' . $txt[146] . '</td><td width="10" height="30" >&nbsp;</td>
             <td width="510" height="30" align="left" valign="middle"><input name="cmd" value="51" type=hidden><input name="guid" value="' . $nr['id'] . '" type=hidden>';
        echo '<select name=kat>';
        if ($nr['status'] == 0)
            echo '<option value=1 selected>' . $txt[173] . '</option>';
        else
            echo '<option value=1>' . $txt[173] . '</option>';
        if ($nr['status'] == 1)
            echo '<option value=2 selected>' . $txt[174] . '</option>';
        else
            echo '<option value=2>' . $txt[174] . '</option>';
        if ($nr['status'] == 2)
            echo '<option value=3 selected>' . $txt[175] . '</option>';
        else
            echo '<option value=3>' . $txt[175] . '</option>';
        echo '</select>';
        echo '</td></tr></table><textarea name="news" style="width:490">' . $nr['text'] . '</textarea><br>';
        if (isset($_GET['page']))
            echo '<input type="hidden" name=page value=' . (int) $_GET['page'] . '>';
        echo '<input type="submit" value="' . $txt[182] . '"></form>';
        }
    // edit 2 - save
    if ($_POST['cmd'] == 51)
        {
        if ($_POST['tema'] <> '')
            $nt = addslashes($_POST['tema']);
        else
            $nt = $txt[172 + $_POST['kat']];
        $addQuery = 'update `news` set `title` = "' . $nt . '", `text`="' . text_optimazer($_POST['news']) . '", `status` = ' . ((int) $_POST['kat'] - 1) . ' where `id` = ' . (int) $_POST['guid'];
        mysql_query($addQuery) or trigger_error(mysql_error());
        echo '
<script type="text/javascript"> <!--
window.status = "";
window.location = "index.php?modul=newsedit';
        if (isset($_POST['page']))
            echo '&page=' . (int) $_POST['page'];
        echo '";
    //--> </script>';
        }
    // add
    if ($_POST['cmd'] == 2)
        {
        echo '<br><form method="post"><div align="center"><b>' . $txt[188] . '</b></div><br>';
        echo '<table width="620" border="0" cellspacing="0" cellpadding="0">
             <tr><td width="100" height="30" align="right" valign="middle">' . $txt[145] . '</td><td width="10" height="30" >&nbsp;</td>
             <td width="510" height="30" align="left" valign="middle"><input name="modul" value="newsedit" type=hidden><input type="text" name="tema" size="60"></td></tr>
             <tr><td width="100" height="30" align="right" valign="middle">' . $txt[146] . '</td><td width="10" height="30" >&nbsp;</td>
             <td width="510" height="30" align="left" valign="middle"><input name="cmd" value="50" type=hidden>';
        echo '<select name=kat> 
             <option value=1 selected>' . $txt[173] . '</option>
             <option value=2>' . $txt[174] . '</option>
             <option value=3>' . $txt[175] . '</option></select>';
        echo '</td></tr></table><textarea name="news" style="width:610"></textarea><br>';
        echo '<input type="submit" value="' . $txt[183] . '"></form>';
        }
    // add 2 - save
    if ($_POST['cmd'] == 50)
        {
        if ($_POST['tema'] <> '')
            $nt = addslashes($_POST['tema']);
        else
            $nt = $txt[172 + (int) $_POST['kat']];
        $addQuery = 'insert into `news` (`title`,`text`,`status`) values ("' . $nt . '","' . text_optimazer($_POST['news']) . '",' . ((int) $_POST['kat'] - 1) . ')';
        mysql_query($addQuery) or trigger_error(mysql_error());
        echo '
<script type="text/javascript"> <!--
window.status = "";
window.location = "index.php?modul=newsedit";
//--> </script>';
        }
    // delete
    if (isset($_POST['id']) AND ($_POST['cmd'] == 3) AND ($_POST['id'] > 0))
        {
        mysql_query("delete from `news` where `id` = " . (int) $_POST['id']) or trigger_error(mysql_error());
        echo '
<script type="text/javascript"> <!--
window.status = "";
window.location = "index.php?modul=newsedit";
//--> </script>';
        }
    }
?>