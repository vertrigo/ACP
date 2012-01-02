<?php

if (isset($_POST['cmd']) AND ($_SESSION['gnom'] > 1))
    {
    // connect DB
    $k_connect = mysql_connect($k_ip, $k_userdb, $k_pw);
    mysql_select_db($k_db, $k_connect);
    mysql_query("SET NAMES '$encoding'");
    // if....
    if (($_POST['cmd'] > 0) AND !isset($_POST['id']))
        {
        echo $txt[218];
        } else
        {
        // edit
        if (($_POST['cmd'] == 1) AND isset($_POST['id']) AND ($_POST['id'] > 0))
            {
            require("include/edit.php");
            echo $edit_script;
            $edQuery = 'select *  from `bagreports` where `id` = ' . (int) $_POST['id'] . ' limit 1';
            $res = mysql_query($edQuery) or trigger_error(mysql_error());
            $tres = mysql_fetch_array($res);
            echo '<form method="post"><table width="490" border="0" cellspacing="0" cellpadding="0"><tr><td width="80" height="30" align="right" valign="middle">';
            echo $txt[145] . '</td><td width="10" height="30" >&nbsp;</td><td width="400" height="30" align="left" valign="middle"><input name="modul" value="bagtrack" type=hidden>';
            echo '<input name="cmd" value="edit" type=hidden><input type="text" name="tema" size="60" value="' . $tres['theme'] . '"></td></tr>';
            echo '<tr><td width="80" height="30" align="right" valign="middle">' . $txt[146] . '</td><td width="10" height="30" >&nbsp;</td>';
            echo '<td width="400" height="30" align="left" valign="middle"><input type=hidden name="id" value=' . $tres['id'] . ' ><input type=hidden name="charid" value=' . $tres['charid'] . ' >';
            echo '<select name=kategor>';
            for ($i = 1; $i <= 10; $i++)
                {
                echo '<option value="' . $i . '"';
                if ($tres['type'] == $i)
                    echo ' selected>';
                else
                    echo '>';
                echo $txt[$i + 150] . '</option>';
                }
            echo '</select>';
            //       if (($tres['thanks'] == 0) AND ($_SESSION['gnom'] < 2)){
            if ($tres['thanks'] == 0)
                {
                echo '&nbsp;&nbsp;' . $txt[201] . ' <input type=checkbox name=thx value=1> ' . $txt[219] . ' - ' . getgold($ThanksBagReport);
                }
            else
                echo '<font color=navy>' . $txt[220] . '</font>';
            echo '</td></tr></table><b><font color=green>' . $txt[197] . '</font></b><br><textarea name="report" style="width:480">' . $tres['report'] . '</textarea><br>';
            echo'<b><font color=red>' . $txt[147] . '</font></b><br><textarea name="adminnote" style="width:480">' . $tres['adminnote'] . '</textarea><br>';
            echo '<table width="480" border="0" cellspacing="0" cellpadding="0"><tr><td width="80" height="30" align="right" valign="middle">' . $txt[148];
            echo '</td><td width="10" height="30" >&nbsp;</td><td width="260" height="30" align="left" valign="middle"><select name=status>';
            for ($i = 1; $i <= 8; $i++)
                {
                echo '<option value="' . $i . '"';
                if ($tres['status'] + 1 == $i)
                    echo ' selected>';
                else
                    echo '>';
                echo $txt[$i + 162] . '</option>';
                }
            echo '</select><br></td><td width="10" height="30" >&nbsp;</td>';
            echo '<td width="120" height="30" align="right"><input type="submit" value="' . $txt[182] . '"></td></tr></table></form>';
            }
        // end all commands
        }
    }
// access denided!
else
    {
    echo $txt[138];
}
// toolbar menu add
$OtherLink = '<A href="index.php?modul=bagtrack">' . $txt[217] . '</a> | ';
?>
