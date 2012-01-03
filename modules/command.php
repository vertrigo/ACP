<?php

$lvl = '0';
$gm = $_SESSION['gnom'];
if (isset($_GET['lvl']))
    {
    if ($gm < (int) $_GET['lvl'])
        {
        $lvl = 0;
        } else
        {
        $lvl = (int) $_GET['lvl'];
        }
    }
if ($lvl == '')
    $lvl = '0';
if ($lvl > '5')
    $lvl = '5';
if ($gm > 0)
    {
    echo '
<table border="0" cellspacing="0" cellpadding="0"><tr>
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="0" type=hidden>
<input type="submit" value="' . $txt[70] . '"></form></td>
';
    }
if ($gm >= 1)
    {
    echo '
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="1" type=hidden>
<input type="submit" value="' . $txt[71] . '"></form></td>
';
    }
if ($gm >= 2)
    {
    echo '
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="2" type=hidden>
<input type="submit" value="' . $txt[72] . '"></form></td>
';
    }
if ($gm >= 3)
    {
    echo '
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="3" type=hidden>
<input type="submit" value="' . $txt[73] . '"></form></td>
';
    }
if ($gm >= 4)
    {
    echo '
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="4" type=hidden>
<input type="submit" value="' . $txt[74] . '"></form></td>
';
    }
if ($gm >= 5)
    {
    echo '
<td><form method="get">
<input action="index.php" name="modul" value="command" type=hidden>
<input action="index.php" name="lvl" value="5" type=hidden>
<input type="submit" value="' . $txt[75] . '"></form></td>
';
    }

if ($gm > 0)
    {
    echo '</tr></table>';
    }
echo '<br><table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr><td height="25" colspan="4" align="center" valign="middle" class="TableTitle"><b>' . $txt[68] . '</b> ( ' . $txt[70 + $lvl] . ' )</td></tr>';
$kol = 1;
$m_connect = mysql_connect($m_ip, $m_userdb, $m_pw);
mysql_select_db($m_db, $m_connect);
mysql_query("SET NAMES '$encoding'");
$query = "SELECT `name`,`help` FROM `command` WHERE `security` <= " . $lvl . " order by `name`";
$res = mysql_query($query) or trigger_error(mysql_error() . $query);
while ($mres = mysql_fetch_array($res))
    {
    echo '<tr><td width="40" align="center" valign="middle" class="TableLeft">' . $kol . '</td>';
    echo '<td height="30" width="140" align="left" valign="middle" class="TableCenter"><b>';
    echo $mres['name'] . '</b></td>';
    echo '<td height="30" width="310" align="justify"  valign="middle" class="TableCenter">' . $mres['help'] . '</td><td height="30" width="10" class="TableRight">&nbsp;&nbsp;</td></tr>';
    $kol++;
    }
if ($kol == 1)
    {
    echo '<tr><td height="30" colspan="3" align="center" valign="middle" ><b>' . $txt[69] . '</b></td></tr>';
    }
echo '</table><br>';
?>